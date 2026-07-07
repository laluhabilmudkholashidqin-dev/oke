<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProduk = Produk::count();
        $totalStok = Produk::sum('stok');
        $estimasiNilai = Produk::selectRaw('SUM(stok * harga) as total_nilai')->value('total_nilai') ?? 0;

        return view('dashboard.index', [
            'totalProduk' => $totalProduk,
            'totalStok' => $totalStok,
            'estimasiNilai' => $estimasiNilai,
        ]);
    }
}