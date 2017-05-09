<?php

use Illuminate\Routing\Router;

Admin::registerHelpersRoutes();

Route::group([
    'prefix'        => config('admin.prefix'),
    'namespace'     => Admin::controllerNamespace(),
    'middleware'    => ['web', 'admin'],
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    $router->resource('posts', PostController::class);
    $router->resource('pages', PageController::class);
    $router->resource('tags', TagController::class);
    $router->resource('category', CategoryController::class);

    $router->resource('images', ImageController::class);
    $router->resource('api/images', Api\ImageController::class);
    $router->resource('api/category', Api\CategoryController::class);



    $router->resource('options', OptionController::class);
    $router->resource('multipleImage', MultipleImageController::class);

    $router->resource('contact', ContactController::class);
    $router->resource('navigation', NavigationController::class);
    $router->resource('carousel', CarouselController::class);
    $router->resource('help', HelpController::class);
    $router->resource('links', LinkController::class);

});

Route::get('/{slug}', 'App\Http\Controllers\PageController@show')->where('any', '.*')->name('cms.page');




