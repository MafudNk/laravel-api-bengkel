<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\MSupplier;

/**
 * Class MSupplierTransformer.
 *
 * @package namespace App\Transformers;
 */
class MSupplierTransformer extends TransformerAbstract
{
    /**
     * Transform the MSupplier entity.
     *
     * @param \App\Entities\MSupplier $model
     *
     * @return array
     */
    public function transform(MSupplier $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
