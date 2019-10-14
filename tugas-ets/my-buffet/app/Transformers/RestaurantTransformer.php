<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\Restaurant;

/**
 * Class RestaurantTransformer.
 *
 * @package namespace App\Transformers;
 */
class RestaurantTransformer extends TransformerAbstract
{
    /**
     * Transform the Restaurant entity.
     *
     * @param \App\Entities\Restaurant $model
     *
     * @return array
     */
    public function transform(Restaurant $model)
    {
        return [
            'id'             => (int) $model->id,
            'nama'           => $model->nama,
            'username'       => $model->username,
            'alamat'         => $model->alamat,
            'nomor_telepon'  => $model->nomor_telepon,
            'created_at'     => $model->created_at,
            'updated_at'     => $model->updated_at
        ];
    }
}
