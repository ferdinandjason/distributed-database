<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MenuRestaurantRepository;
use App\Entities\MenuRestaurant;
use App\Validators\MenuRestaurantValidator;
use Illuminate\Support\Facades\DB;

/**
 * Class MenuRestaurantRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MenuRestaurantRepositoryEloquent extends BaseRepository implements MenuRestaurantRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MenuRestaurant::class;
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

    public function getMenu($id)
    {
        return $this->model->where('restaurant_id',$id)->where('stok','>=',0)->get();
    }
    
}
