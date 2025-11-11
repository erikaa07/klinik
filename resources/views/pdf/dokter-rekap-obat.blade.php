<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Rekap Obat PDF</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #888; padding: 5px; text-align: left; }
        th { background: #eee; font-weight: bold; }
        h2 { text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h2>Rekap Data Obat</h2>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>No Batch</th>
                <th>Exp Date</th>
                <th>Stok Awal</th>
                <th>Sisa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($obats as $obat)
            <tr>
                <td>{{ $obat['nama'] ?? '-' }}</td>
                <td>{{ $obat['no_batch'] ?? '-' }}</td>
                <td>{{ $obat['exp_date'] ?? '-' }}</td>
                <td>{{ $obat['stok_awal'] ?? 0 }}</td>
                <td>{{ $obat['sisa_stok'] ?? 0 }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>