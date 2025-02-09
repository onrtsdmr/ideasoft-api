<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'since',
        'revenue',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'customerId');
    }
}
