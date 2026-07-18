<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt - {{ $payment->reference_number ?? '' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { font-family: 'Inter', Arial, sans-serif; }
        body { background: #f5f5f5; margin: 0; padding: 20px; }
        .receipt { max-width: 700px; margin: 0 auto; background: white; padding: 40px; border: 1px solid #ddd; }
        .receipt-header { text-align: center; border-bottom: 3px double #0066CC; padding-bottom: 20px; margin-bottom: 20px; }
        .receipt-header h2 { color: #0066CC; margin-bottom: 4px; font-size: 22px; }
        .receipt-header p { color: #666; font-size: 12px; margin: 2px 0; }
        .receipt-title { text-align: center; font-size: 18px; font-weight: 700; color: #333; margin: 20px 0; text-transform: uppercase; letter-spacing: 2px; }
        .detail-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px dotted #eee; font-size: 13px; }
        .detail-row .label { color: #666; }
        .detail-row .value { font-weight: 600; color: #333; }
        .amount-box { background: #f0f7ff; border: 2px solid #0066CC; border-radius: 10px; padding: 20px; text-align: center; margin: 20px 0; }
        .amount-box .amount { font-size: 28px; font-weight: 700; color: #0066CC; }
        .amount-box .label { font-size: 12px; color: #666; }
        .amount-words { font-style: italic; color: #666; text-align: center; font-size: 13px; margin-bottom: 20px; }
        .receipt-footer { text-align: center; border-top: 1px solid #ddd; padding-top: 20px; margin-top: 30px; font-size: 12px; color: #999; }
        .stamp-area { display: flex; justify-content: space-between; margin-top: 40px; }
        .stamp { border: 1px dashed #ccc; padding: 15px 30px; text-align: center; font-size: 11px; color: #999; border-radius: 8px; }
        @media print {
            body { background: white; padding: 0; }
            .receipt { border: none; padding: 20px; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="no-print text-center mb-3">
        <button onclick="window.print()" class="btn btn-primary" style="background: #0066CC; color: white; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 600;">
            Print Receipt
        </button>
        <button onclick="history.back()" class="btn btn-outline-secondary ms-2" style="padding: 10px 24px; border-radius: 8px;">
            ← Back to Finance
        </button>
    </div>

    <div class="receipt">
        <div class="receipt-header">
            <h2>SISTECH COLLEGE</h2>
            <p>"Connecting People to Technology"</p>
            <p>Phone: {{ $settings['institution_phone'] ?? '+232 77 893 327' }}</p>
            <p>Email: {{ $settings['institution_email'] ?? 'sistech2025@gmail.com' }}</p>
            <p>Address: {{ $settings['institution_address'] ?? '11B Sankoh Street, Grassfield, Waterloo, Sierra Leone' }}</p>
        </div>

        <div class="receipt-title">Payment Receipt</div>

        <div class="detail-row">
            <span class="label">Receipt Number:</span>
            <span class="value">REC-{{ str_pad($payment->id ?? 0, 5, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="detail-row">
            <span class="label">Payment Reference:</span>
            <span class="value">{{ $payment->reference_number ?? 'N/A' }}</span>
        </div>
        <div class="detail-row">
            <span class="label">Date:</span>
            <span class="value">{{ \Carbon\Carbon::parse($payment->payment_date ?? now())->format('F d, Y') }}</span>
        </div>
        <div class="detail-row">
            <span class="label">Student Name:</span>
            <span class="value">{{ $payment->student->user->name ?? 'N/A' }}</span>
        </div>
        <div class="detail-row">
            <span class="label">Student ID:</span>
            <span class="value">{{ $payment->student->student_id ?? 'N/A' }}</span>
        </div>
        <div class="detail-row">
            <span class="label">Invoice Number:</span>
            <span class="value">{{ $payment->invoice->invoice_number ?? 'N/A' }}</span>
        </div>
        <div class="detail-row">
            <span class="label">Fee Type:</span>
            <span class="value">{{ $payment->invoice->description ?? 'N/A' }}</span>
        </div>
        <div class="detail-row">
            <span class="label">Payment Method:</span>
            <span class="value">{{ ucfirst(str_replace('_', ' ', $payment->method ?? 'N/A')) }}</span>
        </div>

        <div class="amount-box">
            <div class="label">AMOUNT PAID</div>
            <div class="amount">SLE {{ number_format($payment->amount ?? 0, 2) }}</div>
        </div>

        <div class="amount-words">
            {{ $amountInWords ?? 'Amount in words not available' }}
        </div>

        <div class="stamp-area">
            <div class="stamp">Authorized Signature</div>
            <div class="stamp">Official Stamp</div>
        </div>

        <div class="receipt-footer">
            <p>This is a computer-generated receipt and is valid without a signature or stamp.</p>
            <p>&copy; {{ date('Y') }} SISTECH College Management System. All rights reserved.</p>
            <p>Generated on {{ now()->format('F d, Y \a\t h:i A') }}</p>
        </div>
    </div>
</body>
</html>
