<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
    Schema::create('borrowings', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('member_id');
        $table->unsignedBigInteger('book_id');
        $table->date('borrowed_at');
        $table->date('due_date');
        $table->string('status')->default('Borrowed');
        $table->timestamps();

        // Foreign Keys
        $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
        $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
    });
    }
};
