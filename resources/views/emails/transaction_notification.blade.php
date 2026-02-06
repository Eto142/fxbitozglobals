<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transaction Receipt - fxbitozglobals.com</title>
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
    .details {
      margin-top: 10px;
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
    .status {
      text-align: center;
      margin-top: 10px;
      font-size: 12.5px;
      font-weight: 600;
      color: #10b981;
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
      Transaction Details
    </div>

    <div class="details">
      <table>
        <tr><td class="label">Received from:</td><td class="value">{{ $details['sender_name'] }}</td></tr>
        <tr><td class="label">Transaction Type:</td><td class="value">{{ ucfirst($details['transactionType']) }}</td></tr>
        <tr><td class="label">Amount:</td><td class="value">{{ $details['currency_symbol'] }}{{ number_format($details['amount'], 2) }}</td></tr>
        <tr><td class="label">Description:</td><td class="value">{{ $details['description'] }}</td></tr>
        <tr><td class="label">Sender Name:</td><td class="value">{{ $details['sender_name'] }}</td></tr>
        <tr><td class="label">Sender Account:</td><td class="value">{{ $details['sender_account'] }}</td></tr>
        <tr><td class="label">Date & Time:</td><td class="value">{{ $details['date_time'] }}</td></tr>
        <tr>
          <td class="label">Transaction ID:</td>
          <td class="value">
            {{ isset($details['id'], $details['created_at']) 
                ? substr(md5($details['id'] . $details['created_at']), 0, 12) 
                : substr(md5(json_encode($details)), 0, 12) }}
          </td>
        </tr>
      </table>

      <div class="status">
        Status: {{ ucfirst($details['dep_status']) }}
      </div>
    </div>

    <div class="footer">
      © {{ date('Y') }} fxbitozglobals.com — All Rights Reserved<br>
      This is an automated receipt. Please do not reply.
    </div>
  </div>
</body>
</html>
