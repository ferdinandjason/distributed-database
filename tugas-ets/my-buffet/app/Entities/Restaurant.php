<?php

namespace App\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Restaurant.
 *
 * @package namespace App\Entities;
 */
class Restaurant extends Authenticatable implements Transformable
{
    use Notifiable;
    use TransformableTrait;

    const ATTRIBUTE_ID = 'id';
    const ATTRIBUTE_NAMA = 'nama';
    const ATTRIBUTE_USERNAME = 'username';
    const ATTRIBUTE_PASSWORD = 'password';
    const ATTRIBUTE_ALAMAT = 'alamat';
    const ATTRIBUTE_NOMOR_TELEPON = 'nomor_telepon';
    const ATTRIBUTE_AVATAR = 'avatar';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        Restaurant::ATTRIBUTE_NAMA,
        Restaurant::ATTRIBUTE_USERNAME,
        Restaurant::ATTRIBUTE_PASSWORD,
        Restaurant::ATTRIBUTE_ALAMAT,
        Restaurant::ATTRIBUTE_NOMOR_TELEPON,
        Restaurant::ATTRIBUTE_AVATAR,
    ];

    public function menu()
    {
        return $this->hasMany('\App\Entities\MenuRestaurant');
    }

}
