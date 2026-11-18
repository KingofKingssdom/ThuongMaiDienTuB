<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SpecificationAttributeController;
use App\Http\Controllers\SpecificationGroupController;
use App\Http\Controllers\SpecificationValueController;


Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('refresh-token', [AuthController::class, 'refreshToken']);
    Route::post('logout', [AuthController::class, 'logout']);
});


Route::middleware('auth:api')->prefix('role')->group(function () {
    Route::post('', [RoleController::class, 'store']);
    Route::get('', [RoleController::class, 'index']);
    Route::get('{id}', [RoleController::class, 'show']);
    Route::get('search/{name}', [RoleController::class, 'getByName']);
});


Route::prefix('brand')->group(function () {
    Route::get('', [BrandController::class, 'index']);
    Route::get('{id}', [BrandController::class, 'show']);
    Route::get('category', [BrandController::class, 'getByCategoryId']);
});


Route::middleware(['auth:api'])->prefix('brand')->group(function () {
    Route::post('', [BrandController::class, 'store']);
    Route::post('update/{id}', [BrandController::class, 'update']); 
    Route::post('delete/{id}', [BrandController::class, 'destroy']); 
});

Route::middleware(['auth:api'])->prefix('category')->group(function () {
    Route::get('', [CategoryController::class, 'index']);
    Route::get('{id}', [CategoryController::class, 'show']);
    Route::post('', [CategoryController::class, 'store']);
    
    Route::post('update/{id}', [CategoryController::class, 'update']);
    Route::post('delete/{id}', [CategoryController::class, 'destroy']);
});


Route::prefix('product')->group(function () {
    Route::get('', [ProductController::class, 'index']);
    Route::get('{id}', [ProductController::class, 'show']);
    Route::get('promotion', [ProductController::class, 'getByIsOnPromotion']);
    Route::get('isfeature', [ProductController::class, 'getIsFeature']);
    Route::get('search', [ProductController::class, 'getByName']);
    Route::get('filter', [ProductController::class, 'filter']);
});


Route::middleware(['auth:api'])->prefix('product')->group(function () {
    Route::post('', [ProductController::class, 'store']);
    Route::post('update/{id}', [ProductController::class, 'update']); // Hỗ trợ Post kèm multipart/form-data cho patch/update
    Route::post('delete/{id}', [ProductController::class, 'destroy']);
});


Route::middleware(['auth:api'])->prefix('productvariant')->group(function () {

    Route::get('', [ProductVariantController::class, 'index']);
    Route::get('{id}', [ProductVariantController::class, 'show']);
    Route::get('product/{productId}', [ProductVariantController::class, 'getByProductId']);

  
    Route::post('', [ProductVariantController::class, 'store']);
    Route::post('update/{id}', [ProductVariantController::class, 'update']); // Hỗ trợ Post kèm multipart/form-data cho cập nhật ảnh
    Route::post('delete/{id}', [ProductVariantController::class, 'destroy']);
});


Route::middleware(['auth:api'])->prefix('order')->group(function () {
    Route::post('', [OrderController::class, 'store']);     
    Route::get('', [OrderController::class, 'index']);      
});



Route::middleware(['auth:api'])->prefix('payment')->group(function () {
    
    Route::post('vnpay/create/{orderId}', [PaymentController::class, 'createPayment']);
});

Route::get('vnpay/callback', [PaymentController::class, 'paymentCallback']);


Route::middleware(['auth:api'])->group(function () {
    
    
    Route::prefix('specificationattribute')->group(function () {
        Route::get('', [SpecificationAttributeController::class, 'index']);
        Route::get('{id}', [SpecificationAttributeController::class, 'show']);
        Route::post('', [SpecificationAttributeController::class, 'store']); // (Thực tế phân quyền Admin cho route tạo)
    });

    
    Route::prefix('specificationgroup')->group(function () {
        Route::get('', [SpecificationGroupController::class, 'index']);
        Route::get('{id}', [SpecificationGroupController::class, 'show']);
        Route::post('', [SpecificationGroupController::class, 'store']);
    });

    
    Route::prefix('specificationvalue')->group(function () {
        Route::get('', [SpecificationValueController::class, 'index']);
        Route::get('{id}', [SpecificationValueController::class, 'show']);
        Route::post('', [SpecificationValueController::class, 'store']);
    });

});