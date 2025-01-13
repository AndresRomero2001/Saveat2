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
        Schema::create('filters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->float('rating')->nullable();
            $table->json('price_ranges')->nullable();
            $table->foreignId('main_tag_id')->nullable()->constrained('tags');
            $table->foreignId('main_location_tag_id')->nullable()->constrained('tags');
            $table->timestamps();
        });

        Schema::create('filter_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('filter_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('filter_tag');
        Schema::dropIfExists('filters');
    }
};
