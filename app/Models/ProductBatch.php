<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductBatch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_batches';

    protected $fillable = [
        'product_id', 'batch_number', 'expiration_date', 'price', 'quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}