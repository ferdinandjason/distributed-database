<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Event;

class AdminMenu
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
                'url'  => 'admin/home',
                'icon' => 'home',
            ]);
            $event->menu->add('ORDER');
            $event->menu->add([
                'text' => 'Order',
                'url'  => 'admin/order',
                'icon' => 'sticky-note',
            ]);
        });
        return $next($request);
    }
}
