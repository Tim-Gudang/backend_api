<?php

namespace App\Http\Controllers;

use App\Http\Resources\BarangResource;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Services\BarangService;
use App\Services\TransactionService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    protected $transactionService;
    protected $barangService;


    public function __construct(TransactionService $transactionService, BarangService $barangService)
    {
        $this->transactionService = $transactionService;
        $this->barangService = $barangService;

    }


    public function laporantransaksi(Request $request)
    {
        $query = Transaction::with([
            'user',
            'transactionType',
            'transactionDetails.barang',
            'transactionDetails.gudang'
        ]);

        if (!$request->user()->hasRole('superadmin')) {
            $query->where('user_id', $request->user()->id);
        }

        if ($request->filled('transaction_type_id')) {
            $query->where('transaction_type_id', $request->transaction_type_id);
        }

        if ($request->filled('transaction_code')) {
            $query->where('transaction_code', 'LIKE', "%{$request->transaction_code}%");
        }

        if ($request->filled(['transaction_date_start', 'transaction_date_end'])) {
            $query->whereBetween('transaction_date', [$request->transaction_date_start, $request->transaction_date_end]);
        }

        return TransactionResource::collection($query->paginate(10));
    }

    public function laporanstok()
    {
        $user = Auth::user();


        $isSuperadmin = $user->hasRole('superadmin');
        $userId = $user->id;

        $barangs = $this->barangService->getAllBarang($userId, $isSuperadmin);

        return BarangResource::collection($barangs);
    }


    public function exportStokPdf(Request $request)
    {
        $user         = Auth::user();
    $isSuperadmin = $user->hasAnyRole(['superadmin','admin']);
    $barangs      = $this->barangService->getAllBarang($user->id, $isSuperadmin);

    Pdf::setOptions(['isRemoteEnabled' => true]);

    // === Embed Logo ===
    $logoPath = 'logo_icon.png'; // file di storage/app/public/logo_icon.png
    if (Storage::disk('public')->exists($logoPath)) {
        $logoBin    = Storage::disk('public')->get($logoPath);
        $logoBase64 = base64_encode($logoBin);
        $logoExt    = pathinfo($logoPath, PATHINFO_EXTENSION);
        $logoSrc    = "data:image/{$logoExt};base64,{$logoBase64}";
    } else {
        $logoSrc = '';
    }

    // === Bangun HTML ===
    $html = "
    <html>
    <head>
      <meta charset='utf-8'>
      <title>Laporan Stok Barang</title>
      <style>
        body { font-family: sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header img { max-height: 80px; margin-bottom: 10px; }
        .header h1 { font-size: 24px; margin: 0; }
        table { width:100%; border-collapse: collapse; margin-top:10px; }
        th, td { border:1px solid #ccc; padding:8px; font-size:12px; }
        th { background-color:#f4f4f4; }
        tr:nth-child(even) td { background-color: #fafafa; }
        img.item-img { max-width:60px; max-height:60px; }
      </style>
    </head>
    <body>
      <div class='header'>";

    if ($logoSrc) {
        $html .= "<img src='{$logoSrc}' alt='Logo' />";
    }

    $html .= "
        <h1>Laporan Stok Barang</h1>
      </div>

      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Barang</th>
            <th>Kode</th>
            <th>Gambar</th>
            <th>Gudang</th>
            <th>Stok Tersedia</th>
            <th>Stok Maintenance</th>
            <th>Stok Peminjaman</th>
          </tr>
        </thead>
        <tbody>";

    $no = 1;
    foreach ($barangs as $barang) {
        // embed gambar barang
        $relImg = $barang->barang_gambar;
        if (Storage::disk('public')->exists($relImg)) {
            $bin    = Storage::disk('public')->get($relImg);
            $ext    = pathinfo($relImg, PATHINFO_EXTENSION);
            $b64    = base64_encode($bin);
            $imgSrc = "data:image/{$ext};base64,{$b64}";
        } else {
            $imgSrc = '';
        }

        foreach ($barang->gudangs as $gudang) {
            $tersedia = $gudang->pivot->stok_tersedia   ?? 0;
            $maint    = $gudang->pivot->stok_maintenance ?? 0;
            $pinjam   = $gudang->pivot->stok_dipinjam    ?? 0;

            $html .= "
          <tr>
            <td>{$no}</td>
            <td>{$barang->barang_nama}</td>
            <td>{$barang->barang_kode}</td>
            <td><img class='item-img' src='{$imgSrc}' /></td>
            <td>{$gudang->name}</td>
            <td>{$tersedia}</td>
            <td>{$maint}</td>
            <td>{$pinjam}</td>
          </tr>";
            $no++;
        }
    }

    $html .= "
        </tbody>
      </table>
    </body>
    </html>";

    // Generate & simpan
    $pdf     = Pdf::loadHTML($html)->setPaper('a4','portrait');
    $pdfPath = 'laporan/laporan_stok.pdf';
    Storage::disk('public')->put($pdfPath, $pdf->output());

    return response()->json([
        'message' => 'Laporan stok PDF berhasil dibuat.',
        'pdf_url' => asset('storage/'.$pdfPath),
    ], 200);
}
}
