<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Tag;

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
