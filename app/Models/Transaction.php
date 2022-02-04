<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;


         /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'users_id',
        'address',
        'total_price',
        'shipping_price',
        'status',
        'payment ',
    ];

//user table
    public function user(){
        return $this->belongsTo(User::class, 'users_id', 'id');
    }


    //transactionitems table
    public function items(){
        return $this->hasMany(TransactionsItem::class, 'transactions_id', 'id');
    }

}
