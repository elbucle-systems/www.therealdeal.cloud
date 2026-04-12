<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('match_predictions', function (Blueprint $table) {
            $table->id();
            $table->string('match_id');
            $table->string('username');
            $table->integer('predicted_score_a');
            $table->integer('predicted_score_b');
            $table->foreignId('league_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();

            $table->unique(['match_id', 'username']);
            $table->index('match_id');
            $table->index('username');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('match_predictions');
    }
};
