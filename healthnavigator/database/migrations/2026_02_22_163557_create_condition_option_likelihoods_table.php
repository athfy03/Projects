<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('condition_option_likelihoods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('condition_id')->constrained()->cascadeOnDelete();
            $table->foreignId('question_option_id')->constrained('question_options')->cascadeOnDelete();
            $table->float('prob'); // P(option | condition)
            $table->timestamps();

            // IMPORTANT: short index name to avoid MySQL name length error
            $table->unique(['condition_id', 'question_option_id'], 'uq_cond_opt');
            $table->index(['question_option_id'], 'idx_opt');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('condition_option_likelihoods');
    }
};