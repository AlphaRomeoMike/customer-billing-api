<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
	public function index()
	{
		$data = Auth('auth:sanctum')->user();

		if ($data) {
			return response()->json([
				'status' => 'success',
				'data' => $data,
				'success' => true,
			], 200);
		} else {
			return response()->json([
				'status' => 'error',
				'data' => [],
				'message' => 'User not found',
				'success' => false,
			], 404);
		}
	}
}
