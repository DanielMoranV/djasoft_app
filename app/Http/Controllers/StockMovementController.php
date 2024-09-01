<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseHelper;
use App\Http\Requests\StoreEntryStockMovementRequest;
use App\Http\Resources\StockMovementResource;
use App\Interfaces\MovementDetailRepositoryInterface;
use App\Interfaces\ProductBatchRepositoryInterface;
use App\Interfaces\StockMovementRepositoryInterface;
use App\Interfaces\VoucherRepositoryInterface;
use App\Models\ProductBatch;
use App\Services\StockMovementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockMovementController extends Controller
{
    private StockMovementRepositoryInterface $stockMovementRepositoryInterface;
    private StockMovementService $stockMovementService;

    public function __construct(StockMovementRepositoryInterface $stockMovementRepositoryInterface, StockMovementService $stockMovementService)
    {
        $this->stockMovementRepositoryInterface = $stockMovementRepositoryInterface;
        $this->stockMovementService = $stockMovementService;
    }
    public function storeEntry(StoreEntryStockMovementRequest $request)
    {
        return $this->stockMovementService->storeEntry($request);
    }
}
