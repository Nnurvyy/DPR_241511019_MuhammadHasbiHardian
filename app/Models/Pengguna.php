<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;
class Pengguna extends Authenticatable
{
    use Notifiable;
    protected $table = 'pengguna';
    protected $primaryKey = 'id_pengguna';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'email',
        'nama_depan',
        'nama_belakang',
        'role',
    ];

    // $hidden dipakai untuk menyembunyikan kolom tertentu saat model di-serialize (misalnya diubah jadi array atau JSON).
    protected $hidden = [
        'password',
    ];

    // otomatis hash password saat create pengguna
    protected $cast = [
        'password' => 'hashed',
    ];

    public function isAdmin(){
        return $this->role === 'Admin';
    }

    public function isPublic(){
        return $this->role === 'Public';
    }
    

    // mengabaikan remember token bawaan dari breeze
    public function GetRememberTokenName(){
        return null;
    }
}
