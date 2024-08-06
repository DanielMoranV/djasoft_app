<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provider extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'ruc',
        'address',
        'phone',
        'email',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'providers_and_products', 'provider_id', 'product_id');
    }
}