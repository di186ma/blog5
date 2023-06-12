<?php
namespace Framework;

    Router::addRoute(new Route('logout', 'AuthController@logout', Route::METHOD_GET));
    Router::addRoute(new Route('login', 'AuthController@login', Route::METHOD_POST));

    Router::addRoute(new Route('user/{id}', 'UserController@getById', Route::METHOD_GET, true));
    Router::addRoute(new Route('users', 'UserController@index', Route::METHOD_GET));

    Router::addRoute(new Route('posts', 'PostsController@index', Route::METHOD_GET));

    Router::addRoute(new Route('test/{test_data}', 'MyController@index', Route::METHOD_GET));
    Router::addRoute(new Route('test/{test_data}/value/{test_value}', 'MyController@index', Route::METHOD_GET));
    Router::addRoute(new Route('hi/{name}/text/{text}', 'HelloController@hello', Route::METHOD_GET));
    echo "Маршруты добавлены<br>";