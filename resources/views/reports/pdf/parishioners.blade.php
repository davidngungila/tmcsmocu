<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Parishioners Report - {{ config('app.name', 'TmcsSmart') }}</title>
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
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            background: white;
        }
        .info-table tr {
            border-bottom: 1px solid #e5e7eb;
        }
        .info-table tr:last-child {
            border-bottom: none;
        }
        .info-table td {
            padding: 5px 8px;
            vertical-align: top;
            font-size: 8.5pt;
        }
        .info-table td:first-child {
            font-weight: 600;
            width: 35%;
            color: #374151;
            background: #f9fafb;
            border-right: 1px solid #e5e7eb;
        }
        .info-table td:last-child {
            color: #1a1a1a;
        }
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #ddd;
            font-size: 7pt;
            color: #666;
            text-align: center;
        }
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 7.5pt;
            font-weight: 600;
        }
        .badge-active {
            background: #d1fae5;
            color: #065f46;
        }
        .badge-inactive {
            background: #fee2e2;
            color: #991b1b;
        }
        .badge-student {
            background: #dbeafe;
            color: #1e40af;
        }
        .badge-worker {
            background: #f3e8ff;
            color: #6b21a8;
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
        <div class="title">PARISHIONERS REPORT</div>
        <div class="header-info">
            @if(isset($type))
            Type: <strong>{{ ucfirst($type === 'wanafunzi' ? 'Students' : 'Workers') }}</strong><br>
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
                    <td>Total Parishioners</td>
                    <td>{{ number_format($totalParishioners ?? 0, 0) }}</td>
                </tr>
                <tr>
                    <td>Active Parishioners</td>
                    <td>{{ number_format($activeParishioners ?? 0, 0) }}</td>
                </tr>
                <tr>
                    <td>Male Parishioners</td>
                    <td>{{ number_format($maleParishioners ?? 0, 0) }}</td>
                </tr>
                <tr>
                    <td>Female Parishioners</td>
                    <td>{{ number_format($femaleParishioners ?? 0, 0) }}</td>
                </tr>
                @if(isset($monthlyRegistrations))
                <tr>
                    <td>New This Month</td>
                    <td>{{ number_format($monthlyRegistrations, 0) }}</td>
                </tr>
                @endif
            </table>
        </div>
    </div>

    <!-- Parishioners by Gender -->
    @if(isset($parishionersByGender) && $parishionersByGender->count() > 0)
    <div class="section">
        <div class="section-header">Parishioners by Gender</div>
        <div class="section-content">
            <table>
                <thead>
                    <tr>
                        <th>Gender</th>
                        <th class="text-center">Count</th>
                        <th class="text-right">Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($parishionersByGender as $gender => $count)
                    <tr>
                        <td>{{ ucfirst($gender) }}</td>
                        <td class="text-center">{{ number_format($count, 0) }}</td>
                        <td class="text-right">{{ number_format(($count / ($totalParishioners ?? 1)) * 100, 1) }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Parishioners Details -->
    @if(isset($parishioners) && $parishioners->count() > 0)
    <div class="section">
        <div class="section-header">Parishioners Details</div>
        <div class="section-content">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 25%;">Full Name</th>
                        <th style="width: 10%;">Type</th>
                        <th style="width: 10%;">Gender</th>
                        <th style="width: 15%;">Phone</th>
                        <th style="width: 15%;">Email</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 10%;">Reg. Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($parishioners as $index => $parishioner)
                    <tr>
                        <td style="text-align: center; color: #9ca3af;">{{ $index + 1 }}</td>
                        <td><strong>{{ $parishioner->full_name }}</strong></td>
                        <td>
                            <span class="badge {{ $parishioner->type === 'wanafunzi' ? 'badge-student' : 'badge-worker' }}">
                                {{ $parishioner->type === 'wanafunzi' ? 'Student' : 'Worker' }}
                            </span>
                        </td>
                        <td>{{ ucfirst($parishioner->gender ?? 'N/A') }}</td>
                        <td>{{ $parishioner->contact_number ?? $parishioner->phone ?? 'N/A' }}</td>
                        <td>{{ $parishioner->email ?? 'N/A' }}</td>
                        <td>
                            <span class="badge {{ $parishioner->is_active ? 'badge-active' : 'badge-inactive' }}">
                                {{ $parishioner->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>{{ $parishioner->registration_date ? $parishioner->registration_date->format('M d, Y') : 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <div class="footer">
        <p><strong>Thank you for using TmcsSmart!</strong></p>
        <p>This is a computer-generated report. No signature required.</p>
        <p style="margin-top: 8px;">
            Generated on {{ now()->format('F d, Y \a\t H:i:s') }} | 
            Parishioners Report
            @if(isset($type))
            ({{ ucfirst($type === 'wanafunzi' ? 'Students' : 'Workers') }})
            @endif
        </p>
    </div>
</body>
</html>

