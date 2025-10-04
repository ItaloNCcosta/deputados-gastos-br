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
        Schema::create('political_parties', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('external_id', 100);
            $table->string('source_api', 50)->default('camara_v2');
            $table->string('name', 200);
            $table->integer('electoral_number')->nullable();
            $table->string('acronym', 20);
            $table->string('resource_uri', 255);
            $table->string('facebook_url', 255)->nullable();
            $table->string('logo_url', 255)->nullable();
            $table->string('website_url', 255)->nullable();
            $table->timestamps();

            $table->unique(['external_id', 'source_api']);
            $table->index(['external_id', 'source_api', 'acronym']);
            $table->index('electoral_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('political_parties');
    }
};
