@php
/**
 * Viewer values:
 * - receiver → receiver email (sees sender name)
 * - sender   → sender + support (sees recipient name)
 * - support  → sees both sender and recipient names
 */

$isTransfer = !empty($withdrawal->transfer_from);

// Sender name
$senderName = strtoupper($withdrawal->user->name ?? 'N/A');

// Extract recipient name safely from details column
$recipientName = 'N/A';
if (!empty($withdrawal->details) && is_string($withdrawal->details)) {
    preg_match('/Account Name:\s*(.*)/i', $withdrawal->details, $matches);
    if (!empty($matches[1])) {
        $recipientName = strtoupper(trim($matches[1]));
    }
}

// Decide who sees what
switch ($viewer) {
    case 'receiver':
        $displayLabel = 'Sender Name';
        $displayName  = $senderName;
        break;

    case 'support':
        $displayLabel = 'Transaction Parties';
        $displayName  = "Sender: $senderName | Recipient: $recipientName";
        break;

    case 'sender':
    default:
        $displayLabel = 'Recipient Name';
        $displayName  = $recipientName;
        break;
}

// Titles and labels
$title       = $isTransfer ? 'Transfer Transaction' : 'Withdrawal Transaction';
$actionText  = $isTransfer ? 'Transferred via' : 'Withdrawn via';
$amountLabel = $isTransfer ? 'Transfer Amount' : 'Withdrawal Amount';
$methodLabel = $isTransfer ? 'Transfer Method' : 'Payment Method';

// **Status (cast to int to avoid "Unknown")**
$statusText = match((int)$withdrawal->status) {
    0 => $isTransfer ? 'Transfer Processing' : 'Pending Review',
    1 => 'Successful',
    2 => 'Pending',
    default => 'Status Unknown',
};

// Unique transaction ID per viewer
$transactionId = strtoupper(substr(
    hash('sha256', $viewer . '|' . $withdrawal->id . '|' . $withdrawal->created_at),
    0,
    12
));
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $title }}</title>
<style>
body {
    background: #f8f7fc;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    color: #2d2d2d;
}
.container {
    max-width: 550px;
    margin: 30px auto;
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 12px rgba(0,0,0,.05);
    overflow: hidden;
}
.header {
    padding: 20px 25px;
    background: #faf9fe;
    border-bottom: 1px solid #eee;
}
.header h2 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
}
.transaction-box {
    padding: 25px;
    background: #faf9fe;
    text-align: center;
}
.transaction-box h1 {
    margin: 6px 0;
    font-size: 30px;
    color: #4a2acc;
}
.status {
    font-size: 14px;
    font-weight: 600;
    color: #f59e0b;
}
.details {
    padding: 20px 25px;
    border-top: 1px solid #eee;
}
table {
    width: 100%;
    border-collapse: collapse;
    font-size: 14px;
}
td {
    padding: 8px 0;
    border-bottom: 1px solid #f2f2f2;
}
td.label {
    color: #666;
    width: 45%;
}
td.value {
    text-align: right;
    font-weight: 600;
    color: #111;
}
.footer {
    padding: 20px;
    text-align: center;
    background: #faf9fe;
    font-size: 13px;
    color: #666;
}

.logo {
      text-align: center;
      margin-bottom: 12px;
    }
    .logo img {
      width: 65px;
      height: auto;
    }
</style>
</head>

<body>
<div class="container">
        <div class="logo">
      <img src="{{ asset('logo.png') }}" alt="fxbitozglobals.com Logo">
    </div>


    <div class="header">
        <h2>{{ $title }}</h2>
    </div>

    <div class="transaction-box">
        <p>{{ $actionText }} <strong>{{ strtoupper($withdrawal->method) }}</strong></p>
        <h1>
            {{ $withdrawal->user->currency_symbol ?? '$' }}{{ number_format($withdrawal->amount, 2) }}
        </h1>
        <div class="status">{{ $statusText }}</div>
    </div>

    <div class="details">
        <table>
            <tr>
                <td class="label">{{ $amountLabel }}</td>
                <td class="value">{{ $withdrawal->user->currency_symbol ?? '$' }}{{ number_format($withdrawal->amount, 2) }}</td>
            </tr>
            <tr>
                <td class="label">Fee</td>
                <td class="value">0.00</td>
            </tr>
            <tr>
                <td class="label">Total Sent</td>
                <td class="value">{{ $withdrawal->user->currency_symbol ?? '$' }}{{ number_format($withdrawal->amount, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="details">
        <table>
            <tr>
                <td class="label">{{ $displayLabel }}</td>
                <td class="value">{{ $displayName }}</td>
            </tr>
            <tr>
                <td class="label">Description</td>
                <td class="value">{{ $withdrawal->description ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Request Time</td>
                <td class="value">{{ $withdrawal->created_at->format('h:i A, M d, Y') }}</td>
            </tr>
            <tr>
                <td class="label">Transaction ID</td>
                <td class="value">{{ $transactionId }}</td>
            </tr>
            <tr>
                <td class="label">{{ $methodLabel }}</td>
                <td class="value">{{ ucfirst($withdrawal->method) }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        Need help with this transaction?<br>
        <strong>{{ config('app.name') }}</strong> © {{ date('Y') }}
    </div>

</div>
</body>
</html>
