<?php

namespace App\Http\Controllers\API;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
public function all(Request $request)
{
    $id = $request->input('id');
    $limit = $request->input('limit', 6);
    $status = $request->input('status');

    if($id)
    {
        $transaction = Transaction::with(['item.product'])->find($id);

            if($transaction)
            {
                return ResponseFormatter::success(
                    $transaction, 'Data Transaksi Berhasil diambil'
                );
            }
            else
            {
                return ResponseFormatter::error(
                    null,
                    'Data transaksi tidak ada',
                    404
                );
            }
    }
    $transaction = Transaction::with(['item.product'])->where('users_id', Auth::user()->id);

    if($status)
    {
        $transaction->where('status', $status);
    }
    return ResponseFormatter::success(
        $transaction->paginate($limit),
        'Data List transaksi berhasil diambil'
    );
}

public function checkout(Request $request)
{
    $request->validate([
        'items' => 'required|array',
        'items.*.id' => 'exists:products,id',
        'total_price' => 'required',
        'shipping_price' => 'required',
        'status' => 'required|in:PENDING,SUCCESS,CANCELED,FAILED,SHIPPING,SHIPPED'
    ]);
    $transaction = Transaction::create([
        'users_id' => Auth::user()->id,
        'address' => $request->address,
        'total_price' => $request->total_price,
        'shipping_price' => $request->shipping_price,
        'status' => $request->status,

    ]);
    foreach ($request->items as $product)
    {
        TransactionItem::create([
            'users_id' => Auth::user()->id,
            'product_id' => $product['id'],
            'transaction_id' => $transaction->id,
            'quantity' => $product['quantity']
        ]);
    }
    return ResponseFormatter::success($transaction->load('items.product'), 'Transaksi Berhasil');
}
}
