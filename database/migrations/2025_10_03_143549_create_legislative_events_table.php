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
        Schema::create('legislative_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('external_id', 100);
            $table->string('source_api', 50)->default('camara_v2');

            $table->timestamp('start_at');
            $table->timestamp('end_at')->nullable();
            $table->text('description');
            $table->string('event_type_description', 100);
            $table->text('phases')->nullable();
            $table->string('external_location', 255)->nullable();
            $table->string('status', 50);

            $table->string('resource_uri', 255);
            $table->string('guests_uri', 255)->nullable();
            $table->string('representatives_uri', 255)->nullable();
            $table->string('agenda_document_url', 255)->nullable();
            $table->string('record_url', 255)->nullable();

            $table->timestamps();

            $table->unique(['external_id', 'source_api']);
            $table->index(['external_id', 'source_api', 'start_at', 'status', 'event_type_description']);
            $table->fullText('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legislative_events');
    }
};
