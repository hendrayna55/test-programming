<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'm_barangs';
    protected $guarded = ['id'];

    public function sales_dets(){
        return $this->hasMany(SalesDet::class, 'barang_id');
    }
}
