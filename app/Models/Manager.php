<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Менеджер админки
 * @property int         $id
 * @property string      $full_name
 * @property string      $email
 * @property string|null $password
 * @property array       $roles
 */
class Manager extends Authenticatable
{
    use HasFactory;

    const SYSTEM_MANAGER_EMAIL = 'system@storyport.ru';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'roles',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'roles' => 'array',
    ];

    public static function getSystemManager(): Manager|null
    {
        return Manager::query()->where('email', Manager::SYSTEM_MANAGER_EMAIL)->first();
    }
}