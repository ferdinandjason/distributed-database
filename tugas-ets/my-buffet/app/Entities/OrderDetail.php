<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class OrderDetail.
 *
 * @package namespace App\Entities;
 */
class OrderDetail extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    const ATTRIBUTE_ID = 'id';
    const ATTRIBUTE_ORDER_ID = 'order_id';
    const ATTRIBUTE_MENU_RESTAURANT_ID = 'menu_restaurant_id';
    const ATTRIBUTE_AMOUNT = 'amount';
    const ATTRIBUTE_SUB_TOTAL = 'sub_total';

    protected $fillable = [
        OrderDetail::ATTRIBUTE_ID,
        OrderDetail::ATTRIBUTE_ORDER_ID,
        OrderDetail::ATTRIBUTE_MENU_RESTAURANT_ID,
        OrderDetail::ATTRIBUTE_AMOUNT,
        OrderDetail::ATTRIBUTE_SUB_TOTAL,
    ];

    public function menuRestaurant(){
        return $this->belongsTo('App\Entities\MenuRestaurant');
    }

}
