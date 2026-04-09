<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message - {{ config('app.name') }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f9fafb;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            padding: 30px 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background: white;
            padding: 30px;
            border-radius: 0 0 8px 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .message-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
            font-family: 'Courier New', monospace;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .info-item {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e2e8f0;
        }
        .info-label {
            font-weight: 600;
            color: #4b5563;
            display: block;
            margin-bottom: 5px;
        }
        .info-value {
            color: #1f2937;
            font-size: 16px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }
        .btn-reply {
            display: inline-block;
            background-color: #3b82f6;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Contact Message</h1>
            <p>{{ config('app.name') }}</p>
        </div>
        
        <div class="content">
            <div class="info-item">
                <span class="info-label">From:</span>
                <span class="info-value">{{ $name }} &lt;{{ $email }}&gt;</span>
            </div>
            
            <div class="info-item">
                <span class="info-label">Date:</span>
                <span class="info-value">{{ now()->format('F j, Y \a\t g:i A') }}</span>
            </div>
            
            <div class="info-item">
                <span class="info-label">Message:</span>
            </div>
            
            <div class="message-box">
                {{ $message }}
            </div>
            
            <div class="footer">
                <p>This message was sent from the contact form on {{ config('app.name') }}.</p>
                <a href="mailto:{{ $email }}" class="btn-reply">Reply to {{ $name }}</a>
                <p style="margin-top: 20px;">
                    <small>IP Address: {{ request()->ip() }}</small>
                </p>
            </div>
        </div>
    </div>
</body>
</html>