<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDet extends Model
{
    use HasFactory;

    protected $table = 't_sales_dets';
    protected $guarded = ['id'];

    public function sale(){
        return $this->belongsTo(Sale::class, 'sales_id');
    }

    public function barang(){
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
