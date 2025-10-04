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
        Schema::create('political_party_leaders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('party_legislature_stats_id')->constrained('political_party_legislature_stats');
            $table->foreignUuid('legislature_id')->nullable()->constrained('legislatures');
            $table->string('name', 200);
            $table->string('party_acronym', 20);
            $table->char('state_code', 2);
            $table->string('resource_uri', 255);
            $table->string('party_uri', 255);
            $table->string('photo_url', 255);
            $table->timestamps();

            $table->index(['party_legislature_stats_id', 'legislature_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('political_party_leaders');
    }
};
