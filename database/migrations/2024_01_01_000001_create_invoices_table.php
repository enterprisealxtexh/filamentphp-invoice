<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('invoices')) {
            return;
        }

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();

            // Polymorphic: who is being billed (customer/client)
            $table->string('for_type');
            $table->unsignedBigInteger('for_id');
            $table->index(['for_type', 'for_id']);

            // Polymorphic: who is billing (company/seller)
            $table->string('from_type');
            $table->unsignedBigInteger('from_id');
            $table->index(['from_type', 'from_id']);

            // Created by user
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Customer info snapshot
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('address')->nullable();

            // Invoice type & status
            $table->string('type')->default('push')->nullable();
            $table->string('status')->default('draft')->nullable();
            $table->string('currency')->default('KES')->nullable();

            // Amounts
            $table->double('total')->default(0);
            $table->double('discount')->default(0);
            $table->double('shipping')->default(0);
            $table->double('vat')->default(0);
            $table->double('paid')->default(0);

            // Dates
            $table->date('date')->nullable();
            $table->date('due_date')->nullable();

            // Options
            $table->boolean('is_activated')->default(false)->nullable();
            $table->boolean('is_offer')->default(false)->nullable();
            $table->boolean('send_email')->default(false)->nullable();

            // Bank transfer details
            $table->boolean('is_bank_transfer')->default(false)->nullable();
            $table->string('bank_account')->nullable();
            $table->string('bank_account_owner')->nullable();
            $table->string('bank_iban')->nullable();
            $table->string('bank_swift')->nullable();
            $table->string('bank_address')->nullable();
            $table->string('bank_branch')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_city')->nullable();
            $table->string('bank_country')->nullable();

            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
