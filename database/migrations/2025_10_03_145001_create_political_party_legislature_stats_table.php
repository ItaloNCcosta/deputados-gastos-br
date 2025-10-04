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
        Schema::create('political_party_legislature_stats', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('party_id')->constrained('political_parties'); // FK
            $table->date('date');
            $table->string('legislature_code', 10);
            $table->string('status', 50);
            $table->integer('members_total');
            $table->integer('sworn_in_total');
            $table->string('members_resource_uri', 255);
            $table->timestamp('created_at')->nullable();

            $table->index(['party_id', 'legislature_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('political_party_legislature_stats');
    }
};
