<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('session_posteriors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_session_id')->constrained('assessment_sessions')->cascadeOnDelete();
            $table->foreignId('condition_id')->constrained()->cascadeOnDelete();
            $table->float('prob')->default(0.0);
            $table->timestamps();

            $table->unique(['assessment_session_id', 'condition_id'], 'uq_session_condition');
            $table->index(['assessment_session_id', 'prob'], 'idx_session_prob');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('session_posteriors');
    }
};