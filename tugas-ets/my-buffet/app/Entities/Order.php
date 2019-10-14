<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Order.
 *
 * @package namespace App\Entities;
 */
class Order extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    const ATTRIBUTE_ID = 'id';
    const ATTRIBUTE_USER_ID = 'user_id';
    const ATTRIBUTE_RESTAURANT_ID = 'restaurant_id';
    const ATTRIBUTE_COMMENTS = 'comments';
    const ATTRIBUTE_TOTAL = 'total';
    const ATTRIBUTE_STATUS = 'status';
    const ATTRIBUTE_DELIVERY = 'delivery';
    const ATTRIBUTE_ALAMAT = 'alamat';

    const ORDER_RAW = 0;
    const ORDER_CONFIRMED = 1;
    const ORDER_PLACED = 2;
    const ORDER_DONE = 3;

    const FOOD_PICKUP = 0;
    const FOOD_DELIVERY = 1;

    protected $fillable = [
        Order::ATTRIBUTE_ID,
        Order::ATTRIBUTE_USER_ID,
        Order::ATTRIBUTE_RESTAURANT_ID,
        Order::ATTRIBUTE_COMMENTS,
        Order::ATTRIBUTE_TOTAL,
        Order::ATTRIBUTE_STATUS,
        Order::ATTRIBUTE_DELIVERY,
        Order::ATTRIBUTE_ALAMAT,
    ];

    public function details(){
        return $this->hasMany('App\Entities\OrderDetail');
    }

    public function user(){
        return $this->belongsTo('App\Entities\User');
    }

    public function restaurant(){
        return $this->belongsTo('App\Entities\Restaurant');
    }
    
}
