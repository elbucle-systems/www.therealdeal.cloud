<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leagues', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->foreignId('manager_id')->constrained('users')->cascadeOnDelete();
            $table->integer('points_per_score')->default(3);
            $table->integer('points_per_result')->default(1);
            $table->boolean('predictions_visible_before_game')->default(false);
            $table->unsignedInteger('members_size_limit')->nullable();
            $table->boolean('grouped_deadline')->default(false);
            $table->integer('deadline_days')->default(1);
            $table->char('unique_code', 6)->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leagues');
    }
};
