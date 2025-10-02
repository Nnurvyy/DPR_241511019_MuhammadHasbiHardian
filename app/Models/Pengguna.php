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
    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'email',
        'nama_depan',
        'nama_belakang',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    public function isAdmin(){
        return $this->role === 'Admin';
    }

    public function isPublic(){
        return $this->role === 'Public';
    }
    

    public function GetRememberTokenName(){
        return null;
    }

    // Role enum: Admin, Public
}
