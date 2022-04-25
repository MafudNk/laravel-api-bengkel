<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\t_penerimaan_barangRepository;
use App\Entities\TPenerimaanBarang;
use App\Validators\TPenerimaanBarangValidator;

/**
 * Class TPenerimaanBarangRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TPenerimaanBarangRepositoryEloquent extends BaseRepository implements TPenerimaanBarangRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TPenerimaanBarang::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
