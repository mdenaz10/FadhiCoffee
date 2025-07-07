<?php

namespace App\Imports;

use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class TransaksiProdukImport implements ToCollection, WithHeadingRow
{
    // PENTING: Set index kolom disini (dari 0)!
    // Contoh: Jika kolom tanggal_transaksi di kolom C, set ke 2
    private $DATE_COLUMN_INDEX = 2; // 0=A, 1=B, 2=C, dst
    
    // PENTING: Set mode konversi (uncomment salah satu)
    private $DATE_MODE = 'excel';  // untuk format Excel numeric (44683 = 2025-05-01)
    // private $DATE_MODE = 'string'; // untuk format string biasa (2025-05-01)
    
    public function collection(Collection $rows)
    {
        \Log::info("====== MEMULAI IMPORT DENGAN FORCE DATE FIX ======");
        \Log::info("Date column index: " . $this->DATE_COLUMN_INDEX);
        \Log::info("Date mode: " . $this->DATE_MODE);
        
        // Ekstrak data mentah (termasuk tanggal yang masih belum dikonversi)
        $rawData = [];
        
        foreach ($rows as $rowIndex => $row) {
            // Konversi dari Collection ke array biasa untuk akses by index
            $dataArray = $row->toArray();
            
            // Ekstrak data produk
            $produkId = $row['produk_id'] ?? null;
            $jumlah = $row['jumlah'] ?? 0;
            
            if (empty($produkId)) {
                \Log::warning("Baris #$rowIndex - Produk ID kosong, dilewati");
                continue;
            }
            
            // Akses tanggal mentah berdasarkan index kolom, bukan key
            $keys = array_keys($dataArray);
            $dateKey = isset($keys[$this->DATE_COLUMN_INDEX]) ? $keys[$this->DATE_COLUMN_INDEX] : null;
            $rawDate = $dateKey ? $dataArray[$dateKey] : null;
            
            \Log::info("Baris #$rowIndex - Raw date: " . var_export($rawDate, true));
            
            // Parse tanggal berdasarkan mode
            $tanggal = null;
            try {
                if ($this->DATE_MODE === 'excel' && is_numeric($rawDate)) {
                    // Excel serial date (paling akurat untuk file Excel)
                    $baseDate = Carbon::create(1899, 12, 30);
                    $tanggal = $baseDate->copy()->addDays((int)$rawDate)->startOfDay();
                } elseif ($this->DATE_MODE === 'string' && is_string($rawDate)) {
                    // Format string (YYYY-MM-DD atau DD-MM-YYYY)
                    $tanggal = Carbon::parse($rawDate)->startOfDay();
                } else {
                    // Coba otomatis
                    if (is_numeric($rawDate)) {
                        $baseDate = Carbon::create(1899, 12, 30);
                        $tanggal = $baseDate->copy()->addDays((int)$rawDate)->startOfDay();
                    } elseif (is_string($rawDate)) {
                        $tanggal = Carbon::parse($rawDate)->startOfDay();
                    } else {
                        $tanggal = null;
                    }
                }
            } catch (\Exception $e) {
                $tanggal = null;
                \Log::error("Error parsing date: " . $e->getMessage());
            }
            
            // Gunakan tanggal default (current) jika parsing gagal
            if (!$tanggal) {
                // Untuk debugging, buatkan tanggal palsu berdasarkan row index
                // Ini membuat perbedaan tanggal di setiap baris agar terlihat jelas
                $tanggal = now()->subDays($rowIndex)->startOfDay();
                \Log::warning("Tanggal tidak valid, menggunakan " . $tanggal->format('Y-m-d'));
            }
            
            \Log::info("Baris #$rowIndex - Tanggal setelah konversi: " . $tanggal->format('Y-m-d'));
            
            // Simpan data untuk pemrosesan berikutnya
            $rawData[] = [
                'produk_id' => $produkId,
                'jumlah' => $jumlah,
                'tanggal' => $tanggal
            ];
        }
        
        // Group berdasarkan tanggal
        $grouped = collect($rawData)->groupBy(function ($item) {
            return $item['tanggal']->format('Y-m-d');
        });
        
        \Log::info("Jumlah grup tanggal: " . $grouped->count());
        
        // Buat transaksi untuk setiap grup tanggal
        foreach ($grouped as $date => $items) {
            // Ambil tanggal dari item pertama (sama untuk semua item dalam grup)
            $tanggal = $items[0]['tanggal'];
            
            \Log::info("Membuat transaksi untuk tanggal: $date dengan " . count($items) . " item");
            
            // Buat transaksi
            $transaksi = Transaksi::create([
                'tanggal_transaksi' => $tanggal,
                'created_at' => $tanggal,
                'updated_at' => $tanggal
            ]);
            
            \Log::info("Transaksi dibuat dengan ID: " . $transaksi->id . " dan tanggal: " . $transaksi->tanggal_transaksi);
            
            // Tambahkan produk ke transaksi
            foreach ($items as $item) {
                $produk = Produk::find($item['produk_id']);
                
                if ($produk) {
                    $subtotal = $produk->harga * $item['jumlah'];
                    
                    $transaksi->produk()->attach($produk->id, [
                        'jumlah' => $item['jumlah'],
                        'total_harga' => $subtotal,
                        'created_at' => $tanggal,
                        'updated_at' => $tanggal
                    ]);
                    
                    \Log::info("Produk ditambahkan: ProdukID: " . $item['produk_id'] . ", Jumlah: " . $item['jumlah']);
                } else {
                    \Log::warning("Produk ID " . $item['produk_id'] . " tidak ditemukan");
                }
            }
        }
        
        \Log::info("====== IMPORT SELESAI ======");
    }
}