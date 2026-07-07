@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="mb-0"><i class="bi bi-speedometer2"></i> Dashboard</h1>
            <small class="text-muted">Ringkasan informasi inventaris Anda</small>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-label">
                    <i class="bi bi-box2"></i> Total Produk
                </div>
                <div class="stat-value">{{ $totalProduk }}</div>
                <small>Jumlah produk terdaftar</small>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="stat-label">
                    <i class="bi bi-stack"></i> Total Stok
                </div>
                <div class="stat-value">{{ $totalStok }}</div>
                <small>Jumlah unit stok keseluruhan</small>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="stat-label">
                    <i class="bi bi-cash-coin"></i> Estimasi Nilai
                </div>
                <div class="stat-value">Rp {{ number_format($estimasiNilai, 0, ',', '.') }}</div>
                <small>Nilai total inventaris</small>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bi bi-graph-up"></i> Akses Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('inventaris.daftar-barang') }}" class="btn btn-outline-primary btn-lg w-100 mb-2">
                                <i class="bi bi-list-ul"></i> Lihat Daftar Barang
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('inventaris.tambah-produk') }}" class="btn btn-outline-success btn-lg w-100 mb-2">
                                <i class="bi bi-plus-circle"></i> Tambah Produk Baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection