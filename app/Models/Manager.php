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
 * @property string      $name
 * @property string      $surname
 * @property string      $email
 * @property string|null $password
 * @property array       $roles
 */
class Manager extends Authenticatable
{
    use HasFactory, FactoryModel;

    const SYSTEM_MANAGER_EMAIL = 'admin@example.org';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
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

    public function getFullName()
    {
        return $this->name . ' ' . $this->surname;
    }
}