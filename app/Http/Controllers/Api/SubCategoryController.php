<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubCategoryRequest;
use App\Models\SubCategory;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         * @var SubCategory[] $subCategories
         */
        $subCategories;
        if (!cache()->has('subCategories')) {
            $subCategories = cache()->remember('subCategories', 120, function () {
                return SubCategory::all();
            });
        } else {
            $subCategories = cache()->get('subCategories');
        }

        // if user is admin, get all subCategories
        if (auth()->user()->role == 'ADMIN') {
            // return JSON response
            return response()->json([
                'message' => 'Successfully retrieved subCategories.',
                'status' => 200,
                'success' => true,
                'count' => count($subCategories),
                'data' => $subCategories
            ]);
        } else {
            // return subCategories where status is 1
            $subCategories = $subCategories->where('status', 1);
            return response()->json([
                'message' => 'Successfully retrieved subCategories.',
                'status' => 200,
                'success' => true,
                'count' => count($subCategories),
                'data' => $subCategories->where('status', 1)
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubCategoryRequest $request)
    {
        $subCategory = SubCategory::create($request->validated());

        if ($subCategory) {
            return response()->json([
                'message' => 'Successfully created subCategory.',
                'status' => 201,
                'success' => true,
                'data' => $subCategory
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to create subCategory.',
                'success' => false,
                'status' => 500
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $subCategory)
    {
        return response()->json([
            'message' => 'Successfully retrieved subCategory.',
            'status' => 200,
            'success' => true,
            'data' => $subCategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\SubCategoryRequest  $request
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(SubCategoryRequest $request, SubCategory $subCategory)
    {
        $subCategory->update($request->validated());

        if ($subCategory) {
            return response()->json([
                'message' => 'Successfully updated subCategory.',
                'status' => 200,
                'success' => true,
                'data' => $subCategory
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to update subCategory.',
                'status' => 500
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $subCategory)
    {
        if ($subCategory->delete()) {
            return response()->json([
                'message' => 'Successfully deleted subCategory.',
                'success' => true,
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to delete subCategory.',
                'success' => false,
                'status' => 500
            ]);
        }
    }
}
