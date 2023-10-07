<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Объявление на продажу
 *
 * @property integer  $id          ID
 * @property string   $title       Название
 * @property string   $description Описание
 * @property float    $price       Цена
 * @property Category $category    Категория
 * @property Carbon   $deleted_at  Удалено
 * @property Carbon   $created_at  Создано
 * @property Carbon   $updated_at  Обновлено
 */
class Listing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'price',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
