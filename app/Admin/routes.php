<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->get('users', 'UsersController@index');
    $router->get('products', 'ProductsController@index');
    $router->get('products/create', 'ProductsController@create');
    $router->post('products', 'ProductsController@store');
    $router->get('products/{id}/edit', 'ProductsController@edit');
    $router->put('products/{id}', 'ProductsController@update');

    // 订单列表路由
    $router->get('orders', 'OrdersController@index')->name('admin.orders.index');
    // 订单详情路由
    $router->get('orders/{order}', 'OrdersController@show')->name('admin.orders.show');
    // 发货路由
    $router->post('orders/{order}/ship', 'OrdersController@ship')->name('admin.orders.ship');
});
