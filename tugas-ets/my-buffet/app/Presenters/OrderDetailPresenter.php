<?php

namespace App\Presenters;

use App\Transformers\OrderDetailTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OrderDetailPresenter.
 *
 * @package namespace App\Presenters;
 */
class OrderDetailPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OrderDetailTransformer();
    }
}
