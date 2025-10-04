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
        Schema::create('parliamentary_fronts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('external_id', 100);
            $table->string('source_api', 50)->default('camara_v2');

            $table->string('email', 100)->nullable();
            $table->foreignUuid('legislature_id')->nullable()->constrained('legislatures'); // FK opcional
            $table->integer('status_id');
            $table->text('keywords')->nullable();
            $table->string('status', 50);
            $table->string('phone', 20)->nullable();
            $table->string('title', 255);
            $table->string('resource_uri', 255);
            $table->string('document_url', 255)->nullable();
            $table->string('website_url', 255)->nullable();

            $table->timestamps();

            $table->unique(['external_id', 'source_api']);
            $table->index(['external_id', 'source_api', 'legislature_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parliamentary_fronts');
    }
};
