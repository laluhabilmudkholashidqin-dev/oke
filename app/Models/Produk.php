<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $fillable = ['nama_produk', 'kode_produk', 'kategori', 'stok', 'harga', 'satuan', 'deskripsi'];

    public function getNilaiEstimasiAttribute()
    {
        return $this->stok * $this->harga;
    }
}