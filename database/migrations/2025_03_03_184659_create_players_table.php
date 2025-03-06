<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->string('position');
            $table->string('team')->nullable();
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->json('appearance')->nullable();
            $table->integer('speed')->default(50);
            $table->integer('strength')->default(50);
            $table->integer('agility')->default(50);
            $table->integer('stamina')->default(50);
            $table->integer('tackling')->default(50);
            $table->integer('kicking')->default(50);
            $table->integer('passing')->default(50);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
