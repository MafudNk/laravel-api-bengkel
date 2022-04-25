<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\t_penerimaan_barang_detailRepository;
use App\Entities\TPenerimaanBarangDetail;
use App\Validators\TPenerimaanBarangDetailValidator;

/**
 * Class TPenerimaanBarangDetailRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TPenerimaanBarangDetailRepositoryEloquent extends BaseRepository implements TPenerimaanBarangDetailRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TPenerimaanBarangDetail::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
