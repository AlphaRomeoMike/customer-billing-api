<?php

namespace App\Http\Controllers\Api;

use App\Models\Bill;
use App\Http\Requests\BillRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\BillResource;

class BillController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index()
	{
		/** 
		 * @var Bill[] $bills
		 */
		$bills;
		if (!cache()->has('bills')) {
			$bills = cache()->remember('bills', 120, function () {
				if (auth()->user()->role == 'ADMIN') {
					return BillResource::collection(Bill::with(['category', 'subCategory', 'user'])->get());
				} else {
					return BillResource::collection(Bill::with(['category', 'subCategory', 'user'])->where('user_id', auth()->id())->get());
				}
			});
		} else {
			$bills = cache()->get('bills');
		}

		return response()->json([
			'message' => 'Successfully retrieved bills.',
			'status' => 200,
			'count' => count($bills),
			'data' => $bills
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\BillRequest  $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(BillRequest $request)
	{
		abort_if(auth()->user()->role != 'ADMIN', 403, 'Unauthorized.');

		$bill = Bill::create($request->all());

		return response()->json([
			'message' => 'Successfully created bill.',
			'status' => 201,
			'data' => new BillResource($bill)
		]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  Bill  $bill
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(Bill $bill)
	{
		if (auth()->user()->role == 'ADMIN') {
			$bill = Bill::with(['category', 'subCategory', 'user'])->findOrFail($bill);
		} else if (auth()->user()->role == 'USER') {
			$bill = Bill::with(['category', 'subCategory', 'user'])->where('user_id', auth()->id())->findOrFail($bill);
		}
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\BillRequest  $request
	 * @param  Bill  $bill
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(BillRequest $request, Bill $bill)
	{
		abort_if(auth()->user()->role != 'ADMIN', 403, 'Unauthorized.');

		if ($bill->paid == 1) {
			return response()->json([
				'message' => 'Bill is already paid.',
				'status' => 400,
				'data' => new BillResource($bill)
			]);
		} else if ($bill->update($request->all())) {
			return response()->json([
				'message' => 'Successfully updated bill.',
				'status' => 200,
				'data' => new BillResource($bill)
			]);
		} else {
			return response()->json([
				'message' => 'Failed to update bill.',
				'status' => 400
			]);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  Bill  $bill
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy(Bill $bill)
	{
		abort_if(auth()->user()->role != 'ADMIN', 403, 'Unauthorized.');

		if ($bill->delete()) {
			return response()->json([
				'message' => 'Successfully deleted bill.',
				'status' => 200
			]);
		} else {
			return response()->json([
				'message' => 'Failed to delete bill.',
				'status' => 500
			]);
		}
	}
}
