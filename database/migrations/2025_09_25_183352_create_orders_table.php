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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->json('items');                 // store items as JSON array
            $table->decimal('subtotal', 10, 2);
            $table->decimal('gst_percent', 5, 2);
            $table->decimal('gst_amount', 10, 2);
            $table->string('discount_type')->nullable();   // fixed / percent
            $table->decimal('discount_value', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->timestamp('order_time')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
