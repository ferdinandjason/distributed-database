<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class RecentTransfer.
 *
 * @package namespace App\Entities;
 */
class RecentTransfer extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    const ATTRIBUTE_ID = 'id';
    const ATTRIBUTE_ORDER_ID = 'order_id';
    const ATTRIBUTE_TOTAL = 'total';

    protected $fillable = [
        RecentTransfer::ATTRIBUTE_ID,
        RecentTransfer::ATTRIBUTE_ORDER_ID,
        RecentTransfer::ATTRIBUTE_TOTAL,
    ];

}
