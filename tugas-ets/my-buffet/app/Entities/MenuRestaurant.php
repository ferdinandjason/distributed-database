<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class MenuRestaurant.
 *
 * @package namespace App\Entities;
 */
class MenuRestaurant extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    const ATTRIBUTE_ID = 'id';
    const ATTRIBUTE_RESTAURANT_ID = 'restaurant_id';
    const ATTRIBUTE_NAMA = 'nama_makanan';
    const ATTRIBUTE_DESKRIPSI = 'deskripsi';
    const ATTRIBUTE_KATEGORI = 'kategori';
    const ATTRIBUTE_HARGA = 'harga';
    const ATTRIBUTE_FOTO = 'foto';
    const ATTRIBUTE_STOK = 'stok';

    protected $fillable = [
        MenuRestaurant::ATTRIBUTE_ID,
        MenuRestaurant::ATTRIBUTE_RESTAURANT_ID,
        MenuRestaurant::ATTRIBUTE_NAMA,
        MenuRestaurant::ATTRIBUTE_DESKRIPSI,
        MenuRestaurant::ATTRIBUTE_KATEGORI,
        MenuRestaurant::ATTRIBUTE_HARGA,
        MenuRestaurant::ATTRIBUTE_FOTO,
        MenuRestaurant::ATTRIBUTE_STOK
    ];

    public function restaurant()
    {
        return $this->belongsTo('App\Entities\Restaurant');
    }

}
