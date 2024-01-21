<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShippingPartner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['partner_name', 'shipping_cost'];

    public function coffeeTypes()
    {
        return $this->hasMany(CoffeeType::class);
    }
}
