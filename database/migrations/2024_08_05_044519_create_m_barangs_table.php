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
        Schema::create('m_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10);
            $table->string('nama', 100);
            $table->decimal('harga');
            $table->timestamps();
        });

        DB::table('m_barangs')->insert([
            [
                'kode' => 'A001',
                'nama' => 'Barang A',
                'harga' => 200000
            ],
            [
                'kode' => 'C025',
                'nama' => 'Barang B',
                'harga' => 350000
            ],
            [
                'kode' => 'A102',
                'nama' => 'Barang C',
                'harga' => 125000
            ],
            [
                'kode' => 'A301',
                'nama' => 'Barang D',
                'harga' => 300000
            ],
            [
                'kode' => 'B221',
                'nama' => 'Barang E',
                'harga' => 300000
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_barangs');
    }
};
