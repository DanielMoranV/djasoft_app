<?php

namespace App\Repositories;

use App\Interfaces\ProductBatchRepositoryInterface;
use App\Models\ProductBatch;

class ProductBatchRepository extends BaseRepository implements ProductBatchRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(ProductBatch $model)
    {
        parent::__construct($model);
    }
}
