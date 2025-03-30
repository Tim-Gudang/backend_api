<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Gudang;
use App\Models\JenisBarang;
use App\Models\Satuan;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $barangs = Barang::count();
        $jenisbarangs = JenisBarang::count();
        $satuans = Satuan::count();
        $users = User::count();
        $gudangs = Gudang::count();

        return view('layouts.main', compact('barangs', 'jenisbarangs', 'satuans', 'users', 'gudangs'));
    }
}
