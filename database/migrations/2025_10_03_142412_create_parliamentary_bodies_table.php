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
        Schema::create('parliamentary_bodies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('external_id', 100);
            $table->string('source_api', 50)->default('camara_v2');

            $table->string('alias', 200)->nullable();
            $table->string('house', 50);
            $table->integer('body_type_code');

            $table->date('end_date')->nullable();
            $table->date('original_end_date')->nullable();
            $table->date('start_date');
            $table->date('installation_date')->nullable();

            $table->string('name', 255);
            $table->string('published_name', 255)->nullable();
            $table->string('short_name', 100)->nullable();
            $table->string('room', 50)->nullable();

            $table->string('acronym', 50);
            $table->string('body_type', 100);

            $table->string('resource_uri', 255);
            $table->string('website_url', 255)->nullable();

            $table->timestamps();

            $table->unique(['external_id', 'source_api']);
            $table->index(['external_id', 'source_api', 'acronym', 'body_type', 'body_type_code', 'start_date', 'end_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parliamentary_bodies');
    }
};
