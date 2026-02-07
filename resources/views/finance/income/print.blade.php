<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Receipt - {{ $income->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Courier New', monospace;
            font-size: 12px;
            line-height: 1.4;
            color: #000;
            width: 80mm;
            max-width: 80mm;
            margin: 0 auto;
            padding: 10mm 5mm;
            background: #fff;
        }
        
        .receipt {
            width: 100%;
        }
        
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }
        
        .header img {
            max-width: 50mm;
            height: auto;
            margin: 0 auto 10px;
            display: block;
        }
        
        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        
        .header p {
            font-size: 10px;
            margin: 2px 0;
        }
        
        .receipt-info {
            margin: 15px 0;
        }
        
        .receipt-info .row {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
            padding: 3px 0;
        }
        
        .receipt-info .label {
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .receipt-info .value {
            text-align: right;
        }
        
        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        
        .divider-thick {
            border-top: 2px solid #000;
            margin: 15px 0;
        }
        
        .amount-section {
            margin: 15px 0;
            text-align: center;
        }
        
        .amount-label {
            font-size: 11px;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        
        .amount-value {
            font-size: 24px;
            font-weight: bold;
            margin: 5px 0;
        }
        
        .details {
            margin: 15px 0;
        }
        
        .details .row {
            margin: 5px 0;
            padding: 3px 0;
        }
        
        .details .label {
            font-weight: bold;
            text-transform: uppercase;
            display: inline-block;
            width: 35%;
        }
        
        .details .value {
            display: inline-block;
            width: 63%;
            word-wrap: break-word;
        }
        
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 1px dashed #000;
            font-size: 10px;
        }
        
        .footer p {
            margin: 5px 0;
        }
        
        .thank-you {
            text-align: center;
            margin: 15px 0;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        @media print {
            body {
                padding: 5mm 3mm;
            }
            
            @page {
                size: 80mm auto;
                margin: 0;
            }
        }
    </style>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</head>
<body>
    <div class="receipt">
        <!-- Header -->
        <div class="header">
            <img src="{{ asset('logo.png') }}" alt="Logo" style="max-width: 50mm; height: auto; margin: 0 auto 10px; display: block;">
            <h1>Chaptance ya Mt. Yoseph</h1>
            <p>Mfanyakazi</p>
            <p>INCOME RECEIPT</p>
        </div>
        
        <!-- Receipt Info -->
        <div class="receipt-info">
            <div class="row">
                <span class="label">Receipt No:</span>
                <span class="value">#{{ str_pad($income->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="row">
                <span class="label">Date:</span>
                <span class="value">{{ $income->transaction_date->format('d/m/Y') }}</span>
            </div>
            <div class="row">
                <span class="label">Time:</span>
                <span class="value">{{ $income->transaction_date->format('H:i') }}</span>
            </div>
        </div>
        
        <div class="divider"></div>
        
        <!-- Amount Section -->
        <div class="amount-section">
            <div class="amount-label">Amount Received</div>
            <div class="amount-value">TZS {{ number_format($income->amount, 2) }}</div>
        </div>
        
        <div class="divider-thick"></div>
        
        <!-- Details -->
        <div class="details">
            <div class="row">
                <span class="label">Category:</span>
                <span class="value">{{ ucfirst(str_replace('_', ' ', $income->category)) }}</span>
            </div>
            <div class="row">
                <span class="label">Title:</span>
                <span class="value">{{ $income->title }}</span>
            </div>
            @if($income->description)
            <div class="row">
                <span class="label">Description:</span>
                <span class="value">{{ $income->description }}</span>
            </div>
            @endif
            @if($income->reference_number)
            <div class="row">
                <span class="label">Reference:</span>
                <span class="value">{{ $income->reference_number }}</span>
            </div>
            @endif
            <div class="row">
                <span class="label">Recorded By:</span>
                <span class="value">{{ $income->creator->name ?? 'N/A' }}</span>
            </div>
        </div>
        
        @if($income->notes)
        <div class="divider"></div>
        <div class="details">
            <div class="row">
                <span class="label">Notes:</span>
                <span class="value">{{ $income->notes }}</span>
            </div>
        </div>
        @endif
        
        <div class="divider-thick"></div>
        
        <!-- Thank You -->
        <div class="thank-you">
            Thank You!
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>This is a computer generated receipt</p>
            <p>TmcsSmart Management System</p>
            <p>{{ now()->format('Y') }} &copy; All Rights Reserved</p>
        </div>
    </div>
</body>
</html>

