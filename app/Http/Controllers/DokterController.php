<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; 

class DokterController extends Controller
{
   
    public function index()
    {
        $dokters = User::where('role', 'dokter')->with('poli')->get();
        return view('admin.dokter.index', compact('dokters'));
    }


    public function create()
    {
        $polis = Poli::all();
        return view('admin.dokter.create', compact('polis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_ktp' => 'required|string|max:16|unique:users,no_ktp',
            'no_hp' => 'required|string|max:15',
            'id_poli' => 'required|string|exists:poli,id', 
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|min:6', 
        ]);
        
        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'dokter';

        User::create($validated);

        return redirect()->route('dokter.index')
            ->with('message', 'Data Dokter Berhasil di tambahkan')
            ->with('type', 'success');
    }

    public function edit(User $dokter)
    {
        $polis = Poli::all();
        return view('admin.dokter.edit', compact('dokter', 'polis'));
    }

    public function update(Request $request, User $dokter)
        {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_ktp' => [
                'required',
                'string',
                'max:16',
                Rule::unique('users', 'no_ktp')->ignore($dokter->id),
            ],
            'no_hp' => 'required|string|max:15',
            'id_poli' => 'required|string|exists:poli,id', 
            'email' => [
                'required',
                'string',
                Rule::unique('users', 'email')->ignore($dokter->id),
            ],
            'password' => 'nullable|string|min:6', 
        ]);
        
        $updateData = $validated;
        
        if (empty($updateData['password'])) {
             unset($updateData['password']);
        } else {
             $updateData['password'] = Hash::make($updateData['password']);
        }

        $dokter->update($updateData);

        return redirect()->route('dokter.index')
            ->with('message', 'Data Dokter Berhasil di ubah')
            ->with('type','success');
    }

    public function destroy(User $dokter)
    {
        $dokter->delete();
        return redirect()->route('dokter.index')
            ->with('message', 'Data Dokter Berhasil dihapus')
            ->with('type', 'success');
    }
}
