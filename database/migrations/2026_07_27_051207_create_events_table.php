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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            
            // 'rutin' (kajian mingguan/harian) atau 'insidental' (acara tanggal tertentu/gotong royong)
            $table->enum('type', ['rutin', 'insidental'])->default('rutin');
            
            // Digunakan jika type == 'rutin' (misal: "Setiap Minggu Ba'da Subuh", "Jumat Ba'da Ashar")
            $table->string('routine_day')->nullable(); 

            // Speaker dibuat nullable karena acara insidental seperti gotong royong / rapat tidak selalu ada ustaz
            $table->string('speaker')->nullable(); 

            // Waktu acara pasti (nullable jika type == 'rutin')
            $table->dateTime('event_date')->nullable();
            
            $table->string('location')->default('Ruang Utama Masjid');
            $table->string('poster')->nullable();
            $table->text('description')->nullable(); // Tambahan opsional untuk detail acara/kajian
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};