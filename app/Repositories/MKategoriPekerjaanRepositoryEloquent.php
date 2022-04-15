<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\m_kategori_pekerjaanRepository;
use App\Entities\MKategoriPekerjaan;
use App\Validators\MKategoriPekerjaanValidator;

/**
 * Class MKategoriPekerjaanRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MKategoriPekerjaanRepositoryEloquent extends BaseRepository implements MKategoriPekerjaanRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MKategoriPekerjaan::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
