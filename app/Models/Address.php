<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * Class Address
 *
 * @property int                       $id              Идентификатор
 * @property int                       $user_id         ID пользователя
 * @property string|null               $country         Страна
 * @property string|null               $city            Город
 * @property string|null               $street          Улица
 * @property string|null               $house_number    Номер дома
 * @property string|null               $floor           Квартира
 * @property int|null                  $zip             Почтовый индекс
 * @property string|null               $additional_info Дополнительная информация
 * @property Carbon|null               $created_at      Создано
 * @property Carbon|null               $updated_at      Изменено
 *
 * @property-read User                 $user
 * @property-read Listing[]|Collection $listings
 *
 * @package App\Models
 */
class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'addresses';

    protected $fillable = [
        'user_id',
        'country',
        'city',
        'street',
        'house_number',
        'floor',
        'zip',
        'additional_info',
    ];

    /**
     * Определение отношения с моделью User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Определение отношения с моделью User.
     */
    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }
}