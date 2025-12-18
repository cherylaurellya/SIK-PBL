<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Dokter;
use App\Models\Perawat;
use App\Models\Pasien;

class AdminController extends Controller
{
    public function index()
    {
        
        $totalDokter = Dokter::count();
        $totalPerawat = Perawat::count();
        $totalPasien = Pasien::count();
        $totalUser = User::count();

        
        return view('admin.dashboard', compact('totalDokter', 'totalPerawat', 'totalPasien', 'totalUser'));
    }
}