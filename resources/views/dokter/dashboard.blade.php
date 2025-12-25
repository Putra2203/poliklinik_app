<x-layouts.app title="Dashboard Dokter">
    <div class="container-fluid px-4">
        
        <h1 class="mt-4">Dashboard Dokter</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Selamat Datang, dr. {{ Auth::user()->name }}</li>
        </ol>

        <div class="row">
            
            <div class="col-xl-6 col-md-6">
                <div class="card bg-primary text-white mb-4 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="h1 mb-0 font-weight-bold">{{ $pasienBelumDiperiksa ?? 0 }}</div>
                                <div>Pasien Menunggu Diperiksa</div>
                            </div>
                            <i class="fas fa-user-injured fa-4x opacity-50"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link fw-bold" href="{{ route('periksa-pasien.index') }}">
                            Mulai Periksa Sekarang
                        </a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-md-6">
                <div class="card bg-success text-white mb-4 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="h1 mb-0 font-weight-bold">{{ $pasienSudahDiperiksa ?? 0 }}</div>
                                <div>Total Pasien Telah Diperiksa</div>
                            </div>
                            <i class="fas fa-history fa-4x opacity-50"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('riwayat-pasien.index') }}">
                            Lihat Riwayat
                        </a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-4 border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Status Pelayanan
                                </div>
                                @if(($pasienBelumDiperiksa ?? 0) > 0)
                                    <h4 class="h5 mb-0 font-weight-bold text-gray-800">
                                        Ada <span class="text-danger">{{ $pasienBelumDiperiksa }} pasien</span> dalam antrian. Silahkan menuju menu 
                                        <a href="{{ route('periksa-pasien.index') }}" class="text-decoration-underline">Periksa Pasien</a>.
                                    </h4>
                                @else
                                    <h4 class="h5 mb-0 font-weight-bold text-gray-800">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Tidak ada antrian saat ini. Semua pasien telah diperiksa.
                                    </h4>
                                @endif
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-stethoscope fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="mt-4 mb-3">Menu Cepat</h4>
        <div class="row">
            <div class="col-md-4">
                <a href="{{ route('periksa-pasien.index') }}" class="text-decoration-none">
                    <div class="card shadow-sm h-100 py-2 border-primary hover-card">
                        <div class="card-body text-center">
                            <i class="fas fa-stethoscope fa-3x text-primary mb-3"></i>
                            <h5 class="text-dark">Periksa Pasien</h5>
                            <p class="text-muted small">Input pemeriksaan dan resep obat</p>
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="col-md-4">
                <a href="{{ route('riwayat-pasien.index') }}" class="text-decoration-none">
                    <div class="card shadow-sm h-100 py-2 border-success hover-card">
                        <div class="card-body text-center">
                            <i class="fas fa-notes-medical fa-3x text-success mb-3"></i>
                            <h5 class="text-dark">Riwayat Pasien</h5>
                            <p class="text-muted small">Lihat data pemeriksaan sebelumnya</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                {{-- Asumsi ada route jadwal --}}
                <a href="{{ route('jadwal-periksa.index') }}" class="text-decoration-none">
                    <div class="card shadow-sm h-100 py-2 border-warning hover-card">
                        <div class="card-body text-center">
                            <i class="fas fa-calendar-alt fa-3x text-warning mb-3"></i>
                            <h5 class="text-dark">Jadwal Saya</h5>
                            <p class="text-muted small">Kelola jam praktek anda</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

    </div>

    {{-- Sedikit CSS tambahan untuk efek hover --}}
    <style>
        .hover-card:hover {
            transform: translateY(-5px);
            transition: transform 0.3s;
            cursor: pointer;
            background-color: #f8f9fa;
        }
    </style>
</x-layouts.app>