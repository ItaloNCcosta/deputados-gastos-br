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
        Schema::create('deputy_social_links', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('deputy_id')->constrained('federal_deputies');
            $table->string('url', 255);
            $table->timestamp('created_at')->nullable();

            $table->index('deputy_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deputy_social_links');
    }
};
