<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoice_products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name')->default("");
            $table->integer('quantity')->default(0);
            $table->integer('price')->default(0);
            $table->integer('total_price')->default(0);

            $table->foreignId('invoice_id')->default(-1);
            $table->foreignId('order_id')->default(-1);
            $table->foreignId('product_id')->default(-1);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_products');
    }
};
