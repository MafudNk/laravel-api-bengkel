<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\m_supplierRepository;
use App\Entities\MSupplier;
use App\Validators\MSupplierValidator;

/**
 * Class MSupplierRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MSupplierRepositoryEloquent extends BaseRepository implements MSupplierRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MSupplier::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MSupplierValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
