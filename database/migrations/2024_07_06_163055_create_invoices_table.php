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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('status')->default("created");
            $table->string('customer_email')->default('');
            $table->string('customer_phone')->default('');
            $table->string('customer_city')->default('');
            $table->string('customer_address')->default('');
            $table->string('customer_name')->default('');
            $table->integer('price')->default(0);
            $table->foreignId('order_id')->default(-1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
