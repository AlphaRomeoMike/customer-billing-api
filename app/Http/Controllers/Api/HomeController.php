<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => "Server is working, Health: 100%! 🍎🍏🍊",
        ], 200);
    }
}
