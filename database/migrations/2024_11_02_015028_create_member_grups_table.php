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
            $table->foreignUuid('id_grup')->constrained('grups');
            $table->string('name');
            $table->string('address');
            $table->date('ttl');
            $table->string('nik');
            $table->string('status');
            $table->timestamps();

            // Menambahkan foreign key secara manual untuk UUID
            $table->foreign('id_grup')->references('id')->on('grups')->onDelete('cascade');
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
