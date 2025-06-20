<?php

use App\Http\Routes;

Routes::get("/", "HomeController@index");
Routes::post('/users/create', 'UserController@store');
Routes::post('/users/login', 'UserController@login');
Routes::get('/users/fetch', 'UserController@fetch');
Routes::update('/users/update', 'UserController@update');
Routes::delete('/users/{id}/delete', 'UserController@delete');
