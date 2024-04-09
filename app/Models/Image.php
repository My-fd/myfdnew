<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Модель Image представляет изображение, связанное с объявлением.
 *
 * @property int $id
 * @property string $path Путь к файлу изображения
 * @property int $listing_id ID объявления, к которому принадлежит изображение
 * @property-read string $url Полный URL изображения
 * @property-read Listing $listing Связанное объявление
 */
class Image extends Model
{
    use HasFactory;

    protected $fillable = ['path', 'listing_id'];

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    public function getUrlAttribute(): string
    {
        return asset('storage/' . $this->path);
    }
}
