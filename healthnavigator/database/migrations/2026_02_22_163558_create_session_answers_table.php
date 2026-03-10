<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('session_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_session_id')->constrained('assessment_sessions')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->string('answer_value'); // must match question_options.value
            $table->timestamps();

            $table->unique(['assessment_session_id', 'question_id'], 'uq_session_question');
            $table->index(['assessment_session_id'], 'idx_session_answers');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('session_answers');
    }
};