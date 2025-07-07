<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class FormatExcelController extends Controller
{
    public function fixExcelFormat(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        $file = $request->file('file');
        $inputPath = $file->getPathname();

        try {
            // Baca file Excel
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputPath);
            $worksheet = $spreadsheet->getActiveSheet();
            
            // Cari header kolom tanggal
            $highestColumn = $worksheet->getHighestColumn();
            $dateColumnIndex = null;
            $dateColumnLetter = null;
            
            for ($col = 'A'; $col <= $highestColumn; $col++) {
                $header = $worksheet->getCell($col . '1')->getValue();
                if (strtolower($header) == 'tanggal_transaksi' || 
                    strtolower($header) == 'tanggal transaksi' ||
                    strtolower($header) == 'tanggal') {
                    $dateColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($col);
                    $dateColumnLetter = $col;
                    break;
                }
            }
            
            if (!$dateColumnIndex) {
                return back()->with('error', 'Kolom tanggal tidak ditemukan');
            }
            
            // Format data tanggal di semua baris
            $highestRow = $worksheet->getHighestRow();
            for ($row = 2; $row <= $highestRow; $row++) {
                $cellCoordinate = $dateColumnLetter . $row;
                $cellValue = $worksheet->getCell($cellCoordinate)->getValue();
                
                // Jika sudah berformat tanggal, skip
                if ($worksheet->getCell($cellCoordinate)->getDataType() == \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC && 
                    \PhpOffice\PhpSpreadsheet\Shared\Date::isDateTime($worksheet->getCell($cellCoordinate))) {
                    continue;
                }
                
                // Konversi string tanggal ke format Excel date
                try {
                    if (!empty($cellValue)) {
                        $dateValue = \Carbon\Carbon::parse($cellValue);
                        $excelDateValue = \PhpOffice\PhpSpreadsheet\Shared\Date::dateTimeToExcel($dateValue);
                        $worksheet->setCellValue($cellCoordinate, $excelDateValue);
                        $worksheet->getStyle($cellCoordinate)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD);
                    }
                } catch (\Exception $e) {
                    // Gagal parsing, biarkan nilai asli
                }
            }
            
            // Tulis kembali ke file baru
            $writer = new Xlsx($spreadsheet);
            $outputPath = storage_path('app/fixed-excel-' . time() . '.xlsx');
            $writer->save($outputPath);
            
            return response()->download($outputPath, 'fixed-format-' . $file->getClientOriginalName())->deleteFileAfterSend(true);
            
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
    
    public function showFixForm()
    {
        return view('fix-excel');
    }
}