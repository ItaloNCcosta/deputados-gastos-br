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
        Schema::create('federal_deputies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('external_id', 100);
            $table->string('source_api', 50)->default('camara_v2');
            $table->string('cpf', 14)->nullable()->unique();
            $table->date('death_date')->nullable();
            $table->date('birth_date');
            $table->string('education_level', 100)->nullable();
            $table->string('birth_city', 100)->nullable();
            $table->string('legal_name', 200);
            $table->char('sex', 1);
            $table->char('birth_state_code', 2)->nullable();
            $table->string('resource_uri', 255);
            $table->string('website_url', 255)->nullable();
            $table->timestamps();

            $table->unique(['external_id', 'source_api']);
            $table->index(['external_id', 'source_api', 'legal_name', 'birth_state_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('federal_deputies');
    }
};
