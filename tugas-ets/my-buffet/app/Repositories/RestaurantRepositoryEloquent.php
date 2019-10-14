<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\RestaurantRepository;
use App\Entities\Restaurant;
use App\Validators\RestaurantValidator;

/**
 * Class RestaurantRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class RestaurantRepositoryEloquent extends BaseRepository implements RestaurantRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Restaurant::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return null;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function restaurantWithMenu()
    {
        return Restaurant::with('menu')->get();
    }
    
}
