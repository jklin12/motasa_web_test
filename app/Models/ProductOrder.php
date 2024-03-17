<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';
    public $timestamps = false;

    protected $fillable = ['do_id','product_name','product_price','product_qty'];

    public function getProductPriceAttribute($value){

        return 'Rp. '.number_format($value,0,2);
    }
    public function getTotalPriceAttribute($value){

        $sum = $this->getRawOriginal('product_price') * $this->product_qty;
        return 'Rp. '.number_format($sum,0,2);
    }
}
