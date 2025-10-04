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
        Schema::create('parliamentary_group_statuses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('parliamentary_group_id')->constrained('parliamentary_groups');
            $table->date('status_date');
            $table->string('legislature_code', 10);
            $table->string('official_letter_title', 255)->nullable();
            $table->string('official_letter_uri', 255)->nullable();
            $table->string('president_name', 200)->nullable();
            $table->string('president_uri', 255)->nullable();
            $table->boolean('is_current')->default(true);
            $table->timestamps();

            $table->index(['parliamentary_group_id', 'legislature_code', 'is_current']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parliamentary_group_statuses');
    }
};
