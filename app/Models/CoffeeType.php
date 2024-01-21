<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoffeeType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['coffee_name', 'profit_margin'];

    public function coffeeSales()
    {
        return $this->hasMany(CoffeeSale::class);
    }
}
