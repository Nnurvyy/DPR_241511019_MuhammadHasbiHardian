<?php

namespace App\Http\Controllers;

use App\Models\KomponenGaji;
use Illuminate\Http\Request;

class KomponenGajiController extends Controller
{
    public function index()
    {
        return view('kelola-komponen-gaji');
    }


    // API untuk fetch semua komponen gaji (untuk komponen_gaji.js)
    public function all(Request $request)
    {
        $q = $request->q;
        $query = KomponenGaji::query(); // Mulai dengan query builder

        if ($q) {
            $query->where(function($sub) use ($q) {
                $sub->where('nama_komponen', 'ilike', "%$q%")

                    // Kolom Enum, Integer, dan Numeric perlu di-CAST ke TEXT
                    ->orWhereRaw('CAST(kategori AS TEXT) ilike ?', ["%$q%"])
                    ->orWhereRaw('CAST(jabatan AS TEXT) ilike ?', ["%$q%"])
                    ->orWhereRaw('CAST(nominal AS TEXT) ilike ?', ["%$q%"])
                    ->orWhereRaw('CAST(satuan AS TEXT) ilike ?', ["%$q%"])
                    ->orWhereRaw('CAST(id_komponen_gaji AS TEXT) ilike ?', ["%$q%"]);
            });
        }

        return response()->json($query->get());
    }


    // Store komponen gaji baru
    public function store(Request $request)
    {
        $nextId = KomponenGaji::max('id_komponen_gaji') + 1;
        $komponenGaji = KomponenGaji::create([
            'id_komponen_gaji' => $nextId,
            'nama_komponen' => $request->nama_komponen,
            'kategori' => $request->kategori,
            'jabatan' => $request->jabatan,
            'nominal' => $request->nominal,
            'satuan' => $request->satuan,
        ]);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($komponenGaji);
        }
    }


    // Update komponen gaji
    public function update(Request $request, KomponenGaji $komponenGaji)
    {
        $komponenGaji->update([
            'id_komponen_gaji' => $request->id_komponen_gaji,
            'nama_komponen' => $request->nama_komponen,
            'kategori' => $request->kategori,
            'jabatan' => $request->jabatan,
            'nominal' => $request->nominal,
            'satuan' => $request->satuan,
        ]);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($komponenGaji);
        }
    }

    
    // Hapus komponen gaji
    public function destroy(KomponenGaji $komponenGaji)
    {
        $komponenGaji->delete();
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
    }
}