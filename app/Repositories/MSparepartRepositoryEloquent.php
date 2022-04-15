<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\m_sparepartRepository;
use App\Entities\MSparepart;
use App\Validators\MSparepartValidator;

/**
 * Class MSparepartRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MSparepartRepositoryEloquent extends BaseRepository implements MSparepartRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MSparepart::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MSparepartValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
