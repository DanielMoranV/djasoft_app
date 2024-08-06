<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_name',
        'ruc',
        'address',
        'email',
        'phone',
        'status',
        'logo_path',
        'sol_user',
        'sol_pass',
        'cert_path',
        'client_id',
        'client_secret',
        'production',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }
}