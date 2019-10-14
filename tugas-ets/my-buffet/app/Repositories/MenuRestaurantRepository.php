<?php

namespace App\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface MenuRestaurantRepository.
 *
 * @package namespace App\Repositories;
 */
interface MenuRestaurantRepository extends RepositoryInterface
{
    public function getMenu($id);
}
