<?php

namespace App\Presenters;

use App\Transformers\MenuRestaurantTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MenuRestaurantPresenter.
 *
 * @package namespace App\Presenters;
 */
class MenuRestaurantPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MenuRestaurantTransformer();
    }
}
