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
        Schema::create('deputy_statuses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('external_id', 100);
            $table->string('source_api', 50)->default('camara_v2');
            $table->foreignUuid('deputy_id')->constrained('federal_deputies');
            $table->string('electoral_condition', 100);
            $table->date('date');
            $table->string('status_description', 255);
            $table->string('email', 100);
            $table->foreignUuid('legislature_id')->nullable()->constrained('legislatures');
            $table->string('name', 200);
            $table->string('ballot_name', 200);
            $table->string('party_acronym', 20);
            $table->char('state_code', 2);
            $table->string('status', 50);
            $table->string('resource_uri', 255);
            $table->string('party_uri', 255);
            $table->string('photo_url', 255);
            $table->boolean('is_current')->default(true);
            $table->timestamps();

            $table->index(['external_id', 'source_api', 'deputy_id', 'legislature_id', 'party_acronym', 'status', 'is_current']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deputy_statuses');
    }
};
