<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Penggajian;
use App\Models\KomponenGaji;
use Illuminate\Http\Request;
use App\Models\Anggota;

class PenggajianController extends Controller{
    public function index()
    {
        return view('kelola-penggajian');
    }
    public function index2()
    {
        return view('penggajian-public');
    }

    public function all(Request $request)
    {
        $q = $request->q;

        // Ambil semua data penggajian yang relevan tanpa di-group
        $allPenggajian = DB::table('penggajian')
            ->join('anggota', 'penggajian.id_anggota', '=', 'anggota.id_anggota')
            ->join('komponen_gaji', 'penggajian.id_komponen_gaji', '=', 'komponen_gaji.id_komponen_gaji')
            ->select(
                'anggota.id_anggota', 'anggota.gelar_depan', 'anggota.nama_depan', 'anggota.nama_belakang',
                'anggota.gelar_belakang', 'anggota.jabatan', 'anggota.status_pernikahan', 'anggota.jumlah_anak',
                'komponen_gaji.nama_komponen', 'komponen_gaji.nominal'
            )
            ->get();

        // Mengelompokkan data berdasarkan id_anggota menggunakan Collection
        $grouped = $allPenggajian->groupBy('id_anggota');
        
        // Siapkan collection kosong untuk menampung hasil akhir
        $result = collect();

        // Loop setiap anggota dan hitung take_home_pay dengan logika dari 'show'
        foreach ($grouped as $id_anggota => $komponenList) {
            $anggota = $komponenList->first(); // Data anggota sama untuk semua baris, jadi ambil yang pertama


            $take_home_pay = $komponenList->sum('nominal');

            $tunjanganAnakKomponen = $komponenList->firstWhere('nama_komponen', 'Tunjangan Anak');

            if ($tunjanganAnakKomponen && $anggota->jumlah_anak > 1) {
                $anakDihitung = min($anggota->jumlah_anak, 2);
                $tambahanTunjanganAnak = $tunjanganAnakKomponen->nominal * ($anakDihitung - 1);
                $take_home_pay += $tambahanTunjanganAnak;
            }
            

            // Memasukkan hasil perhitungan ke dalam collection result
            $result->push([
                'id_anggota' => $anggota->id_anggota,
                'gelar_depan' => $anggota->gelar_depan,
                'nama_depan' => $anggota->nama_depan,
                'nama_belakang' => $anggota->nama_belakang,
                'gelar_belakang' => $anggota->gelar_belakang,
                'jabatan' => $anggota->jabatan,
                'take_home_pay' => $take_home_pay
            ]);
        }
        
        // Jika ada query pencarian, filter hasil akhir di PHP
        if ($q) {
            $result = $result->filter(function ($item) use ($q) {
                $namaLengkap = trim(($item['gelar_depan'] ?? '') . ' ' . $item['nama_depan'] . ' ' . ($item['nama_belakang'] ?? '') . ' ' . ($item['gelar_belakang'] ?? ''));
                
                // Mencari di semua kolom yang relevan (case-insensitive)
                return
                    stripos($namaLengkap, $q) !== false ||
                    stripos($item['jabatan'], $q) !== false ||
                    stripos((string) $item['id_anggota'], $q) !== false ||
                    stripos((string) $item['take_home_pay'], $q) !== false;
            });
        }

        // Kembalikan hasil dalam format JSON (array of objects)
        return response()->json($result->values());
    }

     public function show($id_anggota)
    {
        $anggota = Anggota::with('komponenGaji')->findOrFail($id_anggota);
        $komponen = $anggota->komponenGaji; // Ini adalah koleksi komponen milik anggota

        $take_home_pay = $komponen->sum('nominal');


        $tunjanganAnakKomponen = $komponen->firstWhere('nama_komponen', 'Tunjangan Anak');


        if ($tunjanganAnakKomponen && $anggota->jumlah_anak > 1) {
            $anakDihitung = min($anggota->jumlah_anak, 2);
            $tambahanTunjanganAnak = $tunjanganAnakKomponen->nominal * ($anakDihitung - 1);
            $take_home_pay += $tambahanTunjanganAnak;
            $tunjanganAnakKomponen->nominal *= $anakDihitung;
        }

        return response()->json([
            'anggota' => $anggota,
            'komponen' => $komponen, // Kirim koleksi komponen yang sudah dimodifikasi
            'take_home_pay' => $take_home_pay
        ]);
    }

    // Store komponen gaji baru
    public function store(Request $request)
    {
        $request->validate([
            'id_anggota' => 'required|exists:anggota,id_anggota',
            'id_komponen_gaji' => 'required|exists:komponen_gaji,id_komponen_gaji',
        ]);

        $anggota = Anggota::find($request->id_anggota);
        $komponen = KomponenGaji::find($request->id_komponen_gaji);

        // Validasi baru berdasarkan status anggota
        if ($komponen->nama_komponen === 'Tunjangan Istri/Suami' && $anggota->status_pernikahan !== 'Kawin') {
            return response()->json(['message' => 'Anggota belum menikah, tidak bisa menambahkan Tunjangan Istri/Suami.'], 422);
        }
        if ($komponen->nama_komponen === 'Tunjangan Anak' && $anggota->jumlah_anak < 1) {
            return response()->json(['message' => 'Anggota tidak memiliki anak, tidak bisa menambahkan Tunjangan Anak.'], 422);
        }
        
        // Validasi lama
        if ($komponen->jabatan !== 'Semua' && $komponen->jabatan !== $anggota->jabatan) {
            return response()->json(['message' => 'Komponen gaji tidak sesuai jabatan anggota!'], 422);
        }
        $exists = Penggajian::where('id_anggota', $anggota->id_anggota)
            ->where('id_komponen_gaji', $komponen->id_komponen_gaji)
            ->exists();
        if ($exists) {
            return response()->json(['message' => 'Komponen gaji sudah pernah ditambahkan untuk anggota ini!'], 422);
        }

        $penggajian = Penggajian::create($request->all());
        return response()->json($penggajian);
    }

    // Update komponen gaji
    public function update(Request $request, $id_anggota)
    {
        // Validasi input
        $request->validate([
            'id_komponen_gaji' => 'required|exists:komponen_gaji,id_komponen_gaji',
            'nominal' => 'required|numeric|min:0',
        ]);

        // Update nominal komponen gaji untuk anggota tertentu
        $penggajian = \App\Models\Penggajian::where('id_anggota', $id_anggota)
            ->where('id_komponen_gaji', $request->id_komponen_gaji)
            ->firstOrFail();

        $komponen = \App\Models\KomponenGaji::findOrFail($request->id_komponen_gaji);
        $komponen->nominal = $request->nominal;
        $komponen->save();

        return response()->json(['success' => true, 'komponen' => $komponen]);
    }

    // Hapus komponen gaji
    public function destroyKomponen($id_anggota, $id_komponen_gaji)
    {
        $deletedRows = Penggajian::where('id_anggota', $id_anggota)
                               ->where('id_komponen_gaji', $id_komponen_gaji)
                               ->delete();

        // Method delete() akan mengembalikan jumlah baris yang terhapus.
        // Jika lebih dari 0, berarti berhasil.
        if ($deletedRows > 0) {
            return response()->json(['success' => true]);
        }

        // Jika 0, berarti data tidak ditemukan untuk dihapus.
        return response()->json(['success' => false, 'message' => 'Data tidak ditemukan.'], 404);
    }

}