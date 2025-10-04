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
        Schema::create('political_party_memberships', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('party_id')->constrained('political_parties');
            $table->foreignUuid('deputy_id')->constrained('federal_deputies');
            $table->foreignUuid('legislature_id')->constrained('legislatures');
            $table->date('affiliation_date')->nullable();
            $table->date('disaffiliation_date')->nullable();
            $table->timestamps();

            $table->unique(['party_id', 'deputy_id', 'legislature_id']);
            $table->index(['party_id', 'deputy_id', 'legislature_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('political_party_memberships');
    }
};
