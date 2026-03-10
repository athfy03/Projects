<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('question_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->string('value'); // stored value
            $table->string('label'); // display
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['question_id', 'value'], 'uq_q_opt_value');
            $table->index(['question_id', 'sort_order'], 'idx_q_opt_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('question_options');
    }
};