<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Deposit Receipt - fxbitozglobals.com</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #f3f4f6;
      font-family: 'Work Sans', Arial, sans-serif;
      color: #111827;
    }
    .receipt-container {
      background-color: #ffffff;
      max-width: 370px;
      margin: 15px auto;
      border-radius: 10px;
      box-shadow: 0 1px 6px rgba(0,0,0,0.06);
      padding: 18px;
    }
    .logo {
      text-align: center;
      margin-bottom: 12px;
    }
    .logo img {
      width: 65px;
      height: auto;
    }
    .header {
      text-align: center;
      padding: 8px 0;
      background-color: #1f2937;
      color: #ffffff;
      font-size: 15px;
      font-weight: 600;
      border-radius: 6px;
      margin-bottom: 10px;
    }
    .amount-box {
      text-align: center;
      margin: 15px 0 10px 0;
    }
    .amount-box h1 {
      font-size: 24px;
      margin: 5px 0;
      color: #1f2937;
      font-weight: 700;
    }
    .status {
      text-align: center;
      margin-top: 5px;
      font-size: 12.5px;
      font-weight: 600;
      color: #10b981;
    }
    .details {
      margin-top: 15px;
      border-top: 1px solid #e5e7eb;
      padding-top: 10px;
    }
    .details table {
      width: 100%;
      border-collapse: collapse;
    }
    .details td {
      padding: 4px 0;
      font-size: 12px;
    }
    .details td.label {
      color: #6b7280;
      width: 45%;
      font-weight: 500;
    }
    .details td.value {
      color: #111827;
      font-weight: 600;
      text-align: right;
    }
    .footer {
      text-align: center;
      font-size: 10.5px;
      color: #6b7280;
      margin-top: 15px;
      border-top: 1px solid #e5e7eb;
      padding-top: 10px;
      line-height: 1.4;
    }
    .footer a {
      color: #1f2937;
      text-decoration: none;
      font-weight: 600;
    }
    @media (max-width: 600px) {
      .receipt-container {
        padding: 14px;
        margin: 10px;
      }
      .details td {
        font-size: 11.5px;
      }
    }
  </style>
</head>
<body>
  <div class="receipt-container">
    <div class="logo">
      <img src="{{ asset('logo.png') }}" alt="fxbitozglobals.com Logo">
    </div>

    <div class="header">
      Deposit Transaction
    </div>

    <div class="amount-box">
      <p style="margin: 0; font-size: 13px;">To <strong>{{ strtoupper($details['name'] ?? 'N/A') }}</strong></p>
      <h1>{{ $details['currency_symbol'] ?? '$' }}{{ number_format($details['amount'], 2) }}</h1>
      <div class="status">
        Status: {{ $details['dep_status'] == '0' ? 'Pending Review' : 'Successful' }}
      </div>
    </div>

    <div class="details">
      <table>
        <tr><td class="label">Transfer Amount</td><td class="value">{{ $details['currency_symbol'] ?? '$' }}{{ number_format($details['amount'], 2) }}</td></tr>
        <tr><td class="label">Fee</td><td class="value">{{ $details['currency_symbol'] ?? '$' }}0.00</td></tr>
        <tr><td class="label">Payment Amount</td><td class="value">{{ $details['currency_symbol'] ?? '$' }}{{ number_format($details['amount'], 2) }}</td></tr>
        <tr><td class="label">Description</td><td class="value">{{ strtoupper($details['description'] ?? 'N/A') }}</td></tr>
      </table>
    </div>

    <div class="details">
      <table>
        <tr><td class="label">Recipient Name</td><td class="value">{{ strtoupper($details['name'] ?? 'N/A') }}</td></tr>
        <tr><td class="label">Account Number</td><td class="value">{{ $details['sender_account'] ?? 'N/A' }}</td></tr>
        <tr><td class="label">Completion Time</td><td class="value">{{ $details['date_time'] ?? now()->format('h:i A, M d, Y') }}</td></tr>
        <tr><td class="label">Transaction ID</td>
          <td class="value">
            {{ isset($details['id'], $details['created_at']) 
                ? substr(md5($details['id'] . $details['created_at']), 0, 12) 
                : substr(md5(json_encode($details)), 0, 12) }}
          </td>
        </tr>
        <tr><td class="label">Payer Name</td><td class="value">{{ strtoupper($details['payer_name'] ?? 'N/A') }}</td></tr>
      </table>
    </div>

    <div class="footer">
      © {{ date('Y') }} fxbitozglobals.com — All Rights Reserved<br>
      Need help? <a href="{{ url('contact') }}">Contact Support</a><br>
      This is an automated receipt. Please do not reply.
    </div>
  </div>
</body>
</html>
