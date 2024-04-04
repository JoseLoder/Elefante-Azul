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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->dateTime('entry');
            $table->dateTime('exit');
            $table->string('name');
            $table->string('phone');
            $table->string('car');
            $table->string('license_plate');
            // $table->foreign('tipe_wash')->constrained('tipe_wash'); TODO!!!
            $table->integer('wheels');
            $table->integer('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
