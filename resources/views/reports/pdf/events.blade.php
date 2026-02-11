<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Events Report - {{ config('app.name', 'TmcsSmart') }}</title>
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
        .badge-planned {
            background: #fef3c7;
            color: #92400e;
        }
        .badge-ongoing {
            background: #d1fae5;
            color: #065f46;
        }
        .badge-completed {
            background: #dbeafe;
            color: #1e40af;
        }
        .badge-cancelled {
            background: #fee2e2;
            color: #991b1b;
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
        <div class="title">EVENTS REPORT</div>
        <div class="header-info">
            @if(isset($dateFrom) && isset($dateTo))
            Period: <strong>{{ \Carbon\Carbon::parse($dateFrom)->format('F d, Y') }} to {{ \Carbon\Carbon::parse($dateTo)->format('F d, Y') }}</strong><br>
            @elseif(isset($month))
            Month: <strong>{{ \Carbon\Carbon::parse($month)->format('F Y') }}</strong><br>
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
                    <td>Total Events</td>
                    <td>{{ number_format($totalEvents ?? 0, 0) }}</td>
                </tr>
                <tr>
                    <td>Total Attendance</td>
                    <td>{{ number_format($totalAttendance ?? 0, 0) }}</td>
                </tr>
                <tr>
                    <td>Total Registrations</td>
                    <td>{{ number_format($totalRegistrations ?? 0, 0) }}</td>
                </tr>
                <tr>
                    <td>Total Budget</td>
                    <td>TSh {{ number_format($totalBudget ?? 0, 0) }}</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Events by Status -->
    @if(isset($eventsByStatus) && $eventsByStatus->count() > 0)
    <div class="section">
        <div class="section-header">Events by Status</div>
        <div class="section-content">
            <table>
                <thead>
                    <tr>
                        <th>Status</th>
                        <th class="text-center">Count</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($eventsByStatus as $status => $count)
                    <tr>
                        <td>{{ ucfirst(str_replace('_', ' ', $status)) }}</td>
                        <td class="text-center">{{ number_format($count, 0) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Events by Category -->
    @if(isset($eventsByCategory) && $eventsByCategory->count() > 0)
    <div class="section">
        <div class="section-header">Events by Category</div>
        <div class="section-content">
            <table>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th class="text-center">Count</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($eventsByCategory as $category => $count)
                    <tr>
                        <td>{{ ucfirst(str_replace('_', ' ', $category)) }}</td>
                        <td class="text-center">{{ number_format($count, 0) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Events Details -->
    @if(isset($events) && $events->count() > 0)
    <div class="section">
        <div class="section-header">Events Details</div>
        <div class="section-content">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 25%;">Event Title</th>
                        <th style="width: 15%;">Category</th>
                        <th style="width: 12%;">Start Date</th>
                        <th style="width: 12%;">Location</th>
                        <th style="width: 10%;" class="text-center">Attendance</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 11%;" class="text-right">Budget</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $index => $event)
                    <tr>
                        <td style="text-align: center; color: #9ca3af;">{{ $index + 1 }}</td>
                        <td><strong>{{ $event->title }}</strong></td>
                        <td>{{ ucfirst(str_replace('_', ' ', $event->category ?? $event->type)) }}</td>
                        <td>{{ $event->start_date->format('M d, Y') }}</td>
                        <td>{{ $event->location ?? 'N/A' }}</td>
                        <td class="text-center">{{ $event->total_attendance ?? $event->attendances->count() }}</td>
                        <td>
                            <span class="badge badge-{{ $event->status ?? 'planned' }}">
                                {{ ucfirst(str_replace('_', ' ', $event->status ?? 'planned')) }}
                            </span>
                        </td>
                        <td class="text-right">TSh {{ number_format($event->budget ?? 0, 0) }}</td>
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
            Events Report
            @if(isset($dateFrom) && isset($dateTo))
            ({{ \Carbon\Carbon::parse($dateFrom)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($dateTo)->format('M d, Y') }})
            @elseif(isset($month))
            ({{ \Carbon\Carbon::parse($month)->format('F Y') }})
            @endif
        </p>
    </div>
</body>
</html>

