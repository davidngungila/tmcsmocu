<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contributions Report - {{ config('app.name', 'TmcsSmart') }}</title>
    <style>
        @page {
            margin: 10mm 12mm;
            size: A4;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 9pt;
            line-height: 1.4;
            color: #333;
        }
        .header {
            border-bottom: 3px solid #7c3aed;
            padding-bottom: 15px;
            margin-bottom: 15px;
            text-align: center;
            width: 100%;
        }
        .header-image {
            width: 100%;
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto 15px auto;
        }
        .title {
            font-size: 18pt;
            font-weight: bold;
            color: #7c3aed;
            margin: 15px 0 10px 0;
        }
        .header-info {
            font-size: 10pt;
            color: #666;
            margin-top: 8px;
        }
        .section {
            margin: 15px 0;
            page-break-inside: avoid;
        }
        .section-header {
            background: #7c3aed;
            color: white;
            padding: 8px 12px;
            font-weight: bold;
            font-size: 10pt;
            margin-bottom: 8px;
        }
        .section-content {
            padding: 8px 0;
            font-size: 8.5pt;
            line-height: 1.6;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 8pt;
        }
        th {
            background: #7c3aed;
            color: white;
            padding: 8px 6px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #7c3aed;
        }
        th.text-right {
            text-align: right;
        }
        th.text-center {
            text-align: center;
        }
        td {
            padding: 6px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 9pt;
        }
        .summary-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .summary-table td:first-child {
            font-weight: 600;
            background: #f9fafb;
            width: 60%;
        }
        .summary-table td:last-child {
            text-align: right;
            font-weight: 600;
        }
        .summary-table tr.total td {
            background: #10b981;
            color: white;
            font-size: 11pt;
            font-weight: bold;
            border: 1px solid #10b981;
        }
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 7pt;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <div style="text-align: center; margin-bottom: 15px;">
            @php
                $headerImagePath = public_path('header-mfumo.png');
                $headerBase64 = '';
                if (file_exists($headerImagePath)) {
                    $headerImageData = file_get_contents($headerImagePath);
                    $headerBase64 = 'data:image/png;base64,' . base64_encode($headerImageData);
                }
            @endphp
            @if($headerBase64)
            <img src="{{ $headerBase64 }}" alt="Church Header" class="header-image">
            @endif
        </div>
        <div class="title">{{ strtoupper($category ?? 'CONTRIBUTIONS') }} REPORT</div>
        <div class="header-info">
            @if(isset($dateFrom) && isset($dateTo))
            Period: <strong>{{ \Carbon\Carbon::parse($dateFrom)->format('F d, Y') }} to {{ \Carbon\Carbon::parse($dateTo)->format('F d, Y') }}</strong><br>
            @elseif(isset($month))
            Month: <strong>{{ \Carbon\Carbon::parse($month)->format('F Y') }}</strong><br>
            @elseif(isset($date))
            Date: <strong>{{ \Carbon\Carbon::parse($date)->format('F d, Y') }}</strong><br>
            @endif
            @if(isset($activeYear))
            Financial Year: <strong>{{ $activeYear->name }}</strong><br>
            @endif
            Generated: {{ now()->format('Y-m-d H:i:s') }}
        </div>
    </div>

    <!-- Summary Statistics -->
    <div class="section">
        <div class="section-header">Summary Statistics</div>
        <div class="section-content">
            <table class="summary-table">
                <tr>
                    <td>Total {{ ucfirst($category ?? 'Contributions') }}</td>
                    <td>TSh {{ number_format($totalAmount ?? 0, 0) }}</td>
                </tr>
                <tr>
                    <td>Total Transactions</td>
                    <td>{{ number_format($totalTransactions ?? 0, 0) }}</td>
                </tr>
                <tr>
                    <td>Average Contribution</td>
                    <td>TSh {{ number_format(($totalAmount ?? 0) / max($totalTransactions ?? 1, 1), 0) }}</td>
                </tr>
                <tr class="total">
                    <td>Total Amount</td>
                    <td>TSh {{ number_format($totalAmount ?? 0, 0) }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Top Contributors -->
    @if(isset($topContributors) && $topContributors->count() > 0)
    <div class="section">
        <div class="section-header">Top 10 Contributors</div>
        <div class="section-content">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th>Parishioner Name</th>
                        <th class="text-right">Total Amount</th>
                        <th class="text-center">Transactions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topContributors as $index => $data)
                    <tr>
                        <td style="text-align: center; color: #9ca3af;">{{ $index + 1 }}</td>
                        <td>{{ $data['parishioner']->full_name ?? 'N/A' }}</td>
                        <td class="text-right"><strong style="color: #10b981;">TSh {{ number_format($data['total'], 0) }}</strong></td>
                        <td class="text-center">{{ $data['count'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Contribution Details -->
    @if(isset($contributions) && $contributions->count() > 0)
    <div class="section">
        <div class="section-header">Contribution Details</div>
        <div class="section-content">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 12%;">Date</th>
                        <th style="width: 25%;">Parishioner</th>
                        <th style="width: 20%;">Description</th>
                        <th style="width: 15%;">Reference</th>
                        <th style="width: 13%;" class="text-right">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contributions as $index => $contribution)
                    <tr>
                        <td style="text-align: center; color: #9ca3af;">{{ $index + 1 }}</td>
                        <td>{{ $contribution->transaction_date->format('M d, Y') }}</td>
                        <td><strong>{{ $contribution->parishioner->full_name ?? 'N/A' }}</strong></td>
                        <td>{{ $contribution->title }}</td>
                        <td>{{ $contribution->reference_number ?? 'N/A' }}</td>
                        <td class="text-right"><strong style="color: #10b981;">TSh {{ number_format($contribution->amount, 0) }}</strong></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="background: #10b981; color: white; font-weight: bold;">
                        <td colspan="5" class="text-right">TOTAL:</td>
                        <td class="text-right">TSh {{ number_format($contributions->sum('amount'), 0) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @endif

    <div class="footer">
        <p><strong>Thank you for using TmcsSmart!</strong></p>
        <p>This is a computer-generated report. No signature required.</p>
        <p style="margin-top: 8px;">
            Generated on {{ now()->format('F d, Y \a\t H:i:s') }} | 
            {{ ucfirst($category ?? 'Contributions') }} Report
            @if(isset($dateFrom) && isset($dateTo))
            ({{ \Carbon\Carbon::parse($dateFrom)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($dateTo)->format('M d, Y') }})
            @elseif(isset($month))
            ({{ \Carbon\Carbon::parse($month)->format('F Y') }})
            @elseif(isset($date))
            ({{ \Carbon\Carbon::parse($date)->format('M d, Y') }})
            @endif
        </p>
    </div>
</body>
</html>


