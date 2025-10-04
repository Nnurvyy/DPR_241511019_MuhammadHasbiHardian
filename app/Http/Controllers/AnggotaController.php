<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index()
    {
        return view('kelola-anggota');
    }
    public function index2()
    {
        return view('anggota-public');
    }


    // API untuk fetch semua anggota (untuk anggota.js)
    public function all(Request $request)
    {
        $q = $request->q;
        $query = Anggota::query(); // Mulai dengan query builder

        if ($q) {
            $query->where(function($sub) use ($q) {
                $sub->where('nama_depan', 'ilike', "%$q%")
                    ->orWhere('nama_belakang', 'ilike', "%$q%")
                    ->orWhere('gelar_depan', 'ilike', "%$q%")
                    ->orWhere('gelar_belakang', 'ilike', "%$q%")
                    ->orWhere('jumlah_anak', 'ilike', "%$q%")

                    // Sama seperti kasus penggajian, kolom Enum dan Integer perlu di-CAST
                    ->orWhereRaw('CAST(jabatan AS TEXT) ilike ?', ["%$q%"])
                    ->orWhereRaw('CAST(id_anggota AS TEXT) ilike ?', ["%$q%"])
                    ->orWhereRaw('CAST(status_pernikahan AS TEXT) ilike ?', ["%$q%"]);
            });
        }
        return response()->json($query->get());
    }


    // Simpan anggota baru
    public function store(Request $request)
    {
        $nextId = Anggota::max('id_anggota') + 1;
        $anggota = Anggota::create([
            'id_anggota' => $nextId,
            'nama_depan' => $request->nama_depan,
            'nama_belakang' => $request->nama_belakang,
            'gelar_depan' => $request->gelar_depan,
            'gelar_belakang' => $request->gelar_belakang,
            'jabatan' => $request->jabatan,
            'status_pernikahan' => $request->status_pernikahan,
            'jumlah_anak' => $request->jumlah_anak,
        ]);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($anggota);
        }
    }


    // Update anggota
    public function update(Request $request, Anggota $anggota)
    {
        $anggota->update([
            'id_anggota' => $request->id_anggota,
            'nama_depan' => $request->nama_depan,
            'nama_belakang' => $request->nama_belakang,
            'gelar_depan' => $request->gelar_depan,
            'gelar_belakang' => $request->gelar_belakang,
            'jabatan' => $request->jabatan,
            'status_pernikahan' => $request->status_pernikahan,
            'jumlah_anak' => $request->jumlah_anak,
        ]);
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($anggota);
        }
    }

    
    // Hapus anggota
    public function destroy(Anggota $anggota)
    {
        $anggota->delete();
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
    }
}