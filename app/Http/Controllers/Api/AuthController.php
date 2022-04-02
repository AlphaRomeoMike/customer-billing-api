<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
	/**
	 * ----------
	 * Register
	 * ----------
	 *
	 * @param RegisterRequest $request
	 * @return JSON
	 */
	public function register(RegisterRequest $request)
	{
		$user = User::where('email', $request->email)->first();

		if (!$user) {
			$new = User::create([
				'name' => $request->name,
				'email' => $request->email,
				'password' => bcrypt($request->password),
				'role' => $request->role,
			]);

			if ($new) {
				return response()->json([
					'status' => 'success',
					'message' => 'User created successfully',
					'count' => 1,
					'data' => $new,
					'success' => true,
				], 201);
			} else {
				return response()->json([
					'status' => 'error',
					'message' => 'Something went wrong, please try again',
					'success' => false,
				], 500);
			}
		}
	}

	/**
	 * ----------
	 * Login
	 * ----------
	 *
	 * @param AuthRequest $request
	 * @return JSON
	 */
	public function login(AuthRequest $request)
	{
		// validate email and password
		$user = User::where('email', $request->email)->first();

		if (!$user) {
			return response()->json([
				'status' => 'error',
				'message' => 'User not found',
				'data' => [],
				'success' => false,
			], 404);
		}

		if (Hash::check($request->password, $user->password)) {
			$token = $user->createToken('authToken')->plainTextToken;

			return response()->json([
				'status' => 'success',
				'message' => 'User logged in successfully',
				'success' => true,
				'data' => [
					'token' => $token,
					'user' => $user,
				],
			], 200);
		} else {
			return response()->json([
				'status' => 'error',
				'message' => 'Invalid email or password',
				'success' => false,
				'data' => [],
			], 401);
		}
	}

	/**
	 * ----------
	 * Logout
	 * ----------
	 * 
	 * @return JSON
	 */
	public function logout()
	{
		auth('sanctum')->user()->tokens->each(function ($token, $key) {
			$token->delete();
		});

		return response()->json([
			'status' => 'success',
			'message' => 'User logged out successfully',
			'success' => true,
			'data' => [],
		], 200);
	}
}
