<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Peminjaman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .header-info {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Laporan Peminjaman</h1>
    
    @if(isset($tanggal_mulai) && isset($tanggal_selesai))
    <div class="header-info">
        <p><strong>Periode:</strong> {{ date('d M Y', strtotime($tanggal_mulai)) }} - {{ date('d M Y', strtotime($tanggal_selesai)) }}</p>
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Peminjam</th>
                <th>Barang</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <th>Catatan</th>
                <th>Tanggal Pengembalian</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $item)
            <tr>
                <td>
                    @php
                        $roleLabel = $item->role ?? '';
                        if (str_contains($roleLabel, 'Student') || str_contains($roleLabel, 'student')) {
                            $roleLabel = 'Siswa';
                        } elseif (str_contains($roleLabel, 'Teacher') || str_contains($roleLabel, 'teacher')) {
                            $roleLabel = 'Guru';
                        } else {
                            $roleLabel = ucfirst($roleLabel);
                        }
                    @endphp
                    {{ $roleLabel }} - {{ $item->peminjam_nama ?? '-' }}
                </td>
                <td>{{ $item->barang ?? '-' }}</td>
                <td>{{ $item->tanggal_pinjam ? date('d M Y', strtotime($item->tanggal_pinjam)) : '-' }}</td>
                <td>{{ $item->tanggal_kembali ? date('d M Y', strtotime($item->tanggal_kembali)) : '-' }}</td>
                <td>{{ ucfirst($item->status ?? '-') }}</td>
                <td>{{ $item->catatan ?? '-' }}</td>
                <td>{{ $item->tanggal_dikembalikan ? date('d M Y H:i', strtotime($item->tanggal_dikembalikan)) : '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>

