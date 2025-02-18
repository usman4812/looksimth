<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('worker_id')->nullable();
            $table->string('date')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->float('total', 8, 2)->default(0);
            $table->text('contract_file')->nullable();
            $table->text('address')->nullable();
            $table->string('amount')->nullable();
            $table->tinyInteger('instance')->nullable();
            $table->enum('status',['accepted','rejected','completed','cancelled','hold','unhold','pending','assigned'])->default('pending');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('worker_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('payment_type',['cash_payment','cash_tva_payment','cash_tax_payment','card_tva','card_tax'])->nullable();
            $table->integer('total_cash')->nullable();
            $table->integer('material_cash')->nullable();
            $table->integer('rest_cash')->nullable();
            $table->integer('worker_cash')->nullable();
            $table->integer('worker_material_cost')->nullable();
            $table->integer('office_cash')->nullable();
            $table->integer('cash_tva_percentage')->nullable();
            $table->integer('cash_tax_percentage')->nullable();
            $table->integer('total_charge')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('auth_number')->nullable();
            $table->text('description')->nullable();
            $table->string('warranty_date')->nullable();
            $table->string('online_status')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
