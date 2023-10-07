<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель категории
 *
 * @property int    $id         Идентификатор адреса
 * @property string $name       Название категории
 * @property string $image_url  Ссылка на картинку
 * @property Carbon $created_at Создано
 * @property Carbon $updated_at Обновлено
 *
 * Class Category
 * @package App\Models
 */
class Category extends Model
{
    use HasFactory;

    const FILE_DIR = '/categories';

    protected $fillable = [
        'name',
        'image_url',
    ];
}
