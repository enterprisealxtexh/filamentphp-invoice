<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Currencies
    |--------------------------------------------------------------------------
    |
    | Define available currencies for invoices. You can add or remove currencies
    | as needed. The key is the ISO code and value is the display name.
    |
    */
    'currencies' => [
        'KES' => 'KES - Kenyan Shilling',
        'USD' => 'USD - US Dollar',
        'EUR' => 'EUR - Euro',
        'GBP' => 'GBP - British Pound',
        'TZS' => 'TZS - Tanzanian Shilling',
        'UGX' => 'UGX - Ugandan Shilling',
        'ZAR' => 'ZAR - South African Rand',
        'NGN' => 'NGN - Nigerian Naira',
        'INR' => 'INR - Indian Rupee',
        'AED' => 'AED - UAE Dirham',
    ],

    /*
    |--------------------------------------------------------------------------
    | Invoice Statuses
    |--------------------------------------------------------------------------
    |
    | Configure the available invoice statuses and their display properties.
    |
    */
    'statuses' => [
        'draft' => 'Draft',
        'sent' => 'Sent',
        'paid' => 'Paid',
        'overdue' => 'Overdue',
        'cancelled' => 'Cancelled',
    ],

    'status_colors' => [
        'draft' => 'gray',
        'sent' => 'info',
        'paid' => 'success',
        'overdue' => 'danger',
        'cancelled' => 'warning',
    ],

    'status_icons' => [
        'draft' => 'heroicon-o-document',
        'sent' => 'heroicon-o-paper-airplane',
        'paid' => 'heroicon-o-check-circle',
        'overdue' => 'heroicon-o-clock',
        'cancelled' => 'heroicon-o-x-circle',
    ],

    /*
    |--------------------------------------------------------------------------
    | Invoice Types
    |--------------------------------------------------------------------------
    |
    | Configure the available invoice types.
    |
    */
    'types' => [
        'push' => 'Invoice',
        'pull' => 'Bill',
        'orders' => 'Order',
    ],

    /*
    |--------------------------------------------------------------------------
    | PDF Settings
    |--------------------------------------------------------------------------
    |
    | Default PDF generation settings.
    |
    */
    'pdf' => [
        'paper_size' => 'A4',
        'orientation' => 'portrait',
    ],
];
