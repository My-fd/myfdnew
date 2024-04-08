<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 *
 * @property int                       $id                ID пользователя
 * @property string                    $nickname          Никнейм
 * @property string                    $name              Имя
 * @property string                    $surname           Фамилия
 * @property string                    $email             Почта
 * @property string                    $password          Пароль (зашифрован)
 * @property string|null               $patronymic        Отчество
 * @property string|null               $about             Раздел "О себе"
 * @property string|null               $city              Город
 * @property string|null               $phone             Телефон
 * @property string|null               $country_code      Код страны
 * @property string|null               $remember_token    Токен авторизации
 * @property Carbon|null               $email_verified_at Когда подтвердил почту
 * @property Carbon                    $created_at        Когда создан
 * @property Carbon                    $updated_at        Когда обновлён
 * @property-read Listing[]|Collection $listings          Объявления
 * @property-read Address[]|Collection $addresses         Адреса
 *
 * @method static create(array $attributes)
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable, FactoryModel;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'nickname',
        'email',
        'password',
        'login',
        'surname',
        'patronymic',
        'about',
        'email',
        'email_verified_at',
        'phone',
        'country_code',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Получить все объявления пользователя.
     */
    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }

    /**
     * Генерирует никнейм
     *
     * @return string
     */
    private function fakeNickname(): string
    {
        return $this->faker->userName;
    }

    /**
     * Генерирует имя
     *
     * @return string
     */
    private function fakeName(): string
    {
        return $this->faker->firstName;
    }

    /**
     * Генерирует фамилию
     *
     * @return string
     */
    private function fakeSurname(): string
    {
        return $this->faker->lastName;
    }

    /**
     * Генерирует отчество
     *
     * @return string|null
     */
    private function fakePatronymic(): ?string
    {
        return $this->faker->randomElement([null, $this->faker->firstName]);
    }

    /**
     * Генерирует раздел "О себе"
     *
     * @return string|null
     */
    private function fakeAbout(): ?string
    {
        return $this->faker->randomElement([null, $this->faker->paragraph]);
    }

    /**
     * Генерирует почту
     *
     * @return string
     */
    private function fakeEmail(): string
    {
        return $this->faker->email;
    }

    /**
     * Генерирует пароль
     *
     * @return string
     */
    private function fakePassword(): string
    {
        return Hash::make('password');
    }

    /**
     * Генерирует телефон
     *
     * @return string
     */
    private function fakePhone(): string
    {
        return $this->faker->phoneNumber;
    }

    /**
     * Генерирует код страны
     *
     * @return string|null
     */
    private function fakeCountryCode(): ?string
    {
        return 'ru';
    }
}
