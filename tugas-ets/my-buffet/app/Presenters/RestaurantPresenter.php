<?php

namespace App\Presenters;

use App\Transformers\RestaurantTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class RestaurantPresenter.
 *
 * @package namespace App\Presenters;
 */
class RestaurantPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RestaurantTransformer();
    }
}
