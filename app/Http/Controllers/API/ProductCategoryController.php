<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Models\ProductsCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit');
        $name = $request->input('id');
        $show_product = $request->input('show_product');

        if ($id) {
            //ProductsCategory dr model ProductsCategory
            $category = ProductsCategory::with(['products'])->find($id);
            //(['products']) = diambil dr model ProductsCategory karena tidak ada relasi lain selain products

            //jika datanya ada
            if ($category) {
                return ResponseFormatter::success(
                    $category,
                    'Data Product Category diambil'
                );
                //jika tidak ada datanya
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data Category Tidak Ada',
                    404
                );
            }
        }

        $category = ProductsCategory::query();
        //di ProductsCategory tidak ada relasi apa2 maka pake query();

        //filtering
        if ($name) {
            $category->where('name', 'like', '%' . $name . '%');
        }

        if ($show_product) {
            $category->with('products');
        }
        return ResponseFormatter::success(
            //karena ini ngambil datanya lebih dr satu maka pake fungsi paginet saja
            $category->paginate($limit),
            'Data List category Berhasil diambil'
        );
    }
}
