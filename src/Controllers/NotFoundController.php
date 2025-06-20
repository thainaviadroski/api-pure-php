<?php

namespace App\Controllers;

use App\Http\Request;
use App\Http\Response;

class NotFoundController
{
    public function index(Request $request, Response $response)
    {
        return $response::json([
            'error' => true,
            'success' => false,
            'message' => 'Sorry, route not found.'
        ], 404);
    }
}
