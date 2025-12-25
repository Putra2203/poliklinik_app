<x-layouts.app title="Riwayat Pasien">
    <div class="container-fluid px-4 mt-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Riwayat Pasien</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active">Daftar Pemeriksaan Selesai</li>
            </ol>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <i class="fas fa-history me-1"></i>
                Data Riwayat Periksa
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="datatablesSimple">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 20%;">Nama Pasien</th>
                                <th style="width: 25%;">Keluhan</th>
                                <th style="width: 15%;">Tanggal Periksa</th>
                                <th style="width: 15%;">Biaya Total</th>
                                <th style="width: 10%;">No Antrian</th>
                                <th style="width: 10%;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riwayatPasien as $index => $riwayat)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="fw-bold">{{ $riwayat->daftarPoli->pasien->nama }}</td>
                                    <td>{{ $riwayat->daftarPoli->keluhan }}</td>
                                    <td>{{ \Carbon\Carbon::parse($riwayat->tgl_periksa)->format('d/m/Y') }}</td>
                                    <td>Rp {{ number_format($riwayat->biaya_periksa, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary rounded-pill">{{ $riwayat->daftarPoli->no_antrian }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('riwayat-pasien.show', $riwayat->id) }}"
                                            class="btn btn-info btn-sm text-white"
                                            title="Lihat Detail Resep & Catatan">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                        <p class="text-muted mb-0">Belum ada riwayat pemeriksaan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>