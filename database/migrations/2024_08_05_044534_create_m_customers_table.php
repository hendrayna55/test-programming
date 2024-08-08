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
        Schema::create('m_customers', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10);
            $table->string('name', 100);
            $table->string('telp', 20);
            $table->timestamps();
        });

        DB::table('m_customers')->insert([
            [
                'kode' => 'c1',
                'name' => 'Customer A',
                'telp' => '081521941914'
            ],
            [
                'kode' => 'c2',
                'name' => 'Customer B',
                'telp' => '089696562258'
            ],
            [
                'kode' => 'c3',
                'name' => 'Customer C',
                'telp' => '087855248513'
            ],
            [
                'kode' => 'c4',
                'name' => 'Customer D',
                'telp' => '087855248513'
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_customers');
    }
};
