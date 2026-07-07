<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk', 100);
            $table->string('kode_produk', 50)->unique();
            $table->string('kategori', 50);
            $table->integer('stok')->default(0);
            $table->decimal('harga', 12, 2);
            $table->string('satuan', 20);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produk');
    }
};