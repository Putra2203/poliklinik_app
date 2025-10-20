<x-layouts.app title="Data Dokter">
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

                <h1 class="mb-4">Data Dokter</h1>

                <a href="{{ route('dokter.create') }}" class="btn btn-primary mb-3">
                    <i class="fas fa-plus"></i> Tambah dokter
                </a>

                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No. KTP</th>
                                <th>No. HP</th>
                                <th>Alamat</th>
                                <th>Poli</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dokters as $index => $dokter )
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $dokter->nama }}</td>
                                    <td>{{ $dokter->email }}</td>
                                    <td>{{ $dokter->no_ktp }}</td>
                                    <td>{{ $dokter->no_hp }}</td>
                                    <td>{{ $dokter->alamat }}</td>
                                    <td>
                                        <span class="badge bg-info">
                                            {{ $dokter->poli->nama_poli ?? 'Belum Di pilih' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('dokter.edit', $dokter->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        {{-- Karena Anda masih menggunakan fungsi confirm() di sini, saya biarkan, 
                                            tapi idealnya diganti dengan modal kustom. --}}
                                        <form action="{{ route('dokter.destroy', $dokter->id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus dokter ini ?')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="8">
                                        Belum ada Dokter
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
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
                setTimeout(() => alert.remove(), 500);
            }
        }, 2000);
    </script>

</x-layouts.app>
