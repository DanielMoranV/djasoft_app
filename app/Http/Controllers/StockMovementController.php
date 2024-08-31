<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEntryStockMovementRequest;
use Illuminate\Http\Request;

class StockMovementController extends Controller
{
    public function storeEntry(StoreEntryStockMovementRequest $request)
    {
        // Inicia una transacción
        DB::beginTransaction();

        try {
            // Primero, crea el voucher
            $voucher = Voucher::create([
                'series' => $request->input('voucher.series'),
                'numbers' => $request->input('voucher.numbers'),
                'amount' => $request->input('voucher.amount'),
                'status' => $request->input('voucher.status'),
                'issue_date' => $request->input('voucher.issue_date'),
                'user_id' => $request->input('user_id'),
                'comment' => $request->input('comment'),
                'category_movements_id' => $request->input('category_movements_id'),
                'provider_id' => $request->input('provider_id')
            ]);

            // Luego, crea el registro principal en stock_movements
            $stockMovement = StockMovement::create([
                'voucher_id' => $voucher->id,
                'type' => 'entry', // Esto depende de tu lógica de negocio
                'user_id' => $request->input('user_id'),
                'comment' => $request->input('comment')
            ]);

            // Obtiene los detalles de los movimientos
            $movementsDetails = $request->input('movements_details');

            // Agrupa detalles por producto para optimizar la consulta
            $batchesData = [];
            foreach ($movementsDetails as $detail) {
                $key = $detail['product_id'] . '-' . $detail['expiration_date'] . '-' . $detail['price'];
                if (!isset($batchesData[$key])) {
                    $batchesData[$key] = [
                        'product_id' => $detail['product_id'],
                        'expiration_date' => $detail['expiration_date'],
                        'price' => $detail['price'],
                        'quantity' => 0,
                    ];
                }
                $batchesData[$key]['quantity'] += $detail['count'];
            }

            // Consultar lotes existentes
            $batchKeys = array_keys($batchesData);
            $existingBatches = ProductBatch::whereIn(DB::raw('concat(product_id, "-", expiration_date, "-", price)'), $batchKeys)
                ->get()
                ->keyBy(function ($batch) {
                    return $batch->product_id . '-' . $batch->expiration_date . '-' . $batch->price;
                });

            foreach ($batchesData as $key => $data) {
                $batch = $existingBatches->get($key);

                if ($batch) {
                    // Si existe, actualiza la cantidad
                    $batch->quantity += $data['quantity'];
                    $batch->save();
                    $batchId = $batch->id;
                } else {
                    // Si no existe, crea un nuevo registro
                    $batchId = ProductBatch::create([
                        'product_id' => $data['product_id'],
                        'number' => ProductBatch::where('product_id', $data['product_id'])->count() + 1,
                        'expiration_date' => $data['expiration_date'],
                        'price' => $data['price'],
                        'quantity' => $data['quantity']
                    ])->id;
                }

                // Crea los detalles del movimiento
                foreach ($movementsDetails as $detail) {
                    if (
                        $detail['product_id'] == $data['product_id'] &&
                        $detail['expiration_date'] == $data['expiration_date'] &&
                        $detail['price'] == $data['price']
                    ) {
                        MovementDetail::create([
                            'stock_movement_id' => $stockMovement->id, // Se asocia al movimiento principal
                            'product_batch_id' => $batchId,
                            'count' => $detail['count']
                        ]);
                    }
                }
            }

            // Confirma la transacción
            DB::commit();

            // Retorna una respuesta exitosa
            return response()->json(['message' => 'Entry created successfully.'], 201);
        } catch (Exception $e) {
            // Revierte la transacción en caso de error
            DB::rollBack();

            // Maneja el error según tus necesidades
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
