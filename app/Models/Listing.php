<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Объявление на продажу
 *
 * @property integer                     $id          ID
 * @property string                      $title       Название
 * @property string                      $description Описание
 * @property float                       $price       Цена
 * @property integer                     $user_id     ID пользователя
 * @property Carbon                      $deleted_at  Удалено
 * @property Carbon                      $created_at  Создано
 * @property Carbon                      $updated_at  Обновлено
 * @property-read User                   $user        Автор
 * @property-read Category               $category    Категория
 * @property-read Attribute[]|Collection $attributes  Атрибуты
 */
class Listing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'price',
        'category_id',
        'user_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'listing_attribute')
            ->withPivot('value');
    }
}
