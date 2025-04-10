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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->string('sku', 100)->unique();
            $table->string('name', 255);
            $table->unsignedInteger('price');
            $table->unsignedInteger('stock');
            $table->foreignUuid('categoryId')->constrained('categories');
            $table->unsignedBigInteger('createdAt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
