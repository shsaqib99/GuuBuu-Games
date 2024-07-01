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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('shopifyA_host')->nullable();
            $table->string('shopifyA_api_version')->nullable();
            $table->string('shopifyA_access_token')->nullable();
            $table->string('shopifyB_host')->nullable();
            $table->string('shopifyB_api_version')->nullable();
            $table->string('shopifyB_access_token')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
