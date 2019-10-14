<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('logout', 'UsersController@logout')->name('logout');

Route::prefix('login')->group(function (){
    Route::name('login.')->group(function () {
        Route::get('/', function() {
            return redirect('/login/user');
        });
        Route::get('user', 'UsersController@formLogin')->name('user');
        Route::post('user', 'UsersController@authenticate')->name('user.auth');
        Route::get('restaurant', 'RestaurantsController@formLogin')->name('restaurant');
        Route::post('restaurant', 'RestaurantsController@authenticate')->name('restaurant.auth');
    });
});

Route::prefix('register')->group(function (){
    Route::name('register.')->group(function () {
        Route::get('/', function() {
            return redirect('/register/user');
        });
        Route::get('user', 'UsersController@formRegister')->name('user');
        Route::post('user', 'UsersController@store')->name('user.simpan');
        Route::get('restaurant', 'RestaurantsController@formRegister')->name('restaurant');
        Route::post('restaurant', 'RestaurantsController@store')->name('restaurant.simpan');
    });
});

Route::prefix('restaurant')->group(function (){
    Route::name('restaurant.')->group(function (){
        Route::middleware(['restaurant.menu','restrict'])->group(function (){
            Route::get('home', function() {
                return view('restaurant.home');
            })->name('home');
            Route::get('profile', 'RestaurantsController@show')->name('profile');
            Route::get('profile/edit', 'RestaurantsController@edit')->name('profile.edit');
            Route::post('profile', 'RestaurantsController@update')->name('profile.update');

            Route::get('order', 'OrdersController@indexRestaurant')->name('order.restaurant');
            Route::get('order-history', 'OrdersController@history')->name('order.history');
            Route::post('order/done/{id}', 'OrdersController@done')->name('order.done');
            Route::post('order/paid/{id}', 'OrdersController@paid')->name('order.paid');
    
            Route::get('menu', 'MenuRestaurantsController@index')->name('menu.index');
            Route::get('menu-new', 'MenuRestaurantsController@new')->name('menu.new');
            Route::post('menu/add', 'MenuRestaurantsController@store')->name('menu.store');
            Route::get('menu/{id}/edit', 'MenuRestaurantsController@edit')->name('menu.edit');
            Route::post('menu/{id}/edit', 'MenuRestaurantsController@update')->name('menu.update');
            Route::delete('menu/delete/{id}', 'MenuRestaurantsController@destroy')->name('menu.delete');
    
            Route::get('profile/{id}', 'RestaurantsController@show')->name('show');
            Route::get('profile-update', 'RestaurantsController@edit')->name('edit');
            Route::post('profile-update', 'RestaurantsController@update')->name('update');
        });
    });
});

Route::prefix('user')->group(function (){
    Route::name('user.')->group(function (){
        Route::middleware(['restrict'])->group(function (){
            Route::get('home', 'OrdersController@bestResto')->name('home');
            Route::get('profile', 'UsersController@show')->name('profile');
            Route::get('profile/edit', 'UsersController@edit')->name('profile.edit');
            Route::post('profile','UsersController@update')->name('profile.update');

            Route::get('order-history', 'OrdersController@historyUser')->name('order.history');
            Route::get('order', 'RestaurantsController@indexUser')->name('order');
            Route::get('order/restaurant/{id}', 'MenuRestaurantsController@indexResto')->name('resto');
            Route::post('order', 'OrdersController@store')->name('order.final');
            Route::get('order/{id}/bayar', 'OrdersController@bayar')->name('order.bayar');
            Route::post('order/{id}/bayar', 'OrdersController@update')->name('order.bayarr');
            Route::get('order/{id}/placed', 'OrdersController@placedd')->name('order.placed');
        });
    });
});

Route::prefix('admin')->group(function (){
    Route::name('admin.')->group(function (){
        Route::middleware(['admin.menu','restrict'])->group(function() {
            Route::get('home', 'UsersController@adminHome')->name('home');
            Route::get('order', 'OrdersController@index')->name('order.list');
            Route::get('order/{id}/confirmed', 'OrdersController@confirmed')->name('order.confirmed');
            Route::get('order/{id}/placed', 'OrdersController@placed')->name('order.placed');
            Route::get('restaurant', 'RestaurantsController@index')->name('restaurant.list');
            Route::get('user', 'UsersController@index')->name('user.list');
        });
    });
});

Route::name('api.')->group(function (){
    Route::get('transfer', 'OrdersController@getLastOrder')->name('transfer');
    Route::post('transfer/{order}', 'RecentTransfersController@store')->name('transfered');
    Route::get('transfered-order', 'RecentTransfersController@index')->name('transfered-order');
});