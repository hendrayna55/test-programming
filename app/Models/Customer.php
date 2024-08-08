<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'm_customers';
    protected $guarded = ['id'];

    public function sales(){
        return $this->hasMany(Sale::class, 'cust_id');
    }
}
