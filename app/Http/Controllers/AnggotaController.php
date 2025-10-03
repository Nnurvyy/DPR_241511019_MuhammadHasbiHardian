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

    // API untuk fetch semua anggota (untuk anggota.js)
    public function all()
    {
        return response()->json(Anggota::all());
    }

    // Store anggota baru
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