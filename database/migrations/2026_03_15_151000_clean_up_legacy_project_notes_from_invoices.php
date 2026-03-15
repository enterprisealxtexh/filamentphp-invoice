<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Remove lengthy project-related notes (Phase descriptions, deliverables, etc.)
        // These are legacy project documentation that shouldn't be displayed as invoice notes
        DB::table('invoices')
            ->where('notes', 'like', '%Phase%')
            ->orWhere('notes', 'like', '%Deliverable%')
            ->orWhere('notes', 'like', '%WORK DURATION%')
            ->update(['notes' => null]);

        // Keep only short, useful payment or invoice notes (under 200 characters)
        $invoices = DB::table('invoices')
            ->whereNotNull('notes')
            ->get();

        foreach ($invoices as $invoice) {
            if (strlen($invoice->notes) > 300) {
                DB::table('invoices')
                    ->where('id', $invoice->id)
                    ->update(['notes' => null]);
            }
        }
    }

    public function down(): void
    {
        // This is a data cleanup migration, rollback is not applicable
    }
};
