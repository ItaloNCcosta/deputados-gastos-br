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
        Schema::create('parliamentary_front_members', function (Blueprint $table) {
             $table->uuid('id')->primary();
            $table->foreignUuid('caucus_id')->constrained('parliamentary_fronts');
            $table->foreignUuid('deputy_id')->constrained('federal_deputies');
            $table->timestamps();

            $table->unique(['caucus_id', 'deputy_id']);
            $table->index('deputy_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parliamentary_front_members');
    }
};
