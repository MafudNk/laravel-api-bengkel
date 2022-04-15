<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\t_perbaikanRepository;
use App\Entities\TPerbaikan;
use App\Validators\TPerbaikanValidator;

/**
 * Class TPerbaikanRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TPerbaikanRepositoryEloquent extends BaseRepository implements TPerbaikanRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TPerbaikan::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return TPerbaikanValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
