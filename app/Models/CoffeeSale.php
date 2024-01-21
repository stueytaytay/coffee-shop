<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoffeeSale extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'quantity',
        'unit_cost',
        'selling_price',
        'coffee_type_id',
    ];

    public function coffeeType()
    {
        return $this->belongsTo(CoffeeType::class);
    }
}
