@extends('layouts.app')

@section('title', 'Informasi Inventaris')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="mb-0"><i class="bi bi-info-circle"></i> Informasi Inventaris</h1>
            <small class="text-muted">Ringkasan lengkap status inventaris Anda</small>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-label">
                    <i class="bi bi-box2"></i> Total Produk
                </div>
                <div class="stat-value">{{ $totalProduk }}</div>
                <small>Jumlah jenis produk terdaftar</small>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="stat-label">
                    <i class="bi bi-stack"></i> Total Stok
                </div>
                <div class="stat-value">{{ $totalStok }}</div>
                <small>Unit stok keseluruhan</small>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="stat-label">
                    <i class="bi bi-cash-coin"></i> Estimasi Nilai
                </div>
                <div class="stat-value" style="font-size: 24px;">Rp {{ number_format($estimasiNilai, 0, ',', '.') }}</div>
                <small>Nilai total semua inventaris</small>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bi bi-bar-chart"></i> Statistik Umum</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tbody>
                            <tr>
                                <td>Jumlah Jenis Produk</td>
                                <td class="text-end"><strong>{{ $totalProduk }} item</strong></td>
                            </tr>
                            <tr>
                                <td>Total Unit Stok</td>
                                <td class="text-end"><strong>{{ $totalStok }} unit</strong></td>
                            </tr>
                            <tr>
                                <td>Rata-rata Stok per Produk</td>
                                <td class="text-end"><strong>{{ $totalProduk > 0 ? round($totalStok / $totalProduk, 2) : 0 }} unit</strong></td>
                            </tr>
                            <tr>
                                <td>Nilai Total Inventaris</td>
                                <td class="text-end"><strong>Rp {{ number_format($estimasiNilai, 0, ',', '.') }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bi bi-lightbulb"></i> Informasi Penting</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-2" role="alert">
                        <i class="bi bi-info-circle"></i>
                        <strong>Total Produk:</strong> Ada {{ $totalProduk }} jenis produk yang terdaftar dalam sistem.
                    </div>
                    <div class="alert alert-warning mb-2" role="alert">
                        <i class="bi bi-exclamation-triangle"></i>
                        <strong>Total Stok:</strong> Keseluruhan stok inventaris adalah {{ $totalStok }} unit.
                    </div>
                    <div class="alert alert-success mb-0" role="alert">
                        <i class="bi bi-check-circle"></i>
                        <strong>Estimasi Nilai:</strong> Nilai perkiraan semua inventaris adalah Rp {{ number_format($estimasiNilai, 0, ',', '.') }}.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0"><i class="bi bi-question-circle"></i> FAQ - Pertanyaan Umum</h5>
                </div>
                <div class="card-body">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Bagaimana cara menambah produk baru?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Klik menu "Tambah Produk" di sidebar, isi semua data yang diperlukan, kemudian klik tombol "Simpan Produk".
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Bagaimana cara mengedit produk?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Buka "Daftar Barang", cari produk yang ingin diedit, klik tombol "Edit" (pensil), ubah data, dan klik "Perbarui Produk".
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Bagaimana cara menghapus produk?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Buka "Daftar Barang", cari produk, klik tombol "Hapus" (trash), dan konfirmasi penghapusan.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12 text-center">
            <a href="{{ route('inventaris.daftar-barang') }}" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Barang
            </a>
        </div>
    </div>
</div>
@endsection