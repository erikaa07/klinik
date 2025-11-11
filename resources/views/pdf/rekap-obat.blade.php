<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Rekap Obat PDF</title>
    <style>
        body { 
            font-family: 'DejaVu Sans', sans-serif; 
            font-size: 10px; 
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 20px; 
        }
        th, td { 
            border: 1px solid #888; 
            padding: 5px; 
            text-align: left; 
        }
        th { 
            background: #eee; 
            font-weight: bold;
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h2>Rekap Data Obat</h2>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>No Batch</th>
                <th>Exp Date</th>
                <th>Stok Awal</th>
                <th>Masuk</th>
                <th>Keluar</th>
                <th>Sisa</th>
                <th>Laba</th>
            </tr>
        </thead>
        <tbody>
            @foreach($obats as $obat)
            <tr>
                <td>{{ is_array($obat) ? ($obat['nama'] ?? '-') : ($obat->nama ?? '-') }}</td>
                <td>{{ number_format(is_array($obat) ? ($obat['harga_beli'] ?? 0) : ($obat->harga_beli ?? 0)) }}</td>
                <td>{{ number_format(is_array($obat) ? ($obat['harga_jual'] ?? 0) : ($obat->harga_jual ?? 0)) }}</td>
                <td>{{ is_array($obat) ? ($obat['no_batch'] ?? '-') : ($obat->no_batch ?? '-') }}</td>
                <td>{{ is_array($obat) ? ($obat['exp_date'] ?? '-') : ($obat->exp_date ?? '-') }}</td>
                <td>{{ is_array($obat) ? ($obat['stok_awal'] ?? 0) : ($obat->stok_awal ?? 0) }}</td>
                <td>{{ is_array($obat) ? ($obat['jumlah_masuk'] ?? 0) : ($obat->jumlah_masuk ?? 0) }}</td>
                <td>{{ is_array($obat) ? ($obat['jumlah_keluar'] ?? 0) : ($obat->jumlah_keluar ?? 0) }}</td>
                <td>{{ is_array($obat) ? ($obat['sisa_stok'] ?? 0) : ($obat->sisa_stok ?? 0) }}</td>
                <td>{{ is_array($obat) ? ($obat['laba'] ?? 0) : ($obat->laba ?? 0) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>