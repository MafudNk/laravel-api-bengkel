<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Entities\TPerbaikanJasa;

/**
 * Class TPerbaikanJasaTransformer.
 *
 * @package namespace App\Transformers;
 */
class TPerbaikanJasaTransformer extends TransformerAbstract
{
    /**
     * Transform the TPerbaikanJasa entity.
     *
     * @param \App\Entities\TPerbaikanJasa $model
     *
     * @return array
     */
    public function transform(TPerbaikanJasa $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
