<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockMovement extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'stock_movements';
    protected $fillable = [
        'user_id',
        'date',
        'type',
        'comment',
        'category_movements_id',
        'provider_id',
        'warehouse_id',
        'voucher_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categoryMovement()
    {
        return $this->belongsTo(CategoryMovement::class, 'category_movements_id');
    }

    public function movementDetails()
    {
        return $this->hasMany(MovementsDetail::class);
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}