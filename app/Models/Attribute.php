<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Класс модели атрибута.
 *
 * @property int                        $id         Идентификатор атрибута
 * @property string                     $name       Название атрибута
 * @property string                     $type       Тип атрибута (например, 'radio', 'checkbox', 'select')
 * @property string|null                $options    Сериализованные в JSON варианты атрибута
 * @property string|null                $comment    Комментарий к атрибуту
 *
 * @property-read Collection|Category[] $categories Связанные категории
 */
class Attribute extends Model
{
    use FactoryModel;

    protected $fillable = [
        'name',
        'type',
        'options',
        'comment',
    ];

    protected $casts = [
        'options' => 'array'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_attribute');
    }

    public function getOptionsAttribute($value)
    {
        return json_decode($value);
    }

    // Мутатор для поля 'options'
    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
