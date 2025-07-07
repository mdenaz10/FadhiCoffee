<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;

class DiagnosticImportCommand extends Command
{
    protected $signature = 'import:diagnose {file}';
    protected $description = 'Diagnosa format file Excel dan isi data';

    public function handle()
    {
        $this->info('Memulai diagnosa file Excel...');
        
        $filePath = $this->argument('file');
        
        if (!file_exists($filePath)) {
            $this->error("File tidak ditemukan: $filePath");
            return 1;
        }
        
        try {
            // Baca file Excel
            $this->info("Membaca file: $filePath");
            $spreadsheet = IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            
            // Informasi umum file
            $this->info("\n=== INFORMASI FILE ===");
            $this->info("Judul Worksheet: " . $worksheet->getTitle());
            $this->info("Jumlah Baris: " . $worksheet->getHighestRow());
            $this->info("Jumlah Kolom: " . $worksheet->getHighestColumn());
            
            // Baca header dan tentukan kolom
            $this->info("\n=== HEADER FILE ===");
            $headers = [];
            $dateColumnIndex = null;
            $dateColumnLetter = null;
            $produkIdColumnIndex = null;
            $jumlahColumnIndex = null;
            
            for ($col = 'A'; $col <= $worksheet->getHighestColumn(); $col++) {
                $cellValue = $worksheet->getCell($col . '1')->getValue();
                $headers[$col] = $cellValue;
                
                $this->info("Kolom $col: $cellValue");
                
                if (strtolower($cellValue) == 'tanggal_transaksi' || 
                    strtolower($cellValue) == 'tanggal transaksi' || 
                    strtolower($cellValue) == 'tanggal') {
                    $dateColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($col);
                    $dateColumnLetter = $col;
                }
                
                if (strtolower($cellValue) == 'produk_id' || strtolower($cellValue) == 'produk id') {
                    $produkIdColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($col);
                }
                
                if (strtolower($cellValue) == 'jumlah') {
                    $jumlahColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($col);
                }
            }
            
            if (!$dateColumnLetter) {
                $this->error("KOLOM TANGGAL TIDAK DITEMUKAN!");
                return 1;
            }
            
            // Analisis data baris per baris
            $this->info("\n=== ANALISIS DATA ===");
            $this->info("Menganalisis kolom tanggal ($dateColumnLetter)...");
            
            $this->table(
                ['Baris', 'Nilai Asli', 'Tipe Data', 'Format Sel', 'Hasil Konversi', 'Excel Serial'],
                $this->analyzeData($worksheet, $dateColumnLetter)
            );
            
            // Saran koreksi
            $this->info("\n=== SARAN PERBAIKAN ===");
            $this->info("1. Buat file Excel baru dengan format yang benar");
            $this->info("2. Gunakan kode import fix berikut:");
            
            $this->generateFixedImportCode($dateColumnLetter);
            
            return 0;
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            $this->error($e->getTraceAsString());
            return 1;
        }
    }
    
    private function analyzeData($worksheet, $dateColumnLetter)
    {
        $data = [];
        $highestRow = $worksheet->getHighestRow();
        
        for ($row = 2; $row <= min($highestRow, 10); $row++) {
            $cell = $worksheet->getCell($dateColumnLetter . $row);
            $cellValue = $cell->getValue();
            $dataType = $cell->getDataType();
            
            $formatCode = $cell->getStyle()->getNumberFormat()->getFormatCode();
            
            // Coba konversi nilai
            $convertedDate = null;
            $excelSerial = null;
            
            try {
                if (is_numeric($cellValue)) {
                    // Coba konversi sebagai Excel date
                    $dateObj = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($cellValue);
                    $convertedDate = $dateObj->format('Y-m-d');
                    $excelSerial = "Ya (nilai: $cellValue)";
                } elseif (is_string($cellValue)) {
                    // Coba parse sebagai string tanggal
                    $dateObj = Carbon::parse($cellValue);
                    $convertedDate = $dateObj->format('Y-m-d');
                    $excelSerial = "Tidak (string)";
                } else {
                    $convertedDate = "Tidak dapat dikonversi";
                    $excelSerial = "Tidak";
                }
            } catch (\Exception $e) {
                $convertedDate = "Error: " . $e->getMessage();
                $excelSerial = "Error";
            }
            
            $data[] = [
                $row,
                is_scalar($cellValue) ? $cellValue : gettype($cellValue),
                $dataType,
                $formatCode,
                $convertedDate,
                $excelSerial
            ];
        }
        
        return $data;
    }
    
    private function generateFixedImportCode($dateColumnLetter)
    {
        $code = <<<EOT
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
    public function collection(Collection \$rows)
    {
        // Kelompokkan transaksi berdasarkan tanggal
        \$grouped = collect();
        
        foreach (\$rows as \$row) {
            \$produkId = \$row['produk_id'] ?? null;
            \$jumlah = \$row['jumlah'] ?? 0;
            
            // KHUSUS FIX UNTUK KOLOM {$dateColumnLetter} (TANGGAL) 
            \$rawDate = \$row['tanggal_transaksi'] ?? null;
            \$tanggal = null;
            
            // Penanganan spesifik untuk format Excel Anda
            if (!empty(\$rawDate)) {
                if (is_numeric(\$rawDate)) {
                    // Convert Excel serial date (paling akurat)
                    \$baseDate = Carbon::create(1899, 12, 30);
                    \$tanggal = \$baseDate->copy()->addDays((int)\$rawDate)->startOfDay();
                } elseif (is_string(\$rawDate)) {
                    // Coba parse tanggal string
                    \$tanggal = Carbon::parse(\$rawDate)->startOfDay();
                } else {
                    \$tanggal = now()->startOfDay();
                }
            } else {
                \$tanggal = now()->startOfDay();
            }
            
            // Group berdasarkan tanggal
            \$dateKey = \$tanggal->format('Y-m-d');
            
            if (!\$grouped->has(\$dateKey)) {
                \$grouped->put(\$dateKey, collect([
                    'tanggal' => \$tanggal,
                    'items' => collect()
                ]));
            }
            
            \$grouped->get(\$dateKey)['items']->push([
                'produk_id' => \$produkId,
                'jumlah' => \$jumlah
            ]);
        }
        
        // Buat transaksi dari grup
        foreach (\$grouped as \$dateGroup) {
            \$tanggal = \$dateGroup['tanggal'];
            \$items = \$dateGroup['items'];
            
            \$transaksi = Transaksi::create([
                'tanggal_transaksi' => \$tanggal,
                'created_at' => \$tanggal,
                'updated_at' => \$tanggal
            ]);
            
            foreach (\$items as \$item) {
                \$produk = Produk::find(\$item['produk_id']);
                
                if (\$produk) {
                    \$subtotal = \$produk->harga * \$item['jumlah'];
                    
                    \$transaksi->produk()->attach(\$produk->id, [
                        'jumlah' => \$item['jumlah'],
                        'total_harga' => \$subtotal,
                        'created_at' => \$tanggal,
                        'updated_at' => \$tanggal
                    ]);
                }
            }
        }
    }
}
EOT;
        
        $this->line($code);
    }
}