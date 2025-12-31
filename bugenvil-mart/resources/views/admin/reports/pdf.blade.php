<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan - Ainin Ar Store</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #d946ef; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #d946ef; text-transform: uppercase; font-size: 24px; }
        .header p { margin: 5px 0; color: #666; }
        
        .meta { margin-bottom: 20px; }
        .meta table { width: 100%; }
        .meta td { padding: 5px; }
        .period-badge { background: #fdf4ff; padding: 5px 10px; border: 1px solid #d946ef; color: #d946ef; font-weight: bold; border-radius: 4px; display: inline-block; }

        .table-data { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table-data th, .table-data td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table-data th { background-color: #f3f4f6; color: #111; font-weight: bold; text-transform: uppercase; font-size: 10px; }
        .table-data tr:nth-child(even) { background-color: #f9fafb; }

        .total-section { text-align: right; margin-top: 20px; font-size: 14px; }
        .grand-total { font-size: 18px; font-weight: bold; color: #d946ef; margin-top: 5px; }
        
        .footer { position: fixed; bottom: 0; left: 0; right: 0; text-align: center; font-size: 10px; color: #999; border-top: 1px solid #eee; padding-top: 10px; }
    </style>
</head>
<body>

    {{-- KOP SURAT --}}
    <div class="header">
        <h1>Ainin Ar Store</h1>
        <p>Laporan Rekapitulasi Penjualan Resmi</p>
    </div>

    {{-- INFO PERIODE --}}
    <div class="meta">
        <table border="0">
            <tr>
                <td width="15%"><strong>Periode Laporan</strong></td>
                <td width="5%">:</td>
                <td><span class="period-badge">{{ $label }}</span></td>
            </tr>
            <tr>
                <td><strong>Dicetak Pada</strong></td>
                <td>:</td>
                <td>{{ now()->translatedFormat('d F Y, H:i') }} WIB</td>
            </tr>
            <tr>
                <td><strong>Oleh Admin</strong></td>
                <td>:</td>
                <td>{{ Auth::user()->name }}</td>
            </tr>
        </table>
    </div>

    {{-- TABEL DATA --}}
    <table class="table-data">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">ID Order</th>
                <th width="15%">Tanggal</th>
                <th width="20%">Pelanggan</th>
                <th width="15%">Status</th>
                <th width="10%">Resi</th>
                <th width="20%" style="text-align: right;">Total (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $index => $order)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ $order->user->name ?? 'Guest' }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>{{ $order->resi ?? '-' }}</td>
                <td style="text-align: right;">{{ number_format($order->total_price, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 20px;">Tidak ada data penjualan pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- TOTAL --}}
    <div class="total-section">
        <div>Total Pendapatan Periode Ini:</div>
        <div class="grand-total">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        Dokumen ini digenerate otomatis oleh sistem Ainin Ar Store pada {{ now()->format('Y-m-d H:i:s') }}.
    </div>

</body>
</html>