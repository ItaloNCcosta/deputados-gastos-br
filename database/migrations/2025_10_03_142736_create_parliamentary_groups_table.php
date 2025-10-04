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
        Schema::create('parliamentary_groups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('external_id', 100);
            $table->string('source_api', 50)->default('camara_v2');

            $table->string('creation_year', 4)->nullable();
            $table->boolean('is_active');
            $table->boolean('is_mixed_group');
            $table->string('name', 255);
            $table->text('notes')->nullable();
            $table->string('project_title', 255)->nullable();
            $table->string('project_uri', 255)->nullable();
            $table->string('resolution_title', 255)->nullable();
            $table->string('resolution_uri', 255)->nullable();
            $table->boolean('is_subsidized');
            $table->string('resource_uri', 255);

            $table->timestamps();

            $table->unique(['external_id', 'source_api']);
            $table->index(['external_id', 'source_api', 'is_active', 'creation_year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parliamentary_groups');
    }
};
