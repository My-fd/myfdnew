<?php

namespace App\Models;

use App\Helpers\FillFaker;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Jenssegers\Mongodb\Eloquent\Model as MongoModel;

/**
 * Модель совмещающая в себе возможности фабрики
 */
trait FactoryModel
{
    /**
     * Фейкер
     *
     * @var FillFaker
     */
    protected $faker;

    /**
     * Поля, которые были явно установлены в модель.
     * Это сделано для того что бы разделить не установленные поля, от полей в которым было установлено значение null
     *
     * @var array
     */
    protected $dynamicallyFilledProperties = [];

    /**
     * Заполняет все не заполненные поля модели, вызывая специальные методы  самой модели
     * Если ваше поле называется как "first_title", то для нее будет вызван метод "fakeFirstTitle()"
     */
    public function fillFake(): void
    {
        if (!$this->faker) {
            $this->faker = App::make(FillFaker::class);
            $this->faker = $this->faker->create();
        }

        $fields = array_unique(array_merge($this->getFillable(), $this->getDates(), $this->getHidden()));

        foreach ($fields as $field) {
            // Проверяем существование поля, если поле уже существует то не перезаписываем его
            if ($this->$field === null && !in_array($field, $this->dynamicallyFilledProperties)) {
                $functionName = sprintf('fake%s', Str::ucfirst(Str::camel($field)));

                if (method_exists($this, $functionName)) {
                    $this->$field = $this->$functionName();
                }
            }
        }
    }

    /**
     * Генерируем валидный email адрес
     *
     * @return string
     */
    public function fakeValidEmail(): string
    {
        return explode('@', $this->faker->email())[0] . $this->getDefaultEmailDomain();
    }

    /**
     * Инстанцирует и заполняет модель
     *
     * @param array $params
     * @return Model|MongoModel
     * @static
     */
    public static function makeOne(array $params = []): Model|MongoModel
    {
        /** @var Model|MongoModel $model */
        $className = self::class;
        $model = new $className($params);
        $model->fillFake();

        return $model;
    }

    /**
     * Инстанцирует, заполняет и сохраняет модель
     *
     * @param array $params
     * @return Model|MongoModel
     * @static
     */
    public static function createOne(array $params = []): Model|MongoModel
    {
        /** @var Model|MongoModel $model */
        $model = self::makeOne($params);
        $model->save();

        return $model;
    }

    /**
     * Инстанцирует и заполняет модели
     *
     * @param int   $count
     * @param array $params
     * @return Collection
     * @static
     */
    public static function makeMany(int $count, array $params = []): Collection
    {
        $collection = new Collection();
        for ($i = 0; $i < $count; $i++) {
            $collection->add(self::makeOne($params));
            usleep(100);
        }

        return $collection;
    }

    /**
     * Инстанцирует, заполняет и сохраняет модели
     *
     * @param int   $count
     * @param array $params
     * @return Collection
     * @static
     */
    public static function createMany(int $count, array $params = []): Collection
    {
        $collection = new Collection();
        for ($i = 0; $i < $count; $i++) {
            $collection->add(self::createOne($params));
        }

        return $collection;
    }

    /**
     * Поля, которые были явно установлены в модель.
     * Это сделано для того что бы разделить не установленные поля, от полей в которым было установлено значение null
     *
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->dynamicallyFilledProperties[] = $name;

        parent::__set($name, $value);
    }

    /**
     * Генерирует дату создания
     *
     * @return Carbon
     */
    private function fakeCreatedAt(): Carbon
    {
        return new Carbon();
    }

    /**
     * Генерирует дату обновления
     *
     * @return Carbon
     */
    private function fakeUpdatedAt(): Carbon
    {
        return new Carbon();
    }

    /**
     * Дефолтный домен email адреса
     *
     * @return string
     */
    private function getDefaultEmailDomain(): string
    {
        return '@kostylworks.ru';
    }
}