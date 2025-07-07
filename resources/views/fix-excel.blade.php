<!DOCTYPE html>
<html>
<head>
    <title>Format Ulang File Excel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Format Ulang File Excel untuk Import Transaksi</h4>
                    </div>
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        <p class="mb-4">
                            Alat ini akan membantu Anda memastikan format tanggal dalam file Excel sudah benar untuk diimport.
                        </p>
                        
                        <form action="{{ route('fix.excel') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="file" class="form-label">Pilih File Excel</label>
                                <input type="file" class="form-control" id="file" name="file" required accept=".xlsx,.xls,.csv">
                                <div class="form-text">Format yang didukung: .xlsx, .xls</div>
                            </div>
                            
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Format Ulang File</button>
                            </div>
                        </form>
                        
                        <div class="mt-4">
                            <h5>Petunjuk</h5>
                            <ol>
                                <li>Upload file Excel Anda yang berisi data transaksi</li>
                                <li>Sistem akan memformat ulang kolom tanggal agar sesuai format Excel</li>
                                <li>File baru akan didownload otomatis</li>
                                <li>Gunakan file yang sudah diformat untuk import transaksi</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>