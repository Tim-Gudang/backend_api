<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(){
        $barangs = Barang::with(['jenisBarang', 'satuan'])->get();
        return view('MasterData.Barang.index',compact('barangs'));
    }
}
