<?php

namespace Alxtexh\FilamentInvoices\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'from_id',
        'from_type',
        'for_id',
        'for_type',
        'user_id',
        'name',
        'phone',
        'address',
        'type',
        'status',
        'currency',
        'total',
        'discount',
        'shipping',
        'vat',
        'paid',
        'date',
        'due_date',
        'is_activated',
        'is_offer',
        'send_email',
        'is_bank_transfer',
        'bank_account',
        'bank_account_owner',
        'bank_iban',
        'bank_swift',
        'bank_address',
        'bank_branch',
        'bank_name',
        'bank_city',
        'bank_country',
        'notes',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'date' => 'datetime',
        'is_offer' => 'bool',
        'is_activated' => 'bool',
        'send_email' => 'bool',
        'is_bank_transfer' => 'bool',
        'total' => 'decimal:2',
        'discount' => 'decimal:2',
        'shipping' => 'decimal:2',
        'vat' => 'decimal:2',
        'paid' => 'decimal:2',
    ];

    public function invoiceMetas()
    {
        return $this->hasMany(InvoiceMeta::class);
    }

    public function meta(string $key, string|array|object|null $value = null): Model|string|null|array
    {
        if ($value !== null) {
            return $this->invoiceMetas()->updateOrCreate(
                ['key' => $key],
                ['value' => $value === 'null' ? null : $value]
            );
        }

        $meta = $this->invoiceMetas()->where('key', $key)->first();

        return $meta ? $meta->value : $this->invoiceMetas()->updateOrCreate(['key' => $key], ['value' => null]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoicesItems()
    {
        return $this->hasMany(InvoicesItem::class);
    }

    public function billedFor()
    {
        return $this->morphTo('for', 'for_type', 'for_id');
    }

    public function billedFrom()
    {
        return $this->morphTo('from', 'from_type', 'from_id');
    }

    public function invoiceLogs()
    {
        return $this->hasMany(InvoiceLog::class);
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'gray',
            'sent' => 'info',
            'paid' => 'success',
            'overdue' => 'danger',
            'cancelled' => 'warning',
            default => 'gray',
        };
    }

    public function getStatusIconAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'heroicon-o-document',
            'sent' => 'heroicon-o-paper-airplane',
            'paid' => 'heroicon-o-check-circle',
            'overdue' => 'heroicon-o-clock',
            'cancelled' => 'heroicon-o-x-circle',
            default => 'heroicon-o-document',
        };
    }
}
