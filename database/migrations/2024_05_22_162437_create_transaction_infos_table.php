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
        Schema::create('transaction_infos', function (Blueprint $table) {
            $table->id();
            $table->string('FUND_cluster', 30);
            $table->string('BUR_number', 30)->nullable();
            $table->string('PO_number', 30)->nullable();
            $table->string('Supplier', 50);
            $table->string('Description', 255);
            $table->integer('Amount');
            $table->date('Target_Delivery');
            $table->string('Office');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_infos');
    }
};
