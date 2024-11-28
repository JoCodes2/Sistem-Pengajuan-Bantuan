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
        Schema::create('member_grups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('id_grup')->references('id')->on('grups')->onDelete('cascade');
            $table->string('name');
            $table->string('address');
            $table->string('place_birth');
            $table->date('date_birth');
            $table->string('nik');
            $table->enum('status', ['marry', 'singgle', 'divorced alive', 'divorced dead']);
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_grups');
    }
};
