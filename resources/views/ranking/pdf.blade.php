<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Ranking E-Wallet</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Times New Roman', 'Segoe UI', serif;
            padding: 35px 30px;
            background: #ffffff;
            color: #1e293b;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            padding-bottom: 16px;
            border-bottom: 2px solid #4F46E5;
            margin-bottom: 20px;
        }
        .header h1 {
            font-size: 22px;
            font-weight: 700;
            color: #1a1a2e;
            letter-spacing: 0.5px;
        }
        .header p {
            font-size: 12px;
            color: #555;
            margin-top: 4px;
        }
        .header .sub {
            font-size: 13px;
            color: #333;
            margin-top: 2px;
        }

        /* Paragraf Penjelasan */
        .description {
            background: #f9fafb;
            border-left: 3px solid #4F46E5;
            padding: 12px 16px;
            margin-bottom: 18px;
            font-size: 12.5px;
            color: #1e293b;
            text-align: justify;
            line-height: 1.6;
            border-radius: 0 4px 4px 0;
        }
        .description strong {
            color: #1a1a2e;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
            margin-top: 6px;
            border: 1px solid #ccc;
        }
        table thead {
            background: #e9ecef;
        }
        table thead th {
            padding: 8px 12px;
            text-align: left;
            font-weight: 700;
            color: #1a1a2e;
            font-size: 11.5px;
            border-bottom: 2px solid #999;
            border-right: 1px solid #ccc;
        }
        table thead th:last-child {
            border-right: none;
        }
        table thead th.center {
            text-align: center;
        }
        table tbody td {
            padding: 7px 12px;
            border-bottom: 1px solid #ddd;
            border-right: 1px solid #ddd;
            color: #1e293b;
            vertical-align: middle;
        }
        table tbody td:last-child {
            border-right: none;
        }
        table tbody td.center {
            text-align: center;
        }
        table tbody tr:last-child td {
            border-bottom: none;
        }
        table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }
        table tbody tr:nth-child(odd) {
            background: #ffffff;
        }
        /* Highlight untuk peringkat 1 */
        table tbody tr.rank-1 {
            background: #EEF2FF !important;
            border-left: 4px solid #4F46E5;
        }
        table tbody tr.rank-1 td {
            border-bottom-color: #4F46E5;
        }

        .rank-num {
            font-weight: 700;
            font-size: 13px;
            color: #1a1a2e;
        }
        .rank-num.gold {
            color: #4F46E5;
        }

        .status-text {
            font-weight: 600;
            font-size: 11px;
            color: #1a1a2e;
        }
        .status-text.best {
            color: #4F46E5;
        }

        .footer {
            margin-top: 22px;
            padding-top: 12px;
            border-top: 1px solid #ccc;
            text-align: center;
            font-size: 10px;
            color: #777;
        }

        .summary-box {
            margin-top: 16px;
            background: #f1f3f5;
            padding: 10px 16px;
            font-size: 12px;
            color: #1e293b;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .summary-box strong {
            color: #1a1a2e;
        }
        .summary-box .winner {
            color: #4F46E5;
            font-weight: 700;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Ranking E-Wallet Terbaik</h1>
        <p>Sistem Pendukung Keputusan — Metode SMART</p>
        <div class="sub">{{ count($hasil) }} alternatif E-Wallet dievaluasi berdasarkan {{ count($kriteria) }} kriteria</div>
    </div>

    @if(!empty($hasil) && count($hasil) > 0)
    <!-- Paragraf Penjelasan -->
    <div class="description">
        <strong>Berdasarkan hasil perhitungan metode SMART,</strong> 
        <strong>{{ $hasil[0]['alternatif']->nama_ewallet }}</strong> 
        memperoleh nilai akhir tertinggi sebesar <strong>{{ number_format($hasil[0]['nilai_akhir'], 4) }}</strong>, 
        sehingga ditetapkan sebagai <strong>E-Wallet terbaik</strong> di antara {{ count($hasil) }} alternatif yang dievaluasi. 
        Peringkat berikutnya ditempati oleh 
        @if(count($hasil) > 1) <strong>{{ $hasil[1]['alternatif']->nama_ewallet }}</strong> 
        @endif
        @if(count($hasil) > 2) dan <strong>{{ $hasil[2]['alternatif']->nama_ewallet }}</strong> 
        @endif
        sebagai alternatif kedua dan ketiga terbaik. 
        Seluruh peringkat disajikan dalam tabel di bawah ini.
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width: 60px; text-align: center;">Ranking</th>
                <th>Alternatif</th>
                <th style="width: 130px; text-align: center;">Nilai Akhir (V)</th>
                <th style="width: 110px; text-align: center;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($hasil as $item)
            <tr class="@if($item['ranking'] == 1) rank-1 @endif">
                <td class="center">
                    <span class="rank-num @if($item['ranking'] == 1) gold @endif">
                        {{ $item['ranking'] }}
                    </span>
                </td>
                <td>
                    <strong style="font-size: 13px;">{{ $item['alternatif']->nama_ewallet }}</strong>
                    <br>
                    <span style="font-size: 10px; color: #6c757d;">{{ $item['alternatif']->kode_alternatif }}</span>
                </td>
                <td class="center" style="font-weight: @if($item['ranking'] == 1) 700 @else 400 @endif; font-size: 13px; @if($item['ranking'] == 1) color: #4F46E5; @endif">
                    {{ number_format($item['nilai_akhir'], 4) }}
                </td>
                <td class="center">
                    @if($item['ranking'] == 1)
                    <span class="status-text best">Terbaik</span>
                    @else
                    <span style="color: #6c757d; font-size: 11px;">-</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if(!empty($hasil) && count($hasil) > 0)
    <div class="summary-box">
        <strong>Kesimpulan:</strong> 
        <span class="winner">{{ $hasil[0]['alternatif']->nama_ewallet }}</span> 
        adalah E-Wallet terbaik dengan nilai akhir <strong>{{ number_format($hasil[0]['nilai_akhir'], 4) }}</strong>.
        @if(count($hasil) > 1)
        Peringkat kedua: <strong>{{ $hasil[1]['alternatif']->nama_ewallet }}</strong> ({{ number_format($hasil[1]['nilai_akhir'], 4) }})
        @endif
        @if(count($hasil) > 2)
        , dan peringkat ketiga: <strong>{{ $hasil[2]['alternatif']->nama_ewallet }}</strong> ({{ number_format($hasil[2]['nilai_akhir'], 4) }})
        @endif
        .
    </div>
    @endif

    <div class="footer">
        &copy; {{ date('Y') }} SPK E-Wallet — Dicetak pada {{ date('d-m-Y H:i:s') }}
    </div>

</body>
</html>