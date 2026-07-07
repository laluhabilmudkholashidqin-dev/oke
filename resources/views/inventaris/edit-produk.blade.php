@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Produk</h1>
            <small class="text-muted">Perbarui informasi produk</small>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('inventaris.update', $produk->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama_produk" class="form-label">Nama Produk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_produk') is-invalid @enderror" 
                                   id="nama_produk" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" required>
                            @error('nama_produk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="kode_produk" class="form-label">Kode Produk <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('kode_produk') is-invalid @enderror" 
                                   id="kode_produk" name="kode_produk" value="{{ old('kode_produk', $produk->kode_produk) }}" required>
                            @error('kode_produk')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('kategori') is-invalid @enderror" 
                                           id="kategori" name="kategori" value="{{ old('kategori', $produk->kategori) }}" required>
                                    @error('kategori')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="satuan" class="form-label">Satuan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('satuan') is-invalid @enderror" 
                                           id="satuan" name="satuan" value="{{ old('satuan', $produk->satuan) }}" required>
                                    @error('satuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="stok" class="form-label">Stok <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('stok') is-invalid @enderror" 
                                           id="stok" name="stok" value="{{ old('stok', $produk->stok) }}" min="0" required>
                                    @error('stok')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="harga" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('harga') is-invalid @enderror" 
                                           id="harga" name="harga" value="{{ old('harga', $produk->harga) }}" min="0" step="0.01" required>
                                    @error('harga')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('inventaris.daftar-barang') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Perbarui Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bi bi-info-circle"></i> Informasi Produk</h5>
                </div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-5">Kode Produk:</dt>
                        <dd class="col-sm-7"><span class="badge bg-info">{{ $produk->kode_produk }}</span></dd>

                        <dt class="col-sm-5">Dibuat:</dt>
                        <dd class="col-sm-7"><small>{{ $produk->created_at->format('d/m/Y H:i') }}</small></dd>

                        <dt class="col-sm-5">Diperbarui:</dt>
                        <dd class="col-sm-7"><small>{{ $produk->updated_at->format('d/m/Y H:i') }}</small></dd>

                        <dt class="col-sm-5">Nilai:</dt>
                        <dd class="col-sm-7"><strong>Rp {{ number_format($produk->stok * $produk->harga, 0, ',', '.') }}</strong></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection