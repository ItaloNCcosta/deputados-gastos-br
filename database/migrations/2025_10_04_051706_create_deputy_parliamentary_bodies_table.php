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
        Schema::create('deputy_parliamentary_bodies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('deputy_id')->constrained('federal_deputies');
            $table->foreignUuid('body_id')->constrained('parliamentary_bodies');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('role_title', 100)->nullable();
            $table->timestamps();

            $table->index(['deputy_id', 'body_id', 'start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deputy_parliamentary_bodies');
    }
};
