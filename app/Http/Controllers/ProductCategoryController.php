<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ProductCategoryRequest;
use App\Models\ProductsCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Contracts\DataTable;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = ProductsCategory::query();
            return DataTable::of($query)
                ->addColumn('action', function ($item) {
                    return '<a class="inline-block px-2 py-1 m-1 text-white transition duration-500 bg-gray-700 border border-gray-700 rounded-md select-none ease hover:bg-gray-800 focus:outline-none focus:shadow-outline" href="' . route('dashboard.category.edit', $item->id) . '">Edit</a>';
                })
                ->rawColumns(['action'])
                ->make();
        }
        return view('pages.dashboard.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductsCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function show(ProductsCategory $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductsCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductsCategory $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductsCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCategoryRequest $request, ProductsCategory $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductsCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductsCategory $category)
    {
        //
    }
}
