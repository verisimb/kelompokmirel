<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ranking E-Wallet</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            padding: 30px;
            background: white;
        }
        h1 {
            text-align: center;
            color: #4F46E5;
            margin-bottom: 5px;
        }
        .subtitle {
            text-align: center;
            color: #94a3b8;
            font-size: 14px;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            background: #4F46E5;
            color: white;
            padding: 12px;
            text-align: left;
        }
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #e2e8f0;
        }
        .ranking-1 {
            background: #FEF3C7;
        }
        .ranking-2 {
            background: #F1F5F9;
        }
        .ranking-3 {
            background: #FEF3C7;
        }
        .text-center {
            text-align: center;
        }
        .fw-bold {
            font-weight: 700;
        }
        .badge {
            background: #4F46E5;
            color: white;
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 12px;
        }
        .badge-warning {
            background: #F59E0B;
            color: white;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #94a3b8;
            font-size: 12px;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <h1>📊 Ranking E-Wallet Terbaik</h1>
    <p class="subtitle">Sistem Pendukung Keputusan - Metode SMART</p>

    <table>
        <thead>
            <tr>
                <th>Ranking</th>
                <th>E-Wallet</th>
                <th>Nilai Akhir</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hasil as $item)
            <tr class="{{ $item['ranking'] == 1 ? 'ranking-1' : ($item['ranking'] == 2 ? 'ranking-2' : ($item['ranking'] == 3 ? 'ranking-3' : '')) }}">
                <td class="text-center fw-bold">
                    #{{ $item['ranking'] }}
                </td>
                <td>
                    {{ $item['alternatif']->nama_ewallet }}
                    <br>
                    <small style="color: #94a3b8;">{{ $item['alternatif']->kode_alternatif }}</small>
                </td>
                <td class="text-center fw-bold" style="color: #4F46E5;">
                    {{ number_format($item['nilai_akhir'] * 100, 2) }}%
                </td>
                <td class="text-center">
                    @if($item['ranking'] == 1)
                    <span class="badge badge-warning">🏆 Terbaik</span>
                    @elseif($item['ranking'] == 2)
                    <span class="badge">🥈 Runner Up 1</span>
                    @elseif($item['ranking'] == 3)
                    <span class="badge">🥉 Runner Up 2</span>
                    @else
                    <span class="badge" style="background: #94a3b8;">Alternatif</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        &copy; {{ date('Y') }} SPK E-Wallet - Dicetak pada {{ date('d-m-Y H:i:s') }}
    </div>
</body>
</html>