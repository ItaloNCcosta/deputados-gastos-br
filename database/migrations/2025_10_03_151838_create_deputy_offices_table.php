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
        Schema::create('deputy_offices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('deputy_status_id')->constrained('deputy_statuses');
            $table->string('floor', 10);
            $table->string('email', 100);
            $table->string('name', 100);
            $table->string('building', 100);
            $table->string('room', 20);
            $table->string('phone', 20);
            $table->timestamp('created_at')->nullable();

            $table->index('deputy_status_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deputy_offices');
    }
};
