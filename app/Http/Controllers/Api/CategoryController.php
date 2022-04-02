<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function index()
	{
		/**
		 * @var Category[] $categories
		 */
		$categories;
		if (!cache()->has('categories')) {
			$categories = cache()->remember('categories', 120, function () {
				return CategoryResource::collection(Category::with('subCategories')->get());
			});
		} else {
			$categories = cache()->get('categories');
		}

		// if user is admin, get all categories
		if (auth()->user()->role == 'ADMIN') {
			// return JSON response
			return response()->json([
				'message' => 'Successfully retrieved categories.',
				'status' => 200,
				'count' => count($categories),
				'data' => $categories
			]);
		} else {
			// return categories where status is 1
			$categories = $categories->where('status', 1);
			return response()->json([
				'message' => 'Successfully retrieved categories.',
				'status' => 200,
				'count' => count($categories),
				'data' => $categories->where('status', 1)
			]);
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\CategoryRequest  $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store(CategoryRequest $request)
	{
		$category = Category::create($request->validated());

		if ($category) {
			return response()->json([
				'message' => 'Successfully created category.',
				'status' => 201,
				'count' => 1,
				'data' => $category
			]);
		} else {
			return response()->json([
				'message' => 'Failed to create category.',
				'status' => 500
			]);
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Category  $category
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function show(Category $category)
	{
		return response()->json([
			'message' => 'Successfully retrieved category.',
			'status' => 200,
			'count' => 1,
			'data' => $category
		]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\CategoryRequest  $request
	 * @param  \App\Models\Category  $category
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function update(CategoryRequest $request, Category $category)
	{
		$category = $category->update($request->validated());

		return response()->json([
			'message' => 'Successfully updated category.',
			'status' => 200,
			'count' => 1,
		], 200);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Category  $category
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function destroy(Category $category)
	{
		$success = $category->delete();
		if ($success) {
			return response()->json([
				'message' => 'Successfully deleted category.',
				'status' => 200,
				'count' => 1,
			], 200);
		} else {
			return response()->json([
				'message' => 'Failed to delete category.',
				'status' => 500,
				'count' => 0,
			]);
		}
	}
}
