<x-layouts.app>
    <div class="container-fluid px-4 mt-4">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h1 class="mb-4">Edit Dokter</h1>
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('dokter.update', $dokter->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="nama" class="form-label">Nama Dokter <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                            id="nama" name="nama" value="{{ old('nama', $dokter->nama) }}"
                                            required>
                                        @error('nama')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="email" class="form-label">Email <span
                                                class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email', $dokter->email) }}"
                                            required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="no_ktp" class="form-label">No KTP <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('no_ktp') is-invalid @enderror"
                                            id="no_ktp" name="no_ktp" value="{{ old('no_ktp', $dokter->no_ktp) }}"
                                            required>
                                        @error('no_ktp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="no_hp" class="form-label">No HP <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('no_hp') is-invalid @enderror"
                                            id="no_hp" name="no_hp" value="{{ old('no_hp', $dokter->no_hp) }}"
                                            required placeholder="Contoh: 081234567890">
                                        @error('no_hp')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Field Password untuk Edit -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="password" class="form-label">Password Baru</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="form-text text-muted">
                                            Biarkan kosong jika tidak ingin mengubah password
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                        <input type="password" class="form-control"
                                            id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password baru">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="alamat" class="form-label">Alamat <span
                                        class="text-danger">*</span></label>
                                <textarea required name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $dokter->alamat) }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="id_poli" class="form-label">Poli <span class="text-danger">*</span></label>
                                <select name="id_poli" id="id_poli"
                                    class="form-control @error('id_poli') is-invalid @enderror" required>
                                    <option value="" {{ old('id_poli', $dokter->id_poli) ? '' : 'selected' }}>
                                        Pilih Poli</option>
                                    @foreach ($polis as $poli)
                                        <option value="{{ $poli->id }}"
                                            {{ (string) old('id_poli', $dokter->id_poli) === (string) $poli->id ? 'selected' : '' }}>
                                            {{ $poli->nama_poli ?? 'Poli Tidak Dikenal' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_poli')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Update
                                </button>
                                <a href="{{ route('dokter.index') }}" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>