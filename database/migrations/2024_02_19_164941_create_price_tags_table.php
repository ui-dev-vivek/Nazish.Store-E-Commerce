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
        Schema::create('price_tags', function (Blueprint $table) {
            $table->id();
            $table->enum('platform', ['FlipKart', 'Meesho', 'Anazon', 'Others']);
            $table->string('ref_link');
            $table->double('price');
            $table->enum('discount_type', ['Per', 'num']);
            $table->integer('discount');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('price_tags');
    }
};
