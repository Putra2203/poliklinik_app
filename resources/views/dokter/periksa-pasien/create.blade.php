<x-layouts.app title="Periksa Pasien">
    <div class="container-fluid px-4 mt-4">
        <div class="row">
            <div class="col-lg-8 offset-lg-2">
                <h1 class="mb-4">Periksa Pasien</h1>

                {{-- Tampilkan Error Validasi jika ada --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-stethoscope me-1"></i> Form Pemeriksaan
                    </div>
                    <div class="card-body">
                        <form action="{{ route('periksa-pasien.store') }}" method="POST">
                            @csrf
                            
                            <input type="hidden" name="id_daftar_poli" value="{{ $id }}">

                            <div class="form-group mb-3">
                                <label for="catatan" class="form-label fw-bold">Catatan Pemeriksaan</label>
                                <textarea name="catatan" id="catatan" class="form-control" rows="3" placeholder="Tulis diagnosa atau catatan untuk pasien..." required>{{ old('catatan') }}</textarea>
                            </div>

                            <hr>
                            
                            <div class="form-group mb-3">
                                <label class="form-label fw-bold">Resep Obat</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <select id="select-obat" class="form-select">
                                            <option value="" disabled selected>-- Pilih Obat --</option>
                                            @foreach ($obats as $obat)
                                                <option value="{{ $obat->id }}" 
                                                    data-nama="{{ $obat->nama_obat }}"
                                                    data-harga="{{ $obat->harga }}"
                                                    data-stok="{{ $obat->stok }}">
                                                    {{ $obat->nama_obat }} (Stok: {{ $obat->stok }}) - Rp{{ number_format($obat->harga, 0, ',', '.') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" id="input-jumlah" class="form-control" placeholder="Jumlah" min="1">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-primary w-100" onclick="tambahObat()">
                                            <i class="fas fa-plus"></i> Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive mb-3">
                                <table class="table table-bordered table-striped">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nama Obat</th>
                                            <th>Harga Satuan</th>
                                            <th>Jml</th>
                                            <th>Subtotal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabel-keranjang">
                                        </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="3" class="text-end fw-bold">Total Biaya Obat:</td>
                                            <td colspan="2" class="fw-bold" id="text-total">Rp 0</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <input type="hidden" name="obat_json" id="obat_json">
                            <input type="hidden" name="biaya_periksa" id="biaya_periksa" value="0">

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('periksa-pasien.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Simpan & Selesai
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let keranjang = []; 

        function tambahObat() {
            const select = document.getElementById('select-obat');
            const inputJumlah = document.getElementById('input-jumlah');
            
            const id = select.value;
            const jumlah = parseInt(inputJumlah.value);
            
            if (!id) {
                alert("Silahkan pilih obat terlebih dahulu!");
                return;
            }
            if (!jumlah || jumlah < 1) {
                alert("Jumlah obat harus diisi minimal 1!");
                return;
            }

            const option = select.options[select.selectedIndex];
            const nama = option.getAttribute('data-nama');
            const harga = parseInt(option.getAttribute('data-harga'));
            const stok = parseInt(option.getAttribute('data-stok'));

            if (jumlah > stok) {
                alert("Stok tidak cukup! Stok tersedia: " + stok);
                return;
            }

            const existingItem = keranjang.find(item => item.id == id);
            if (existingItem) {
                alert("Obat ini sudah ada di daftar. Hapus dulu jika ingin mengubah jumlah.");
                return;
            }

            keranjang.push({
                id: id,
                nama: nama,
                harga: harga,
                jumlah: jumlah,
                subtotal: harga * jumlah
            });

            select.value = "";
            inputJumlah.value = "";

            updateTabel();
        }

        function hapusObat(index) {
            keranjang.splice(index, 1);
            updateTabel();
        }

        function updateTabel() {
            const tbody = document.getElementById('tabel-keranjang');
            const textTotal = document.getElementById('text-total');
            const inputBiaya = document.getElementById('biaya_periksa');
            const inputJson = document.getElementById('obat_json');

            tbody.innerHTML = "";
            let grandTotal = 0;

            keranjang.forEach((item, index) => {
                grandTotal += item.subtotal;

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${item.nama}</td>
                    <td>Rp ${item.harga.toLocaleString('id-ID')}</td>
                    <td>${item.jumlah}</td>
                    <td>Rp ${item.subtotal.toLocaleString('id-ID')}</td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="hapusObat(${index})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            textTotal.innerText = "Rp " + grandTotal.toLocaleString('id-ID');
            inputBiaya.value = grandTotal; 

            const dataKirim = keranjang.map(item => {
                return { id: item.id, jumlah: item.jumlah };
            });
            inputJson.value = JSON.stringify(dataKirim);
        }
    </script>
</x-layouts.app>