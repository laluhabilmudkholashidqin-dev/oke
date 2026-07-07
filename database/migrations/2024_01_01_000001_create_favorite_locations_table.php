<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('favorite_locations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('city', 100);
            $table->timestamps();
            $table->unique(['user_id', 'city']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('favorite_locations');
    }
};
