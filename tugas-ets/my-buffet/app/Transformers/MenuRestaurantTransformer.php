<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\MenuRestaurant;

/**
 * Class MenuRestaurantTransformer.
 *
 * @package namespace App\Transformers;
 */
class MenuRestaurantTransformer extends TransformerAbstract
{
    /**
     * Transform the MenuRestaurant entity.
     *
     * @param \App\Entities\MenuRestaurant $model
     *
     * @return array
     */
    public function transform(MenuRestaurant $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
