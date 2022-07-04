<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\t_perbaikan_jasaRepository;
use App\Entities\TPerbaikanJasa;
use App\Validators\TPerbaikanJasaValidator;

/**
 * Class TPerbaikanJasaRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TPerbaikanJasaRepositoryEloquent extends BaseRepository implements TPerbaikanJasaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TPerbaikanJasa::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return TPerbaikanJasaValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
