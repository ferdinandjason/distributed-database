<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\OrderRepository;
use App\Entities\Order;
use App\Validators\OrderValidator;
use Illuminate\Support\Facades\DB;

/**
 * Class OrderRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OrderRepositoryEloquent extends BaseRepository implements OrderRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Order::class;
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

    public function findOrderWithRestaurantId($id)
    {
        return $this->model->with(['details', 'restaurant'])->where('restaurant_id',$id)->where('status',2)->get();
    }

    public function findOrderHistory($id)
    {
        return $this->model->with(['details', 'restaurant'])->where('restaurant_id',$id)->where('status',3)->orWhere('status',2)->get();
    }

    public function changeStatusToDone($id)
    {
        $this->model->where('id',$id)->update(['status' => 3]);
    }

    public function changeStatusToPlaced($id)
    {
        $this->model->where('id',$id)->update(['status' => 2]);
    }

    public function changeStatusToConfirmed($id)
    {
        $this->model->where('id',$id)->update(['status' => 1]);
    }

    public function recentResto($id)
    {
        return $this->model->with(['restaurant'])->groupBy('restaurant_id')->where('user_id',$id)->select('restaurant_id')->get();
    }

    public function getBestResto()
    {
        return $this->model->with(['restaurant'])->select('restaurant_id',DB::raw('count(id) as total'))->groupBy('restaurant_id')->orderBy('total','desc')->get();
    }

    public function getLastOrder()
    {
        return $this->model->orderBy('created_at', 'desc')->first();
    }

    public function allReversed()
    {
        return $this->model->orderBy('created_at', 'desc')->get();
    }
    
}
