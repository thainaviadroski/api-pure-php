<?php

namespace App\Core;

use App\Http\Request;
use App\Http\Response;

class Core
{

    public static function dispath(array $routes)
    {
        $url = "/";

        isset($_GET['url']) && $url .= $_GET['url'];

        $url !== '/' && $url = rtrim($url, '/');

        $prefix = 'App\\Controllers\\';

        $routeFound = false;

        foreach ($routes as $route) {
            $pattern = '#^' . preg_replace('/{id}/', '([\w-]+)', $route['path']) . '$#';
            if (preg_match($pattern, $url, $matches)) {
                array_shift($matches);

                $routeFound = true;

                if ($route['method'] !== Request::method()) {
                    Response::json([
                        'error' => true,
                        'success' => false,
                        'message' => 'Method not allowed.'
                    ], 405);
                    return;
                }


                [$controller, $action] = explode('@', $route['action']);

                $controller = $prefix . $controller;
                $extendController = new $controller();
                $extendController->$action(new Request, new Response, $matches);
            }
        }

        if (!$routeFound) {
            $controller = $prefix . 'NotFoundController';
            $extendController = new $controller();
            $extendController->index(new Request, new Response);
        }
    }
}
