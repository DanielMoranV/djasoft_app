<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryMovement extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'category_movements';

    protected $fillable = [
        'name', 'description',
    ];

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }
}