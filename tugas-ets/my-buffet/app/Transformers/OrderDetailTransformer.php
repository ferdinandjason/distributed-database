<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\OrderDetail;

/**
 * Class OrderDetailTransformer.
 *
 * @package namespace App\Transformers;
 */
class OrderDetailTransformer extends TransformerAbstract
{
    /**
     * Transform the OrderDetail entity.
     *
     * @param \App\Entities\OrderDetail $model
     *
     * @return array
     */
    public function transform(OrderDetail $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
