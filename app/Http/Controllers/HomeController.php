<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function welcome()
    {
        if (Auth::check()){
            return redirect()->route('dashboard');
        }
        return redirect()->route('login');
    }

    public function dashboard()
    {
        $user = Auth::user();
        if ($user && $user->isAdmin()) {
            return redirect()->route('dashboard.admin');
        } elseif ($user && $user->isPublic()) {
            return redirect()->route('dashboard.user');
        }
        return redirect('/');
    }
}