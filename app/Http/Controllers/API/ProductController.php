<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function all(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);
        $name = $request->input('id');
        $description = $request->input('description');
        $tags = $request->input('tags ');
        $categories = $request->input('categories');
        $price_from = $request->input('price_from');
        $price_to = $request->input('price_to ');

        if ($id) {
            $product = Product::with(['category', 'galleries'])->find($id);

            //jika datanya ada
            if ($product) {
                return ResponseFormatter::success(
                    $product,
                    'Data Product Berhasil diambil'
                );
                //jika tidak ada datanya
            } else {
                return ResponseFormatter::error(
                    null,
                    'Data Product Tidak Ada',
                    404
                );
            }
        }



        $product = Product::with(['category', 'galleries']);


        //filtering
        if ($name) {
            $product->where('name', 'like', '%' . $name . '%');
        }

        if ($description) {
            $product->where('name', 'like', '%' . $description . '%');
        }

        if ($tags) {
            $product->where('name', 'like', '%' . $tags  . '%');
        }



        //karena ini pake id maka harus sesuai jika categories = $categories
        if ($categories) {
            $product->where('categories', $categories);
        }


        if ($price_from) {
            $product->where('price', '>=', $price_from);
        }

        if ($price_to) {
            $product->where('price', '<=', $price_to);
        }

        return ResponseFormatter::success(
            //karena ini ngambil datanya lebih dr satu maka pake fungsi paginet saja
            $product->paginate($limit),
            'Data List Product Berhasil diambil'
        );
    }
}
