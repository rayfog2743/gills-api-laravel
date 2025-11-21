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
        Schema::create('gst', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();

            $table->id();
            $table->string('name'); // e.g., "CGST", "SGST", "IGST"
            $table->decimal('percentage', 5, 2); // e.g., 18.00
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gst');
    }
};
