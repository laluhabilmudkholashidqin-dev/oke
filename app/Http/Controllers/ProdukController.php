<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function daftarBarang()
    {
        $produk = Produk::paginate(10);
        return view('inventaris.daftar-barang', ['produk' => $produk]);
    }

    public function tambahProduk()
    {
        return view('inventaris.tambah-produk');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:100',
            'kode_produk' => 'required|string|unique:produk,kode_produk',
            'kategori' => 'required|string|max:50',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:20',
            'deskripsi' => 'nullable|string',
        ]);

        Produk::create($validated);

        return redirect()->route('inventaris.daftar-barang')
                       ->with('success', 'Produk berhasil ditambahkan!');
    }

    public function informasi()
    {
        $totalProduk = Produk::count();
        $totalStok = Produk::sum('stok');
        $estimasiNilai = Produk::selectRaw('SUM(stok * harga) as total_nilai')->value('total_nilai') ?? 0;
        
        return view('inventaris.informasi', [
            'totalProduk' => $totalProduk,
            'totalStok' => $totalStok,
            'estimasiNilai' => $estimasiNilai,
        ]);
    }

    public function edit(Produk $produk)
    {
        return view('inventaris.edit-produk', ['produk' => $produk]);
    }

    public function update(Request $request, Produk $produk)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:100',
            'kode_produk' => 'required|string|unique:produk,kode_produk,' . $produk->id,
            'kategori' => 'required|string|max:50',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:20',
            'deskripsi' => 'nullable|string',
        ]);

        $produk->update($validated);

        return redirect()->route('inventaris.daftar-barang')
                       ->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();

        return redirect()->route('inventaris.daftar-barang')
                       ->with('success', 'Produk berhasil dihapus!');
    }
}