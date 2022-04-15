<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\t_detail_perbaikanRepository;
use App\Entities\TDetailPerbaikan;
use App\Validators\TDetailPerbaikanValidator;

/**
 * Class TDetailPerbaikanRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TDetailPerbaikanRepositoryEloquent extends BaseRepository implements TDetailPerbaikanRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TDetailPerbaikan::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
