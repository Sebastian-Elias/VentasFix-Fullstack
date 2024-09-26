<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    //paso 1: php artisan make:migration modify_users_table

    protected $fillable = [
        'rut',
        'nombre',
        'apellido',
        'email',
        'password',
        'rol_id',
        'activo',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => 'boolean'
        ];
    }

    /**
     * Setter for email to ensure all emails are from @ventasfix.cl domain
     */
    public function setEmailAttribute($value)
    {
        if (!str_ends_with($value, '@ventasfix.cl')) {
            throw new \Exception('El correo debe ser del dominio @ventasfix.cl.');
        }
        $this->attributes['email'] = $value;
    }
}
