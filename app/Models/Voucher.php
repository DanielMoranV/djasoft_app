<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'series',
        'number',
        'issue_date',
        'hash',
        'amount',
        'status',
    ];


    public function stockMovement()
    {
        return $this->belongsTo(StockMovement::class);
    }
}
