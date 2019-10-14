<?php

namespace App\Presenters;

use App\Transformers\RecentTransferTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class RecentTransferPresenter.
 *
 * @package namespace App\Presenters;
 */
class RecentTransferPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new RecentTransferTransformer();
    }
}
