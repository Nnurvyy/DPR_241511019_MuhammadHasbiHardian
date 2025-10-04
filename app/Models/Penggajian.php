<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penggajian extends Model
{
    protected $table = 'penggajian';
    public $timestamps = false;

    public $incrementing = false; // karena PK composite

    // protected $primaryKey = ['id_komponen_gaji', 'id_anggota'];

    protected $fillable = [
        'id_komponen_gaji',
        'id_anggota',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota');
    }

    public function komponenGaji()
    {
        return $this->belongsTo(KomponenGaji::class, 'id_komponen_gaji');
    }
}
