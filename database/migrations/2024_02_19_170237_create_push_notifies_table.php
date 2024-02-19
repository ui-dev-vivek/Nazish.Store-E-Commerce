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
        Schema::create('push_notifies', function (Blueprint $table) {
            $table->id();
            $table->string('body');
            $table->timestamp('pushing_date');
            $table->string('ref_link');
            $table->unsignedBigInteger('image_url')->nullable();
            $table->foreign('image_url')->references('id')->on('images')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('push_notifies');
    }
};
