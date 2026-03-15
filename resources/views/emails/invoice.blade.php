<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; padding: 20px; background: #f8f9fa; border-bottom: 3px solid #333; }
        .company-name { font-size: 24px; font-weight: bold; }
        .content { padding: 30px 20px; }
        .invoice-badge { display: inline-block; padding: 8px 16px; background: #e2e8f0; font-weight: bold; margin: 15px 0; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #666; border-top: 1px solid #eee; }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">{{ $settings->company_name ?: 'Your Company' }}</div>
    </div>
    <div class="content">
        @if($body)
            {!! nl2br(e($body)) !!}
        @else
            <p>Dear {{ $invoice->name }},</p>
            <p>Please find attached the invoice for your reference.</p>
        @endif

        <div class="invoice-badge">
            Invoice #{{ $invoice->uuid }}
        </div>

        <table style="width: 100%; margin: 20px 0;">
            <tr>
                <td><strong>Date:</strong></td>
                <td>{{ $invoice->date?->format('M d, Y') }}</td>
            </tr>
            <tr>
                <td><strong>Due Date:</strong></td>
                <td>{{ $invoice->due_date?->format('M d, Y') }}</td>
            </tr>
            <tr>
                <td><strong>Total:</strong></td>
                <td>{{ number_format($invoice->total, 2) }} {{ $invoice->currency ?? $settings->default_currency }}</td>
            </tr>
            @if($invoice->paid > 0)
                <tr>
                    <td><strong>Paid:</strong></td>
                    <td>{{ number_format($invoice->paid, 2) }} {{ $invoice->currency ?? $settings->default_currency }}</td>
                </tr>
                <tr>
                    <td><strong>Balance Due:</strong></td>
                    <td>{{ number_format($invoice->total - $invoice->paid, 2) }} {{ $invoice->currency ?? $settings->default_currency }}</td>
                </tr>
            @endif
        </table>

        <p>If you have any questions, please don't hesitate to contact us.</p>
        <p>Best regards,<br>{{ $settings->company_name ?: 'Your Company' }}</p>
    </div>
    <div class="footer">
        @if($settings->company_email){{ $settings->company_email }} | @endif
        @if($settings->company_phone){{ $settings->company_phone }}@endif
    </div>
</body>
</html>
