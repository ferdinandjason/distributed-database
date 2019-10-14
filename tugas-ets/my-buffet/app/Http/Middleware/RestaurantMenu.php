<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Event;

class RestaurantMenu
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        Event::listen('JeroenNoten\LaravelAdminLte\Events\BuildingMenu', function ($event) {
            $event->menu->add('DASHBOARD');
            $event->menu->add([
                'text' => 'Dashboard',
                'url'  => 'restaurant/home',
                'icon' => 'home',
            ]);
            $event->menu->add('ORDER');
            $event->menu->add([
                'text' => 'Order',
                'url'  => 'restaurant/order',
                'icon' => 'sticky-note',
            ]);
            $event->menu->add([
                'text' => 'Order History',
                'url'  => 'restaurant/order-history',
                'icon' => 'sticky-note-o',
            ]);
            $event->menu->add('MENU');
            $event->menu->add([
                'text' => 'Menu',
                'url'  => 'restaurant/menu',
                'icon' => 'navicon',
            ]);
            $event->menu->add([
                'text' => 'Tambah menu',
                'url'  => 'restaurant/menu-new',
                'icon' => 'plus-square',
            ]);
            $event->menu->add('PROFILE');
            $event->menu->add([
                'text' => 'Profile',
                'url'  => 'restaurant/profile/'.Auth('restaurant')->user()->id,
                'icon' => 'user',
            ]);
        });

        return $next($request);
    }
}
