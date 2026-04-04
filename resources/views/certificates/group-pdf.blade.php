<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Group Participation Certificate</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Georgia', serif;
            background: url('{{ asset('images/certificate-bg.jpg') }}') no-repeat center center;
            background-size: cover;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .certificate-container {
            width: 800px;
            height: 600px;
            background: white;
            border: 10px solid #d4af37;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            position: relative;
            padding: 40px;
            text-align: center;
        }
        .certificate-header {
            margin-bottom: 30px;
        }
        .certificate-title {
            font-size: 28px;
            font-weight: bold;
            color: #d4af37;
            margin-bottom: 10px;
        }
        .certificate-body {
            font-size: 16px;
            line-height: 1.6;
            color: #333;
            margin-bottom: 30px;
        }
        .group-name {
            font-size: 20px;
            font-weight: bold;
            color: #d4af37;
            margin: 20px 0;
        }
        .recipient-name {
            font-size: 24px;
            font-weight: bold;
            color: #d4af37;
            margin: 20px 0;
        }
        .certificate-footer {
            margin-top: 40px;
            font-size: 14px;
            color: #666;
        }
        .qr-code {
            position: absolute;
            bottom: 20px;
            right: 20px;
            padding: 8px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .certificate-id {
            font-size: 12px;
            font-family: 'Courier New', monospace;
            color: #666;
            background: #f8f9fa;
            padding: 4px 8px;
            border-radius: 4px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="certificate-header">
            <h1 class="certificate-title">Certificate of Participation</h1>
        </div>
        
        <div class="certificate-body">
            <p>This is to certify that</p>
            
            @if($certificate->group_name)
                <div class="group-name">{{ $certificate->group_name }}</div>
            @endif
            
            <div class="recipient-name">{{ $certificate->recipient_name }}</div>
            <p>has been an active member of the <strong>{{ $certificate->group_name ?? 'Community Group' }}</strong></p>
            
            @if($certificate->description)
                <p><em>{{ $certificate->description }}</em></p>
            @endif
            
            <p>Issued on this {{ $certificate->issue_date->format('d') }} day of {{ $certificate->issue_date->format('F') }}, {{ $certificate->issue_date->format('Y') }}</p>
        </div>
        
        <div class="certificate-footer">
            <div class="certificate-id">Certificate ID: {{ $certificate->certificate_number }}</div>
            <div class="qr-code">{!! $qrCode !!}</div>
        </div>
    </div>
</body>
</html>
