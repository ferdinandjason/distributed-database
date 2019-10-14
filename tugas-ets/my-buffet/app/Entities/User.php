<?php

namespace App\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class User.
 *
 * @package namespace App\Entities;
 */
class User extends Authenticatable implements Transformable
{
    use Notifiable;
    use TransformableTrait;

    const ATTRIBUTE_ID = 'id';
    const ATTRIBUTE_NAMA = 'nama';
    const ATTRIBUTE_USERNAME = 'username';
    const ATTRIBUTE_EMAIL = 'email';
    const ATTRIBUTE_PASSWORD = 'password';
    const ATTRIBUTE_ALAMAT = 'alamat';
    const ATTRIBUTE_NOMOR_TELEPON = 'nomor_telepon';
    const ATTRIBUTE_AVATAR = 'avatar';

    const ROLE_ADMIN = 1;
    const ROLE_NON_ADMIN = 0;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        User::ATTRIBUTE_NAMA,
        User::ATTRIBUTE_USERNAME,
        User::ATTRIBUTE_EMAIL,
        User::ATTRIBUTE_PASSWORD,
        User::ATTRIBUTE_ALAMAT,
        User::ATTRIBUTE_NOMOR_TELEPON,
        User::ATTRIBUTE_AVATAR,
    ];

}
