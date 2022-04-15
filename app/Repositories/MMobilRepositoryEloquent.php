<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\m_mobilRepository;
use App\Entities\MMobil;
use App\Validators\MMobilValidator;

/**
 * Class MMobilRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MMobilRepositoryEloquent extends BaseRepository implements MMobilRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MMobil::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
