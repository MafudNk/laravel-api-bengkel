<?php

namespace App\Presenters;

use App\Transformers\MSupplierTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class MSupplierPresenter.
 *
 * @package namespace App\Presenters;
 */
class MSupplierPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new MSupplierTransformer();
    }
}
