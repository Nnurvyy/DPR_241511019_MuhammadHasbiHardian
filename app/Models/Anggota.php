<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_anggota',
        'nama_depan',
        'nama_belakang',
        'gelar_depan',
        'gelar_belakang',
        'jabatan',
        'status_pernikahan',
    ];

    // Relasi ke penggajian
    public function komponenGaji()
    {
        return $this->belongsToMany(KomponenGaji::class, 'penggajian', 'id_anggota', 'id_komponen_gaji');
    }
}
