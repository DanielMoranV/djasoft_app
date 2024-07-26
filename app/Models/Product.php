<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code', 'name', 'description', 'category_id', 'user_id', 'unit_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    // public function productBatches()
    // {
    //     return $this->hasMany(ProductBatch::class);
    // }

    // public function providers()
    // {
    //     return $this->belongsToMany(Provider::class, 'providers_and_products');
    // }

    // public function stock()
    // {
    //     return $this->hasMany(Stock::class);
    // }

    // public function characteristics()
    // {
    //     return $this->belongsToMany(ProductCharacteristic::class, 'products_and_characteristics')->withPivot('value');
    // }
}
