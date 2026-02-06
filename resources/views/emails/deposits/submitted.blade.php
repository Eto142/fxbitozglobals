<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Deposit Receipt</title>
  <style>
    body {
      background-color: #f8f7fc;
      font-family: 'Inter', Arial, sans-serif;
      margin: 0;
      padding: 0;
      color: #2d2d2d;
    }
    .container {
      max-width: 550px;
      margin: 30px auto;
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 2px 12px rgba(0,0,0,0.05);
      overflow: hidden;
    }
    .header {
      padding: 20px 25px;
      border-bottom: 1px solid #eee;
      background: #faf9fe;
    }
    .header h2 {
      font-size: 18px;
      font-weight: 600;
      color: #333;
      margin: 0;
    }
    .transaction-box {
      padding: 25px;
      background: #faf9fe;
      text-align: center;
    }
    .transaction-box h1 {
      font-size: 30px;
      font-weight: 700;
      color: #4a2acc;
      margin: 5px 0;
    }
    .success {
      color: #16c784;
      font-weight: 500;
      font-size: 15px;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }
    .success img {
      width: 16px;
      height: 16px;
    }
    .details-section {
      background: #fff;
      padding: 20px 25px;
      border-top: 1px solid #eee;
    }
    .details-section table {
      width: 100%;
      border-collapse: collapse;
      font-size: 14px;
    }
    .details-section td {
      padding: 8px 0;
      border-bottom: 1px solid #f2f2f2;
    }
    .details-section td.label {
      color: #666;
      font-weight: 500;
      width: 45%;
    }
    .details-section td.value {
      text-align: right;
      color: #111;
      font-weight: 600;
    }
    .footer {
      text-align: center;
      padding: 20px;
      background: #faf9fe;
      font-size: 13px;
      color: #666;
    }
    .footer a {
      color: #4a2acc;
      text-decoration: none;
      font-weight: 500;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h2>Transaction Details</h2>
    </div>

    <div class="transaction-box">
      <p>To <strong>{{ strtoupper($deposit->bank_name ?? $deposit->payment_mode) }}</strong></p>
      <h1>{{ $deposit->user->currency_symbol ?? '$' }}{{ number_format($deposit->amount, 2) }}</h1>
      <p class="success">
        <img src="https://upload.wikimedia.org/wikipedia/commons/8/8d/Check_mark_2.svg" alt="✔">
        {{ $deposit->status == '0' ? 'Pending Review' : 'Successful' }}
      </p>
    </div>

    <div class="details-section">
      <table>
        <tr>
          <td class="label">Transfer Amount</td>
          <td class="value">{{ $deposit->user->currency_symbol ?? '$' }}{{ number_format($deposit->amount, 2) }}</td>
        </tr>
        <tr>
          <td class="label">Fee</td>
          <td class="value">{{ $deposit->user->currency_symbol ?? '$' }}0.00</td>
        </tr>
        <tr>
          <td class="label">Payment Amount</td>
          <td class="value">{{ $deposit->user->currency_symbol ?? '$' }}{{ number_format($deposit->amount, 2) }}</td>
        </tr>
      </table>
    </div>

    <div class="details-section">
      <table>
        <tr>
          <td class="label">Recipient Name</td>
          <td class="value">{{ strtoupper($deposit->user->name ?? 'N/A') }}</td>
        </tr>
        <tr>
          <td class="label">Account Number</td>
          <td class="value">{{ $deposit->user->account_number ?? 'N/A' }}</td>
        </tr>
        
        <tr>
          <td class="label">Description</td>
          <td class="value">{{ $deposit->description ?? 'N/A' }}</td>
        </tr>
        <tr>
          <td class="label">Completion Time</td>
          <td class="value">{{ now()->format('h:i A, M d, Y') }}</td>
        </tr>
        <tr>
          <td class="label">Transaction ID</td>
          <td class="value">{{ substr(md5($deposit->id . $deposit->created_at), 0, 12) }}</td>
        </tr>
        <tr>
          <td class="label">Payment Method</td>
          <td class="value">{{ ucfirst($deposit->payment_mode) }}</td>
        </tr>
        <tr>
          <td class="label">Payer Name</td>
          <td class="value">{{ strtoupper($deposit->user->name) }}</td>
        </tr>
      </table>
    </div>

    <div class="footer">
      Any questions about this transaction?<br>
      <a href="{{ url('contact') }}">Customer Service</a>
      <br><br>
      <strong>{{ config('app.name') }}</strong> © {{ date('Y') }}
    </div>
  </div>
</body>
</html>
