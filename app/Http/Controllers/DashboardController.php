<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class DashboardController extends Controller{
    public function dashboardAdmin(Request $request)
    {

        return view('dashboard-admin');
    }


    public function dashboardUser(Request $request)
    {
        return view('dashboard-user');
    }
}