<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Объявление на продажу
 *
 * @property integer                     $id          ID
 * @property string                      $title       Название
 * @property string                      $description Описание
 * @property float                       $price       Цена
 * @property integer                     $user_id     ID пользователя
 * @property integer|null                $address_id  ID адреса
 * @property Carbon                      $deleted_at  Удалено
 * @property Carbon                      $created_at  Создано
 * @property Carbon                      $updated_at  Обновлено
 * @property-read User                   $user        Автор
 * @property-read Address                $address     Адрес
 * @property-read Category               $category    Категория
 * @property-read Attribute[]|Collection $attributes  Атрибуты
 * @property-read Image[]|Collection     $images      Изображения
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
        'address_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'listing_attribute')
            ->withPivot('value');
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }
}
