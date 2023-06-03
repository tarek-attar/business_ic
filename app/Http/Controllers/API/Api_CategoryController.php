<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class Api_CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        $response = [
            'status' => true,
            'message' => 'you get all category successfully',
            'data' => $categories
        ];
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_en' => 'required|unique:categories',
            'name_ar' => 'required|unique:categories',
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => $validator->errors(),
            ];
            return response()->json($response, 400);
        }

        $category = Category::create([
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'notic' => $request->notic,
        ]);
        $response = [
            'status' => true,
            'message' => 'Category created successfully',
            'data' => $category
        ];
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateCategory(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name_en' => 'required|unique:categories',
            'name_ar' => 'required|unique:categories',
        ]);
        if ($validator->fails()) {
            $response = [
                'status' => false,
                'message' => $validator->errors(),
            ];
            return response()->json($response, 400);
        }

        $category = Category::where('id', $id)->first();

        $category->update([
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'notic' => $request->notic,
        ]);
        $response = [
            'status' => true,
            'message' => 'Category updated successfully',
            'data' => []
        ];
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyCategory($id)
    {
        $category = Category::where('id', $id)->first();
        if (!$category) {
            $response = [
                'status' => false,
                'message' => 'the category dose not exist',
                'data' => []
            ];
            return response()->json($response);
        }
        $category->delete();
        $response = [
            'status' => true,
            'message' => 'Category deleted successfully',
            'data' => []
        ];
        return response()->json($response);
    }
}
