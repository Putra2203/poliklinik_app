<x-layouts.app title="Detail Riwayat Pasien">
    <div class="container-fluid px-4 mt-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Detail Pemeriksaan</h1>
            <a href="{{ route('riwayat-pasien.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-user me-1"></i> Data Pasien
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <th class="ps-0 w-25">Nama</th>
                                <td>: {{ $periksa->daftarPoli->pasien->nama }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0">No Antrian</th>
                                <td>: <span class="badge bg-warning text-dark">{{ $periksa->daftarPoli->no_antrian }}</span></td>
                            </tr>
                            <tr>
                                <th class="ps-0">Keluhan</th>
                                <td>: {{ $periksa->daftarPoli->keluhan }}</td>
                            </tr>
                            <tr>
                                <th class="ps-0">Tgl Periksa</th>
                                <td>: {{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('d M Y, H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <i class="fas fa-notes-medical me-1"></i> Catatan Dokter
                    </div>
                    <div class="card-body bg-light">
                        <p class="card-text fst-italic">
                            "{{ $periksa->catatan ?: 'Tidak ada catatan tambahan.' }}"
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <i class="fas fa-pills me-1"></i> Resep Obat
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%;">No</th>
                                        <th>Nama Obat</th>
                                        <th style="width: 20%;" class="text-end">Harga Satuan</th>
                                        <th style="width: 10%;" class="text-center">Jml</th>
                                        <th style="width: 20%;" class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $totalObat = 0; @endphp
                                    @forelse($periksa->detailPeriksas as $index => $detail)
                                        @php 
                                            $subtotal = $detail->obat->harga * $detail->jumlah;
                                            $totalObat += $subtotal;
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                {{ $detail->obat->nama_obat }}
                                                <small class="text-muted d-block">{{ $detail->obat->kemasan }}</small>
                                            </td>
                                            <td class="text-end">Rp {{ number_format($detail->obat->harga, 0, ',', '.') }}</td>
                                            <td class="text-center fw-bold">{{ $detail->jumlah }}</td>
                                            <td class="text-end fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Tidak ada obat yang diresepkan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="text-end">Total Biaya Obat</td>
                                        <td class="text-end fw-bold">Rp {{ number_format($totalObat, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-primary">
                    <div class="card-body">
                        <h5 class="card-title">Rincian Pembayaran</h5>
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Jasa Dokter & Pemeriksaan</span>
                            <span class="fw-bold">Rp 150.000</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Biaya Obat</span>
                            <span class="fw-bold">Rp {{ number_format($totalObat, 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 text-primary">Grand Total</h4>
                            <h3 class="mb-0 text-primary fw-bold">Rp {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-layouts.app>