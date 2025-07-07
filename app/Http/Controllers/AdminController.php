<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Transaksi;
use App\Models\User;
use App\Models\Produk;
use App\Models\BahanBaku;
use Illuminate\Http\Request;
use App\Models\MovingAverage;
use App\Models\TransaksiProduk;
use Illuminate\Support\Facades\Hash;
use App\Models\ProdukBahanBaku;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{
  public function dashboard()
  {
    $totalTransaksi = Transaksi::count(); // Total transaksi
    $totalBahanBaku = BahanBaku::count(); // Total bahan baku
    $totalProduk = Produk::count(); // Total produk
    $totalPeramalan = MovingAverage::count(); // Total data peramalan (jika ada)
    $bahanBakuHampirHabis = BahanBaku::where('stok', '<=', 10)->count(); // Misalnya, jika stok <= 10 dianggap hampir habis
    $totalTransaksi2 = Transaksi::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
      ->count();

    $penjualanPerBulan = DB::table('transaksi_produk')
      ->join('transaksi', 'transaksi_produk.transaksi_id', '=', 'transaksi.id')
      ->selectRaw('MONTH(tanggal_transaksi) as bulan, SUM(transaksi_produk.total_harga) as total')
      ->groupByRaw('MONTH(tanggal_transaksi)')
      ->orderByRaw('MONTH(tanggal_transaksi)')
      ->get();

    $bulanNama = [
      1 => 'Januari',
      2 => 'Februari',
      3 => 'Maret',
      4 => 'April',
      5 => 'Mei',
      6 => 'Juni',
      7 => 'Juli',
      8 => 'Agustus',
      9 => 'September',
      10 => 'Oktober',
      11 => 'November',
      12 => 'Desember'
    ];

    $dataBulan = [];
    foreach ($penjualanPerBulan as $item) {
        $dataBulan[$bulanNama[$item->bulan]] = (int) $item->total;
    }

    return view('dashboard', [
      'totalTransaksi' => $totalTransaksi,
      'totalBahanBaku' => $totalBahanBaku,
      'totalProduk' => $totalProduk,
      'bahanBakuHampirHabis' => $bahanBakuHampirHabis,
      'transaksimingguan' => $totalTransaksi2,
      'peramalan' => $totalPeramalan,
      'dataBulan' => $dataBulan // ini buat chart
    ]);
  }

  public function bbindex()
  {
    $bahanBakus = BahanBaku::all();
    return view('admin.bbindex', compact('bahanBakus'));
  }

  public function bbcreate()
  {
    return view('admin.bbcreate');
  }

  public function bbstore(Request $request)
  {
    $request->validate([
      'nama' => 'required|string|max:255',
      'stok' => 'required|numeric|min:0',
      'satuan' => 'required|string|max:50',
    ]);

    BahanBaku::updateOrCreate(
      ['nama' => $request->nama],
      [
        'stok' => \DB::raw("stok + " . $request->stok),
        'satuan' => $request->satuan
      ]
    );

    return redirect()->route('admin.bbindex')->with('success', 'Bahan baku berhasil ditambahkan.');
  }
  public function bbedit($id)
  {
    $bahanBaku = BahanBaku::findOrFail($id);
    return view('admin.bbedit', compact('bahanBaku'));
  }

  public function bbupdate(Request $request, $id)
  {
    $request->validate([
      'nama' => 'required|string|max:255',
      'stok' => 'required|numeric|min:0',
      'satuan' => 'required|string|max:50',
    ]);

    $bahanBaku = BahanBaku::findOrFail($id);
    $bahanBaku->update([
      'nama' => $request->nama,
      'stok' => $request->stok,
      'satuan' => $request->satuan,
    ]);

    return redirect()->route('admin.bbindex')->with('success', 'Bahan baku berhasil diperbarui.');
  }

  public function bbdestroy($id)
  {
    BahanBaku::findOrFail($id)->delete();
    return redirect()->route('admin.bbindex')->with('success', 'Bahan baku berhasil dihapus.');
  }

  public function pdindex()
  {
    $produks = Produk::with('komposisi')->get();
    return view('admin.pdindex', compact('produks'));
  }

  public function pdcreate()
  {
    $produks = BahanBaku::all(); // Ambil semua bahan baku untuk dropdown
    return view('admin.pdcreate', compact('produks'));
  }

  public function pdstore(Request $request)
  {
    $request->validate([
      'nama'                      => 'required|string|max:255',
      'harga'                     => 'required|integer|min:0',
      'komposisi'                 => 'required|array',
      'komposisi.*.bahan_baku_id' => 'required|exists:bahan_baku,id', // ID bahan baku harus ada
      'komposisi.*.jumlah'        => 'required|numeric|min:0.01', // Jumlah harus ada dan lebih dari 0
    ]);

    // Simpan produk
    $produk = Produk::create([
      'nama' => $request->nama,
      'harga' => $request->harga,
    ]);

    // Simpan Komposisi di Pivot
    foreach ($request->komposisi as $komposisi) {
      $produk->komposisi()->attach($komposisi['bahan_baku_id'], ['jumlah' => $komposisi['jumlah']]);
    }

    $bahanBaku = BahanBaku::find($komposisi['bahan_baku_id']);
    if ($bahanBaku) {
      $bahanBaku->kurangiStok($komposisi['jumlah']);
    }

    return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');

    // return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan.');
  }
  public function pdedit($id)
  {
    $produk = Produk::with('komposisi')->findOrFail($id);
    $bahanBakus = BahanBaku::all(); // Mengambil semua bahan baku untuk dropdown
    return view('admin.pdedit', compact('produk', 'bahanBakus'));
  }

  public function pdupdate(Request $request, $id)
  {

    $validated = $request->validate([
      'nama' => 'required|string|max:255',
      'harga' => 'required|numeric|min:0', // Ubah dari integer ke numeric
      'komposisi' => 'required|array',
      'komposisi.*.bahan_baku_id' => 'required|exists:bahan_baku,id',
      'komposisi.*.jumlah' => 'required|numeric|min:0.01',
    ]);

    \Log::info('Validated data:', $validated);

    $produk = Produk::findOrFail($id);

    // Update produk
    $produk->update([
      'nama' => $validated['nama'],
      'harga' => $validated['harga'], // Akan menerima nilai desimal
    ]);

    // Hapus komposisi lama
    ProdukBahanBaku::where('produk_id', $produk->id)->delete();

    // Tambah komposisi baru
    foreach ($validated['komposisi'] as $item) {
      ProdukBahanBaku::create([
        'produk_id' => $produk->id,
        'bahan_baku_id' => $item['bahan_baku_id'],
        'jumlah' => $item['jumlah'],
      ]);
    }

    return redirect()->route('admin.pdindex')->with('success', 'Produk berhasil diperbarui.');
  }
  public function pddestroy($id)
  {
    Produk::findOrFail($id)->delete();
    return redirect()->route('admin.pdindex')->with('success', 'Produk berhasil dihapus.');
  }

  public function usindex()
  {
    $users = User::all();
    return view('admin.usindex', compact('users'));
  }

  public function updatePassword(Request $request, $id)
  {
    $request->validate([
      'password' => 'required|min:6|confirmed',
    ]);

    $user = User::findOrFail($id);
    $user->password = Hash::make($request->password);
    $user->save();

    return redirect()->route('admin.usindex')->with('success', 'Password berhasil diperbarui.');
  }

  public function usdestroy($id)
  {
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('admin.usindex')->with('success', 'User berhasil dihapus.');
  }

  public function usstore(Request $request)
  {
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|min:6|confirmed',
      'role' => 'required|in:admin,owner',
    ]);

    User::create([
      'name' => $request->name,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'role' => $request->role,
    ]);

    return redirect()->route('admin.usindex')->with('success', 'User berhasil ditambahkan.');
  }
  public function uscreate()
  {
    return view('admin.uscreate');
  }
}
