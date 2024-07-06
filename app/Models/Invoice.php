<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ["status", "customer_email", "customer_phone", "customer_city", "customer_address", "customer_name", "order_id"];

    public function products()
    {
        return $this->hasMany(InvoiceProduct::class);
    }

}
