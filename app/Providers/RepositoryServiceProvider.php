<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Khai báo các Interface và Implementations của bạn ở đây
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Contracts\RoleRepositoryInterface;
use App\Repositories\Eloquent\RoleRepository;
use App\Repositories\Contracts\RefreshTokenRepositoryInterface;
use App\Repositories\Eloquent\RefreshTokenRepository;
use App\Repositories\Contracts\CartRepositoryInterface;
use App\Repositories\Eloquent\CartRepository;
use App\Repositories\Contracts\CartItemRepositoryInterface;
use App\Repositories\Eloquent\CartItemRepository;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Repositories\Eloquent\BrandRepository;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Contracts\ProductVariantRepositoryInterface;
use App\Repositories\Eloquent\ProductVariantRepository;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Eloquent\OrderRepository;
use App\Repositories\Contracts\OrderItemRepositoryInterface;
use App\Repositories\Eloquent\OrderItemRepository;
use App\Repositories\Contracts\SpecificationAttributeRepositoryInterface;
use App\Repositories\Eloquent\SpecificationAttributeRepository;
use App\Repositories\Contracts\SpecificationGroupRepositoryInterface;
use App\Repositories\Eloquent\SpecificationGroupRepository;
use App\Repositories\Contracts\SpecificationValueRepositoryInterface;
use App\Repositories\Eloquent\SpecificationValueRepository;

use App\Services\Implementations\UserService;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\Interfaces\RoleServiceInterface;
use App\Services\Implementations\RoleService;
use App\Services\Interfaces\AuthServiceInterface;
use App\Services\Implementations\AuthService;
use App\Services\Interfaces\BrandServiceInterface;
use App\Services\Implementations\BrandService;
use App\Services\Interfaces\CategoryServiceInterface;
use App\Services\Implementations\CategoryService;
use App\Services\Interfaces\ProductServiceInterface;
use App\Services\Implementations\ProductService;
use App\Services\Interfaces\ProductVariantServiceInterface;
use App\Services\Implementations\ProductVariantService;
use App\Services\Interfaces\OrderServiceInterface;
use App\Services\Implementations\OrderService;
use App\Services\Implementtations\VNPayService;
use App\Services\Interfaces\SpecificationAttributeServiceInterface;
use App\Services\Implementations\SpecificationAttributeService;
use App\Services\Interfaces\SpecificationGroupServiceInterface;
use App\Services\Implementations\SpecificationGroupService;
use App\Services\Interfaces\SpecificationValueServiceInterface;
use App\Services\Implementations\SpecificationValueService;
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Đăng ký các bindings vào Service Container.
     */
    public function register(): void
    {
        
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(RefreshTokenRepositoryInterface::class, RefreshTokenRepository::class);
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
        $this->app->bind(CartItemRepositoryInterface::class, CartItemRepository::class);
        $this->app->bind(BrandRepositoryInterface::class, BrandRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductVariantRepositoryInterface::class, ProductVariantRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(OrderItemRepositoryInterface::class, OrderItemRepository::class);
        $this->app->bind(SpecificationAttributeRepositoryInterface::class, SpecificationAttributeRepository::class);
        $this->app->bind(SpecificationGroupRepositoryInterface::class, SpecificationGroupRepository::class);
        $this->app->bind(SpecificationValueRepositoryInterface::class, SpecificationValueRepository::class);
        
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(RoleServiceInterface::class, RoleService::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(BrandServiceInterface::class, BrandService::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
        $this->app->bind(ProductVariantServiceInterface::class, ProductVariantService::class);
        $this->app->bind(OrderServiceInterface::class, OrderService::class);
        $this->app->bind(VNPayService::class);
        $this->app->bind(SpecificationAttributeServiceInterface::class, SpecificationAttributeService::class);
        $this->app->bind(SpecificationGroupServiceInterface::class, SpecificationGroupService::class);
        $this->app->bind(SpecificationValueServiceInterface::class, SpecificationValueService::class);
    }

    /**
     * Bootstrap các dịch vụ ứng dụng.
     */
    public function boot(): void
    {
        //
    }
}