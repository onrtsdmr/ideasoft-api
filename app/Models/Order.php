<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'customerId',
        'items',
        'total',
    ];

    protected $casts = [
        'items' => 'array',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerId');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'id', 'productId')->whereIn('id', collect($this->items)->pluck('productId'));
    }
}
