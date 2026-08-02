<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('financial_reports', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('description');
            $table->enum('type', ['income', 'expense']); // income = Pemasukan, expense = Pengeluaran
            $table->decimal('amount', 12, 2);
            $table->string('category')->default('Umum'); // Contoh: Kas Utama, Yatim, Pembangunan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_reports');
    }
};
