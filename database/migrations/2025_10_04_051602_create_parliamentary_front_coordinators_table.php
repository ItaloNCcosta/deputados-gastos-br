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
        Schema::create('parliamentary_front_coordinators', function (Blueprint $table) {
           $table->uuid('id')->primary();
            $table->string('external_id', 100);
            $table->string('source_api', 50)->default('camara_v2');
            $table->foreignUuid('caucus_id')->constrained('parliamentary_fronts');
            $table->foreignUuid('deputy_id')->nullable()->constrained('federal_deputies');
            $table->string('email', 100);
            $table->foreignUuid('legislature_id')->nullable()->constrained('legislatures');
            $table->string('name', 200);
            $table->string('party_acronym', 20);
            $table->char('state_code', 2);
            $table->string('resource_uri', 255);
            $table->string('party_uri', 255);
            $table->string('photo_url', 255);
            $table->timestamps();

            $table->index(['external_id', 'source_api', 'caucus_id', 'deputy_id', 'legislature_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parliamentary_front_coordinators');
    }
};
