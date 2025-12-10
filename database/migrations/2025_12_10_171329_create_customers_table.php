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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
         

            // Required fields
            $table->string('client_name');
            $table->text('address');
            $table->string('pincode', 10);

            // Auto-filled from pincode API
            $table->string('district')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();

            // Required field
            $table->string('mobile', 20);

            // Optional fields
            $table->string('email')->nullable();
            $table->string('retailer')->nullable();
            $table->string('supplier')->nullable();
            $table->string('depositor_name')->nullable();

            // Legal numbers
            $table->string('pan')->nullable();
            $table->string('tan')->nullable();
            $table->string('gstin')->nullable();



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
