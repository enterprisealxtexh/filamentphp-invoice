<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('invoices_items')) {
            return;
        }

        Schema::create('invoices_items', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('item')->nullable();
            $table->foreignId('invoice_id')->constrained('invoices')->onDelete('cascade');

            // Polymorphic item reference (optional)
            $table->string('item_type')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();

            // Item details
            $table->string('item')->nullable();
            $table->string('description')->nullable();
            $table->string('note')->nullable();

            // Pricing
            $table->double('qty')->default(1)->nullable();
            $table->double('price')->default(0);
            $table->double('discount')->default(0);
            $table->double('vat')->default(0);
            $table->double('total')->default(0);

            // Returns
            $table->double('returned_qty')->default(0);
            $table->double('returned')->default(0);
            $table->boolean('is_free')->default(false)->nullable();
            $table->boolean('is_returned')->default(false)->nullable();

            $table->json('options')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices_items');
    }
};
