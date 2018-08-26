<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocketController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * Check user authentication
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkAuth(Request $request)
    {
        return response()->json([
            'auth' => Auth::check()
        ]);
    }
}
