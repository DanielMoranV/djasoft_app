<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Exception;

class ProductBatch extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_batches';

    protected $fillable = [
        'product_id',
        'batch_number',
        'expiration_date',
        'price',
        'quantity',
    ];

    protected function expirationDate(): Attribute
    {
        return Attribute::make(
            // Accesor: Formatea la fecha cuando se obtiene de la base de datos.
            get: function ($value) {
                try {
                    return Carbon::parse($value)->format('Y-m-d');
                } catch (Exception $e) {
                    // Manejo de errores, por ejemplo, si el valor es nulo o inválido
                    return $value; // Devolver el valor sin cambios si ocurre un error
                }
            },
            // Mutador: Convierte la fecha al formato Y-m-d antes de guardarla.
            set: function ($value) {
                try {
                    return Carbon::parse($value)->format('Y-m-d');
                } catch (Exception $e) {
                    return null; // Manejo de errores si la fecha no es válida
                }
            }
        );
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
