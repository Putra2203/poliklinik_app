<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index(){
        $obats = Obat::all();
        return view('admin.obat.index', compact('obats'));
    }

    public function create(){
        return view('admin.obat.create');
    }

    public function store(Request $request){
        $request->validate([
            'nama_obat' => 'required|string',
            'kemasan' => 'required|string',
            'harga' => 'required|integer',
            'stok' => 'required|integer|min:0',
        ]);

        Obat::create([
            'nama_obat' => $request->nama_obat,
            'kemasan' => $request->kemasan,
            'harga' => $request->harga,
            'stok' => $request->stok
        ]);

        return redirect()->route('obat.index')
            ->with('message','Data Obat Berhasil dibuat')
            ->with('type','success');
    }

    public function edit(string $id){
        $obat = Obat::findOrFail($id);
        return view('admin.obat.edit')->with([
            'obat'=> $obat
        ]);
    }

    public function update(Request $request, string $id){
        $request->validate([
            'nama_obat' => 'required|string',
            'kemasan' => 'nullable|string',
            'harga' => 'required|integer',
            'stok' => 'required|integer|min:0',
        ]);

        $obat = Obat::findOrFail($id);
        $obat->update([
            'nama_obat' => $request->nama_obat,
            'kemasan' => $request->kemasan,
            'harga' => $request->harga,
            'stok' => $request->stok
        ]);

        return redirect()->route('obat.index')
            ->with('message','Data Obat berhasil di edit')
            ->with('type', 'success');
    }

    public function destroy(string $id){
        $obat = Obat::findOrFail($id);
    
        // VALIDASI TAMBAHAN: CEK KETERGANTUNGAN DATA
        // Cek apakah obat ini ada di tabel detail_periksa?
        
        if ($obat->detailPeriksas()->count() > 0) {
            return redirect()->route('obat.index')
                ->with('message', 'GAGAL! Obat tidak bisa dihapus karena sudah pernah digunakan dalam riwayat pemeriksaan pasien. Silahkan edit stok menjadi 0 saja.')
                ->with('type', 'danger'); 
        }
    
        $obat->delete();
    
        return redirect()->route('obat.index')
            ->with('message','Data Obat berhasil di Hapus')
            ->with('type','success');
    }
}