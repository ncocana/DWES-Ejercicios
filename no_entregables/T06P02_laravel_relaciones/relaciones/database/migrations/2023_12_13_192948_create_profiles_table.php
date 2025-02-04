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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            // RELATION REQUIRED: "USER HASONE PROFILE - PROFILE BELONGSTO USER"
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('alias');
            $table->string('address');
            // $table->integer('user_id')->unsigned();
            // $table->foreign('user_id')->references('id')->on('users')
            // ->onUpdate('cascade')
            // ->onDelete('set null');
            // $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
