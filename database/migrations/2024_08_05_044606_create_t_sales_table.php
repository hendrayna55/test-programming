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
        Schema::create('t_sales', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 15);
            $table->datetime('tgl');
            $table->unsignedBigInteger('cust_id');
            $table->foreign('cust_id')->references('id')->on('m_customers')->onDelete('cascade');
            $table->decimal('subtotal', 15, 2);
            $table->decimal('diskon', 15, 2)->nullable();
            $table->decimal('ongkir', 15, 2)->nullable();
            $table->decimal('total_bayar', 15, 2);
            $table->timestamps();
        });

        DB::table('t_sales')->insert([
            [
                'kode' => '202101-0005',
                'tgl' => '2021-01-03 00:00:00',
                'cust_id' => 4,
                'subtotal' => 560000.00,
                'diskon' => null,
                'ongkir' => null,
                'total_bayar' => 560000.00,
            ],
            [
                'kode' => '202101-0004',
                'tgl' => '2021-01-02 00:00:00',
                'cust_id' => 3,
                'subtotal' => 320000.00,
                'diskon' => null,
                'ongkir' => null,
                'total_bayar' => 320000.00,
            ],
            [
                'kode' => '202101-0003',
                'tgl' => '2021-01-02 00:00:00',
                'cust_id' => 1,
                'subtotal' => 125000.00,
                'diskon' => null,
                'ongkir' => null,
                'total_bayar' => 125000.00,
            ],
            [
                'kode' => '202101-0002',
                'tgl' => '2021-01-01 00:00:00',
                'cust_id' => 2,
                'subtotal' => 600000.00,
                'diskon' => null,
                'ongkir' => 15000.00,
                'total_bayar' => 615000.00,
            ],
            [
                'kode' => '202101-0001',
                'tgl' => '2021-01-01 00:00:00',
                'cust_id' => 1,
                'subtotal' => 250000.00,
                'diskon' => 5000.00,
                'ongkir' => null,
                'total_bayar' => 245000.00,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_sales');
    }
};
