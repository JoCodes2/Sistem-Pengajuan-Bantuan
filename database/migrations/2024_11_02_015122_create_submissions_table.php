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
        Schema::create('submissions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_grup')->references('id')->on('grups')->onDelete('cascade');
            $table->enum('status_submissions', ['review', 'waiting', 'rejected', 'approved']);
            $table->date('date');
            $table->text('description');
            $table->string('file_proposal');
            $table->foreignUuid('id_user')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
