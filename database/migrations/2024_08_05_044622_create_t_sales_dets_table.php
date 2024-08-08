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
        Schema::create('t_sales_dets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sales_id');
            $table->foreign('sales_id')->references('id')->on('t_sales')->onDelete('cascade');
            $table->unsignedBigInteger('barang_id');
            $table->foreign('barang_id')->references('id')->on('m_barangs')->onDelete('cascade');
            $table->decimal('harga_bandrol', 15, 2);
            $table->integer('qty');
            $table->decimal('diskon_pct', 15, 2);
            $table->decimal('diskon_nilai', 15, 2);
            $table->decimal('harga_diskon', 15, 2);
            $table->decimal('total', 15, 2);
            $table->timestamps();
        });

        DB::table('t_sales_dets')->insert([
            [
                'sales_id' => 4,
                'barang_id' => 1,
                'harga_bandrol' => 200000.00,
                'qty' => 1,
                'diskon_pct' => 0.00,
                'diskon_nilai' => 0.00,
                'harga_diskon' => 200000.00,
                'total' => 200000.00
            ],
            [
                'sales_id' => 4,
                'barang_id' => 2,
                'harga_bandrol' => 350000.00,
                'qty' => 2,
                'diskon_pct' => 0.15,
                'diskon_nilai' => 52500.00,
                'harga_diskon' => 297500.00,
                'total' => 595000.00
            ],
            [
                'sales_id' => 4,
                'barang_id' => 3,
                'harga_bandrol' => 125000.00,
                'qty' => 2,
                'diskon_pct' => 0.20,
                'diskon_nilai' => 25000.00,
                'harga_diskon' => 100000.00,
                'total' => 200000.00
            ],
            [
                'sales_id' => 4,
                'barang_id' => 4,
                'harga_bandrol' => 300000.00,
                'qty' => 3,
                'diskon_pct' => 0.00,
                'diskon_nilai' => 0.00,
                'harga_diskon' => 300000.00,
                'total' => 900000.00
            ],
            [
                'sales_id' => 4,
                'barang_id' => 5,
                'harga_bandrol' => 300000.00,
                'qty' => 2,
                'diskon_pct' => 0.00,
                'diskon_nilai' => 0.00,
                'harga_diskon' => 300000.00,
                'total' => 600000.00
            ],
            [
                'sales_id' => 1,
                'barang_id' => 4,
                'harga_bandrol' => 300000.00,
                'qty' => 3,
                'diskon_pct' => 0.00,
                'diskon_nilai' => 0.00,
                'harga_diskon' => 300000.00,
                'total' => 900000.00
            ],
            [
                'sales_id' => 1,
                'barang_id' => 5,
                'harga_bandrol' => 300000.00,
                'qty' => 2,
                'diskon_pct' => 0.00,
                'diskon_nilai' => 0.00,
                'harga_diskon' => 300000.00,
                'total' => 600000.00
            ],
            [
                'sales_id' => 2,
                'barang_id' => 1,
                'harga_bandrol' => 200000.00,
                'qty' => 1,
                'diskon_pct' => 0.00,
                'diskon_nilai' => 0.00,
                'harga_diskon' => 200000.00,
                'total' => 200000.00
            ],
            [
                'sales_id' => 2,
                'barang_id' => 2,
                'harga_bandrol' => 350000.00,
                'qty' => 2,
                'diskon_pct' => 0.15,
                'diskon_nilai' => 52500.00,
                'harga_diskon' => 297500.00,
                'total' => 595000.00
            ],
            [
                'sales_id' => 2,
                'barang_id' => 3,
                'harga_bandrol' => 125000.00,
                'qty' => 2,
                'diskon_pct' => 0.20,
                'diskon_nilai' => 25000.00,
                'harga_diskon' => 100000.00,
                'total' => 200000.00
            ],
            [
                'sales_id' => 3,
                'barang_id' => 5,
                'harga_bandrol' => 300000.00,
                'qty' => 2,
                'diskon_pct' => 0.00,
                'diskon_nilai' => 0.00,
                'harga_diskon' => 300000.00,
                'total' => 600000.00
            ],
            [
                'sales_id' => 5,
                'barang_id' => 3,
                'harga_bandrol' => 125000.00,
                'qty' => 2,
                'diskon_pct' => 0.20,
                'diskon_nilai' => 25000.00,
                'harga_diskon' => 100000.00,
                'total' => 200000.00
            ],
            [
                'sales_id' => 5,
                'barang_id' => 4,
                'harga_bandrol' => 300000.00,
                'qty' => 3,
                'diskon_pct' => 0.00,
                'diskon_nilai' => 0.00,
                'harga_diskon' => 300000.00,
                'total' => 900000.00
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_sales_dets');
    }
};
