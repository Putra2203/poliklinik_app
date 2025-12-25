<x-layouts.app title="Admin Dashboard">
    <div class="container-fluid px-4">
        
        <h1 class="mt-4">Dashboard Admin</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Ringkasan Data Poliklinik</li>
        </ol>

        <div class="row">

           

            

            <div class="col-xl-3 col-md-6">
                <div class="card bg-warning text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="h2 mb-0">{{ $totalPoli ?? 0 }}</div>
                                <div>Total Poli</div>
                            </div>
                            <i class="fas fa-hospital fa-3x opacity-50"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('polis.index') }}">Lihat Detail</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card bg-info text-white mb-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="h2 mb-0">{{ $totalObat ?? 0 }}</div>
                                <div>Jenis Obat</div>
                            </div>
                            <i class="fas fa-pills fa-3x opacity-50"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between">
                        <a class="small text-white stretched-link" href="{{ route('obat.index') }}">Kelola Obat</a>
                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card text-white mb-4 {{ ($totalStokMenipis ?? 0) > 0 ? 'bg-danger' : 'bg-success' }}">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0">
                                    @if(($totalStokMenipis ?? 0) > 0)
                                        <i class="fas fa-exclamation-triangle me-2"></i> 
                                        PERINGATAN: Ada {{ $totalStokMenipis }} obat dengan stok menipis/habis!
                                    @else
                                        <i class="fas fa-check-circle me-2"></i> 
                                        Status Stok Aman: Semua obat tersedia.
                                    @endif
                                </h4>
                                <small>Stok dianggap menipis jika kurang dari 10 unit.</small>
                            </div>
                            <a href="{{ route('obat.index') }}" class="btn btn-light text-dark btn-sm fw-bold">
                                Cek Stok Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

    </div>
</x-layouts.app>