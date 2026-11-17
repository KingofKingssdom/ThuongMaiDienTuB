<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->unsignedBigInteger('user_id');
            
            // Trạng thái đơn hàng, thanh toán (Lưu dưới dạng số nguyên hoặc chuỗi tùy ý, ở đây lưu tinyInteger tượng trưng cho Enum)
            $table->tinyInteger('order_status')->default(0); 
            
            $table->double('sub_total');
            $table->double('shipping_fee')->default(0);
            $table->double('discount_amount')->default(0);
            $table->double('grand_total');
            
            $table->tinyInteger('payment_method')->default(0);
            $table->tinyInteger('payment_status')->default(0);
            
            $table->string('receiver_name');
            $table->string('receiver_phone');
            $table->text('receiver_address');
            $table->text('note')->nullable();
            
            $table->timestamps();

            // Ràng buộc khóa ngoại với bảng users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};