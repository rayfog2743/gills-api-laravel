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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('variation_id')->constrained('variations')->cascadeOnDelete();
            $table->string('attribute_name');
            $table->decimal('price', 10, 2)->default(0);
            $table->string('image')->nullable(); // store path like storage/app/public/attributes/xxx.jpg
           
            $table->unique(['variation_id','attribute_name']); 
            
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};
