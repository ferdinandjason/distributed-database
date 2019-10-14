<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface OrderRepository.
 *
 * @package namespace App\Repositories;
 */
interface OrderRepository extends RepositoryInterface
{
    //
    public function findOrderWithRestaurantId($id);
    public function findOrderHistory($id);
    public function changeStatusToDone($id);
    public function changeStatusToPlaced($id);
    public function changeStatusToConfirmed($id);
    public function recentResto($id);
    public function getBestResto();
    public function getLastOrder();
    public function allReversed();
}
