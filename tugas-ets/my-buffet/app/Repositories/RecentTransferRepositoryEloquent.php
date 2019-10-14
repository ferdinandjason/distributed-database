<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RecentTransferRepository;
use App\Entities\RecentTransfer;
use App\Validators\RecentTransferValidator;

/**
 * Class RecentTransferRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RecentTransferRepositoryEloquent extends BaseRepository implements RecentTransferRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RecentTransfer::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return RecentTransferValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
