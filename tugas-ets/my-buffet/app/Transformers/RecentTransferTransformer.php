<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\RecentTransfer;

/**
 * Class RecentTransferTransformer.
 *
 * @package namespace App\Transformers;
 */
class RecentTransferTransformer extends TransformerAbstract
{
    /**
     * Transform the RecentTransfer entity.
     *
     * @param \App\Entities\RecentTransfer $model
     *
     * @return array
     */
    public function transform(RecentTransfer $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
