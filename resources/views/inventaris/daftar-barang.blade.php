@extends('layouts.app')

@section('title', 'Daftar Barang')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="mb-0"><i class="bi bi-list-ul"></i> Daftar Barang</h1>
            <small class="text-muted">Kelola semua produk inventaris Anda</small>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('inventaris.tambah-produk') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Tambah Produk
            </a>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th width="10%">Kode</th>
                        <th width="20%">Nama Produk</th>
                        <th width="15%">Kategori</th>
                        <th width="10%">Stok</th>
                        <th width="10%">Satuan</th>
                        <th width="15%">Harga</th>
                        <th width="10%">Nilai</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produk as $item)
                        <tr>
                            <td><span class="badge bg-info">{{ $item->kode_produk }}</span></td>
                            <td>{{ $item->nama_produk }}</td>
                            <td>{{ $item->kategori }}</td>
                            <td>
                                <span class="badge {{ $item->stok > 10 ? 'bg-success' : ($item->stok > 0 ? 'bg-warning' : 'bg-danger') }}">
                                    {{ $item->stok }}
                                </span>
                            </td>
                            <td>{{ $item->satuan }}</td>
                            <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($item->stok * $item->harga, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('inventaris.edit', $item->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('inventaris.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem; color: #ccc;"></i>
                                <p class="mt-2 text-muted">Belum ada data produk</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $produk->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection