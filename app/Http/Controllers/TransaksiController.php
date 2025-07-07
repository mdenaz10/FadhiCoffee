<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Produk;
use App\Models\BahanBaku;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiController extends Controller
{
  public function kasirDashboard()
  {
    $totalTransaksi = Transaksi::count(); // Total transaksi
    $transaksiHariIni = Transaksi::whereDate('created_at', Carbon::today())->count(); // Transaksi hari ini
    $produkTerjual = DB::table('transaksi_produk')->sum('jumlah');

    return view('kasir.dashboard', [
      'totalTransaksi' => $totalTransaksi,
      'transaksiHariIni' => $transaksiHariIni,
      'produkTerjual' => $produkTerjual,
    ]);
  }

  public function index(Request $request)
  {
    $order = $request->get('order', 'desc'); // Default descending (terbaru ke terlama)
    $order = $order === 'desc' ? 'asc' : 'desc'; // Toggle urutan jika diklik

    $transaksi = Transaksi::with('produk')->orderBy('created_at', $order)->get();
    return view('admin.tsindex', compact('transaksi', 'order'));
  }

  public function create()
  {
    $produks = Produk::all();
    return view('admin.tscreate', compact('produks'));
  }

  public function store(Request $request)
  {
    $request->validate([
      'produk_id'   => 'required|array',
      'produk_id.*' => 'exists:produk,id',
      'jumlah'      => 'required|array',
      'jumlah.*'    => 'integer|min:1',
    ]);

    $totalHarga = 0;

    // Buat transaksi baru
    $transaksi = Transaksi::create();

    foreach ($request->produk_id as $index => $produkId) {
      $produk = Produk::with('bahanBaku')->findOrFail($produkId);
      $jumlah = $request->jumlah[$index];
      $subtotal = $produk->harga * $jumlah;


      // Masukkan data ke tabel pivot transaksi_produk
      $transaksi->produk()->attach($produkId, [
        'jumlah' => $jumlah,
        'total_harga' => $subtotal,
      ]);

      // Kurangi stok bahan baku berdasarkan komposisi produk
      foreach ($produk->bahanBaku as $komposisi) {
        $bahanBaku = BahanBaku::find($komposisi->id);
        if ($bahanBaku) {
          $bahanBaku->stok -= ($komposisi->pivot->jumlah * $jumlah);
          $bahanBaku->save();
        }
      }
    }

    return redirect()->route('admin.tsindex')->with('success', 'Transaksi berhasil dan stok bahan baku diperbarui!');
  }

  public function destroy($id)
  {
    Transaksi::findOrFail($id)->delete();
    return redirect()->route('admin.tsindex')->with('success', 'Transaksi berhasil dihapus.');
  }
}
