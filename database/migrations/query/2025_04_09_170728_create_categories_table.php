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
        Schema::connection('mysql_query')->create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
            $table->string('name', 255);
            $table->unsignedBigInteger('createdAt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql_query')->dropIfExists('categories');
    }
};
