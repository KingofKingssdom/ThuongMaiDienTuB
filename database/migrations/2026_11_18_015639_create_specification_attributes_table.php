<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('specification_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('label_specification');
            $table->unsignedBigInteger('specification_group_id');
            $table->timestamps();

            $table->foreign('specification_group_id')->references('id')->on('specification_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specification_attributes');
    }
};
