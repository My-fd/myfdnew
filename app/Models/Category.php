<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель категории
 *
 * @property int                         $id         Идентификатор
 * @property int|null                    $parent_id  Идентификатор родительской категории
 * @property string                      $name       Название категории
 * @property string                      $image_url  Ссылка на картинку
 * @property Carbon                      $created_at Создано
 * @property Carbon                      $updated_at Обновлено
 * @property-read Category               $parent     Родитель
 * @property-read Category[]|Collection  $children   Дети
 * @property-read Attribute[]|Collection $attributes Атрибуты
 *
 * Class Category
 * @package App\Models
 */
class Category extends Model
{
    use FactoryModel;

    const FILE_DIR = '/categories';

    protected $fillable = [
        'name',
        'image_url',
        'parent_id',
    ];

    /**
     * Получить подкатегории.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Получить родительскую категорию.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'category_attribute');
    }
}
