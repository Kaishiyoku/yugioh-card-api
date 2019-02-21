<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function healthCheck()
    {
        return response()->json();
    }

    public function version()
    {
        return response()->json(env('APP_VERSION'));
    }
}
