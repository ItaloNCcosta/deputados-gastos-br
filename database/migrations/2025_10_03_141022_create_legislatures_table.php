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
        Schema::create('legislatures', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('external_id', 100);
            $table->string('source_api', 50);
            $table->date('start_date');
            $table->date('end_date');
            $table->string('resource_uri', 255);
            $table->timestamps();

            $table->unique(['external_id', 'source_api']);
            $table->index(['external_id', 'source_api', 'start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legislatures');
    }
};
