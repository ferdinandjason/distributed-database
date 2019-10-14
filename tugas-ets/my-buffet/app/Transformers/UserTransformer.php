<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\User;

/**
 * Class UserTransformer.
 *
 * @package namespace App\Transformers;
 */
class UserTransformer extends TransformerAbstract
{
    /**
     * Transform the User entity.
     *
     * @param \App\Entities\User $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id'             => (int) $model->id,
            'nama'           => $model->nama,
            'username'       => $model->username,
            'email'          => $model->email,
            'alamat'         => $model->alamat,
            'nomor_telepon'  => $model->nomor_telepon,
            'created_at'     => $model->created_at,
            'updated_at'     => $model->updated_at
        ];
    }
}
