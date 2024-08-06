<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProvidersAndProducts extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'providers_and_products';

    protected $fillable = [
        'movements_detail_id', 'provider_id',
    ];

    public function movementDetail()
    {
        return $this->belongsTo(MovementsDetail::class, 'movements_detail_id');
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
}