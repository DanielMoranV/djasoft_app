<?php

namespace App\Providers;

use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\CompanyRepositoryInterface;
use App\Interfaces\MovementDetailRepositoryInterface;
use App\Interfaces\ProductBatchRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\ProviderRepositoryInterface;
use App\Interfaces\RoleRepositoryInterface;
use App\Interfaces\StockMovementRepositoryInterface;
use App\Interfaces\UnitRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\VoucherRepositoryInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\MovementDetailRepository;
use App\Repositories\ProductBatchRepository;
use App\Repositories\ProductRepository;
use App\repositories\ProviderRepository;
use App\Repositories\RoleRepository;
use App\Repositories\StockMovementRepository;
use App\Repositories\UnitRepository;
use App\Repositories\UserRepository;
use App\Repositories\VoucherRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(UnitRepositoryInterface::class, UnitRepository::class);
        $this->app->bind(MovementDetailRepositoryInterface::class, MovementDetailRepository::class);
        $this->app->bind(ProductBatchRepositoryInterface::class, ProductBatchRepository::class);
        $this->app->bind(StockMovementRepositoryInterface::class, StockMovementRepository::class);
        $this->app->bind(VoucherRepositoryInterface::class, VoucherRepository::class);
        $this->app->bind(ProviderRepositoryInterface::class, ProviderRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}