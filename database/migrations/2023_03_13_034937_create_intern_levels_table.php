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
        Schema::create('intern_levels', function (Blueprint $table) {
            $table->unsignedBigInteger('intern_id');
            $table->foreign('intern_id')->references('intern_id')->on('interns');
            $table->unsignedBigInteger('level_id');
            $table->foreign('level_id')->references('level_id')->on('levels');
            $table->timestamps();
        });

        DB::table('intern_levels')->insert([
            'intern_id' => 1,
            'level_id' => 5
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intern_levels');
    }
};