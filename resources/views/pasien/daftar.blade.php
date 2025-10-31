<x-layouts.app title="Daftar Poli">
    <div class="container-fluid px-4 mt-4">
        <div class="row">
            <div class="col-lg-12">

                {{-- Alert flash message --}}
                @if (session('message'))
                    <div class="alert alert-{{ session('type', 'success') }} alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <h1 class="mb-4">Daftar Poli</h1>

                {{-- Form Pendaftaran --}}
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-clipboard-list"></i> Form Pendaftaran Poli</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('pasien.daftar.submit') }}" method="POST">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="no_rm" class="form-label">Nomor Rekam Medis</label>
                                        <input type="text" class="form-control" id="no_rm" 
                                            value="{{ $user->no_rm }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="nama" class="form-label">Nama Pasien</label>
                                        <input type="text" class="form-control" id="nama" 
                                            value="{{ $user->nama }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="id_poli" class="form-label fw-bold">Pilih Poli <span class="text-danger">*</span></label>
                                <div class="p-3 border border-primary rounded bg-light">
                                    <select class="form-select form-select-lg @error('id_poli') is-invalid @enderror" 
                                        id="id_poli" name="id_poli" required 
                                        style="border: 2px solid #0d6efd; font-size: 1.1rem;">
                                        <option value="">-- Pilih Poli --</option>
                                        @foreach ($polis as $poli)
                                            <option value="{{ $poli->id }}" {{ old('id_poli') == $poli->id ? 'selected' : '' }}>
                                                {{ $poli->nama_poli }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_poli')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="id_jadwal" class="form-label fw-bold">Pilih Jadwal <span class="text-danger">*</span></label>
                                <div class="p-3 border border-success rounded bg-light">
                                    <select class="form-select form-select-lg @error('id_jadwal') is-invalid @enderror" 
                                        id="id_jadwal" name="id_jadwal" required
                                        style="border: 2px solid #198754; font-size: 1.1rem;">
                                        <option value="" style="text-align: center;">-- Pilih Poli Terlebih Dahulu --</option>
                                    </select>
                                    @error('id_jadwal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted d-block mt-2">
                                        <i class="fas fa-info-circle"></i> Jadwal akan muncul setelah memilih poli
                                    </small>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="keluhan" class="form-label">Keluhan <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('keluhan') is-invalid @enderror" 
                                    id="keluhan" name="keluhan" rows="4" 
                                    placeholder="Tuliskan keluhan Anda..." required>{{ old('keluhan') }}</textarea>
                                @error('keluhan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-paper-plane"></i> Daftar
                                </button>
                                <button type="reset" class="btn btn-secondary">
                                    <i class="fas fa-redo"></i> Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Riwayat Pendaftaran --}}
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-history"></i> Riwayat Pendaftaran Poli</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width: 5%;">No</th>
                                        <th>Poli</th>
                                        <th>Dokter</th>
                                        <th>Hari</th>
                                        <th>Jam</th>
                                        <th>No. Antrian</th>
                                        <th>Keluhan</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($daftarPolis as $index => $daftar)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td>{{ $daftar->jadwalPeriksa->dokter->poli->nama_poli ?? '-' }}</td>
                                            <td>{{ $daftar->jadwalPeriksa->dokter->nama ?? '-' }}</td>
                                            <td>{{ $daftar->jadwalPeriksa->hari ?? '-' }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($daftar->jadwalPeriksa->jam_mulai)->format('H:i') }} - 
                                                {{ \Carbon\Carbon::parse($daftar->jadwalPeriksa->jam_selesai)->format('H:i') }}
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-primary fs-6">{{ $daftar->no_antrian }}</span>
                                            </td>
                                            <td>{{ $daftar->keluhan }}</td>
                                            <td class="text-center">
                                                @if ($daftar->periksas->count() > 0)
                                                    <span class="badge bg-success">Sudah Diperiksa</span>
                                                @else
                                                    <span class="badge bg-warning">Belum Diperiksa</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="8">
                                                <i class="fas fa-info-circle"></i> Belum ada riwayat pendaftaran
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
                setTimeout(() => alert.remove(), 500);
            }
        }, 3000);

        const jadwalData = @json($jadwals);
        
        function updateJadwalOptions() {
            const poliId = document.getElementById('id_poli').value;
            const jadwalSelect = document.getElementById('id_jadwal');
            
            console.log('Poli dipilih:', poliId); 
            
            // Reset jadwal select
            jadwalSelect.innerHTML = '<option value="" style="text-align: center;">-- Pilih Jadwal --</option>';
            
            if (poliId) {
                const filteredJadwal = jadwalData.filter(jadwal => {
                    return jadwal.dokter && jadwal.dokter.id_poli == poliId;
                });

                console.log('Jadwal terfilter:', filteredJadwal); 

                if (filteredJadwal.length > 0) {
                    filteredJadwal.forEach(jadwal => {
                        const option = document.createElement('option');
                        option.value = jadwal.id;
                        
                        let jamMulai = jadwal.jam_mulai.substring(0, 5);
                        let jamSelesai = jadwal.jam_selesai.substring(0, 5);
                        
                        const namaPoli = jadwal.dokter.poli ? jadwal.dokter.poli.nama_poli : 'Poli Tidak Diketahui';
                        const namaDokter = jadwal.dokter.nama;
                        
                        option.textContent = `${namaPoli} | ${jadwal.hari}, ${jamMulai} - ${jamSelesai} | ${namaDokter}`;
                        jadwalSelect.appendChild(option);
                    });
                } else {
                    jadwalSelect.innerHTML = '<option value="" style="text-align: center;">-- Tidak ada jadwal tersedia untuk poli ini --</option>';
                }
            } else {
                jadwalSelect.innerHTML = '<option value="" style="text-align: center;">-- Pilih Poli Terlebih Dahulu --</option>';
            }
        }

        // Event listener untuk perubahan poli
        document.addEventListener('DOMContentLoaded', function() {
            const poliSelect = document.getElementById('id_poli');
            if (poliSelect) {
                poliSelect.addEventListener('change', updateJadwalOptions);
            }
        });
    </script>

</x-layouts.app>
