<?php

namespace App\Services;

use App\Classes\ApiResponseHelper;
use App\Constants\DatabaseErrorCodes;
use App\Http\Requests\StoreEntryStockMovementRequest;
use App\Http\Resources\StockMovementResource;
use App\Interfaces\MovementDetailRepositoryInterface;
use App\Interfaces\ProductBatchRepositoryInterface;
use App\Interfaces\StockMovementRepositoryInterface;
use App\Interfaces\VoucherRepositoryInterface;
use App\Models\ProductBatch;
use Illuminate\Support\Facades\DB;

class StockMovementService
{
    private StockMovementRepositoryInterface $stockMovementRepositoryInterface;
    private VoucherRepositoryInterface $voucherRepositoryInterface;
    private ProductBatchRepositoryInterface $productBatchRepositoryInterface;
    private MovementDetailRepositoryInterface $movementDetailRepositoryInterface;

    public function __construct(
        StockMovementRepositoryInterface $stockMovementRepositoryInterface,
        VoucherRepositoryInterface $voucherRepositoryInterface,
        ProductBatchRepositoryInterface $productBatchRepositoryInterface,
        MovementDetailRepositoryInterface $movementDetailRepositoryInterface
    ) {
        $this->stockMovementRepositoryInterface = $stockMovementRepositoryInterface;
        $this->voucherRepositoryInterface = $voucherRepositoryInterface;
        $this->productBatchRepositoryInterface = $productBatchRepositoryInterface;
        $this->movementDetailRepositoryInterface = $movementDetailRepositoryInterface;
    }

    public function storeEntry(StoreEntryStockMovementRequest $request)
    {
        DB::beginTransaction();

        try {
            $voucher = $this->createVoucher($request->input('voucher'));
            $stockMovement = $this->createStockMovement($request, $voucher);
            $this->processMovementDetails($request->input('movements_details'), $stockMovement);

            DB::commit();

            return ApiResponseHelper::sendResponse(new StockMovementResource($stockMovement), 'Entry created successfully.', 201);
        } catch (\Exception $ex) {
            DB::rollBack();
            return ApiResponseHelper::rollback($ex);
        }
    }

    private function createVoucher(array $voucherData)
    {
        return $this->voucherRepositoryInterface->store([
            'series' => $voucherData['series'],
            'numbers' => $voucherData['numbers'],
            'amount' => $voucherData['amount'],
            'status' => $voucherData['status'],
            'issue_date' => $voucherData['issue_date'],
        ]);
    }

    private function createStockMovement($request, $voucher)
    {
        return $this->stockMovementRepositoryInterface->store([
            'user_id' => $request->input('user_id'),
            'comment' => $request->input('comment'),
            'category_movements_id' => $request->input('category_movements_id'),
            'voucher_id' => $voucher->id,
            'provider_id' => $request->input('provider_id'),
        ]);
    }

    private function processMovementDetails($movementsDetails, $stockMovement)
    {
        foreach ($movementsDetails as $detail) {
            $this->handleProductBatch($detail, $stockMovement);
        }
    }

    private function handleProductBatch(array $detail, $stockMovement)
    {
        $dataProductBatch = [
            'product_id' => $detail['product_id'],
            'batch_number' => ProductBatch::where('product_id', $detail['product_id'])->count() + 1,
            'expiration_date' => $detail['expiration_date'],
            'price' => $detail['price'],
            'quantity' => $detail['count']
        ];

        try {
            $productBatch = $this->productBatchRepositoryInterface->store($dataProductBatch);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === DatabaseErrorCodes::UNIQUE_CONSTRAINT_VIOLATION_CODE) {
                $productBatch = ProductBatch::where('product_id', $detail['product_id'])
                    ->where('expiration_date', $detail['expiration_date'])
                    ->where('price', $detail['price'])
                    ->first();

                $productBatch->quantity += $detail['count'];
                $productBatch->save();
            } else {
                throw $e;
            }
        }

        $dataMovementeDetail = [
            'stock_movement_id' => $stockMovement->id,
            'product_batch_id' => $productBatch->id,
            'count' => $detail['count']
        ];

        $this->movementDetailRepositoryInterface->store($dataMovementeDetail);
    }
}
