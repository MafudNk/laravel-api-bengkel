<?php

namespace App\Presenters;

use App\Transformers\TPerbaikanJasaTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class TPerbaikanJasaPresenter.
 *
 * @package namespace App\Presenters;
 */
class TPerbaikanJasaPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new TPerbaikanJasaTransformer();
    }
}
