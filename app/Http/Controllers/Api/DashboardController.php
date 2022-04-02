<?php

namespace App\Http\Controllers\Api;

use App\Models\Bill;
use App\Models\User;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
	/**
	 * Handle the incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function __invoke(Request $request)
	{
		// Get total number of users
		$users = User::count();
		// Get total number of bills
		$bills = Bill::count();
		// Get total number of categories
		$categories = Category::count();
		// Get total number of subcategories
		$subcategories = SubCategory::count();
		// Get total amount of bills
		$amount = Bill::sum('amount');
		// Get total amount of paid bills
		$paid = Bill::where('paid', 1)->sum('amount');
		return response()->json([
			'status' => 'success',
			'message' => 'Dashboard data',
			'data' => [
				'users' => $users,
				'bills' => $bills,
				'categories' => $categories,
				'subcategories' => $subcategories,
				'amount' => $amount,
				'paid' => $paid,
			],
			'success' => true,
		], 200);
	}
}
