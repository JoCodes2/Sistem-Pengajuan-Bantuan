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
<<<<<<< HEAD
            $table->foreignUuid('id_grup')->constrained('grups');
=======
            $table->foreignUuid('id_grup')->references('id')->on('grups')->onDelete('cascade');
>>>>>>> 5df66dcd537e39058f3d6e6cd1041e51308289c6
            $table->string('name');
            $table->string('address');
            $table->string('place_birth');
            $table->date('date_birth');
            $table->string('nik');
            $table->string('status');
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
