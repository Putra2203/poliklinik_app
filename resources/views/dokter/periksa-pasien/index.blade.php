<x-layouts.app title="Daftar Periksa Pasien">
    <div class="container-fluid px-4 mt-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Daftar Pasien Periksa</h1>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item active">Jadwal Hari Ini</li>
            </ol>
        </div>

        {{-- ALERT FLASH MESSAGE --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <i class="fas fa-table me-1"></i>
                Antrian Pasien
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="datatablesSimple">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th style="width: 25%;">Nama Pasien</th>
                                <th style="width: 35%;">Keluhan</th>
                                <th style="width: 15%;" class="text-center">No Antrian</th>
                                <th style="width: 20%;" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($daftarPasien as $dp)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-bold">{{ $dp->pasien->nama }}</td>
                                    <td>{{ $dp->keluhan }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-primary rounded-pill px-3">{{ $dp->no_antrian }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if ($dp->periksas->isNotEmpty())
                                            <a href="#" class="btn btn-sm btn-success disabled" aria-disabled="true">
                                                <i class="fas fa-check"></i> Selesai
                                            </a>
                                        @else
                                            <a href="{{ route('periksa-pasien.create', $dp->id) }}"
                                                class="btn btn-sm btn-warning text-white">
                                                <i class="fas fa-stethoscope me-1"></i> Periksa
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="fas fa-user-injured fa-3x text-muted mb-3"></i>
                                        <p class="text-muted mb-0">Belum ada pasien yang mendaftar di jadwal ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 4000);
    </script>
</x-layouts.app>