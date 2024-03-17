<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryOrder extends Model
{
    use HasFactory;

    protected $primaryKey = 'do_id';

    protected $fillable = ['do_number','do_date','order_number','order_date','cust_name','cust_phone','cust_email','cust_address','do_notes','do_status','do_from','do_from_detail','do_to','do_to_detail','courier_name','courier_service_name','shipping_duration','shipping_price'];

    protected $dates = ['order_date']; // Kolom 'tanggal' akan dianggap sebagai tipe data tanggal oleh Eloquent

    public function products(){

        return $this->hasMany(ProductOrder::class,'do_id','do_id');
    }
    public function history(){

        return $this->hasMany(HistoryDo::class,'do_id','do_id');
    }
    public function owner(){

        return $this->hasOne(User::class,'id','created_by');
    }
    // Mutator untuk format input
    public function setOrderDateAttribute($value)
    {
        // Konversi format input dari pengguna ke format tanggal yang sesuai
        $this->attributes['order_date'] = $value ? Carbon::createFromFormat('d M, Y', $value)->toDateString() : null;
    }

    // Aksesors untuk format tampilan
    public function getOrderDateAttribute($value)
    {
        // Konversi format tanggal yang disimpan di basis data ke format yang diinginkan untuk ditampilkan
        return Carbon::parse($value)->format('d M, Y');
    }
    
    public function getDoDateAttribute($value)
    {
        // Konversi format tanggal yang disimpan di basis data ke format yang diinginkan untuk ditampilkan
        return $value ? Carbon::parse($value)->format('d M, Y') : '';
    }

     

    public function getDoStatusBadgeAttribute()
    {
         if ($this->do_status == 'Draft') {
            return '<span class="badge text-bg-info h-5">'.$this->do_status.'</span>';
         }elseif ($this->do_status == 'New') {
            return '<span class="badge text-bg-warning h-5">'.$this->do_status.'</span>';
         }elseif ($this->do_status == 'Approve') {
            return '<span class="badge text-bg-success h-5">'.$this->do_status.'</span>';
         }elseif ($this->do_status == 'Revisi') {
            return '<span class="badge text-bg-danger h-5">'.$this->do_status.'</span>';
         }elseif ($this->do_status == 'Reject') {
            return '<span class="badge text-bg-dark h-5">'.$this->do_status.'</span>';
         }
    }

    public function getShippingPriceAttribute($value){

        //dd($value);
        return 'Rp. '.number_format(intval($value),0,2);
    }
    
    protected static function boot()
    {
        parent::boot();

        // updating created_by and updated_by when model is created
        static::creating(function ($model) {
            
            if ($model->do_status == 'New') {
                $sequence = PrefixNumber::where('key', 'do')->firstOrFail();
                // Tambahkan nomor urut ke model
                $model->do_number = 'DO-'.date('my').'-'.$sequence->value;
                $model->do_date = date('Y-m-d');
                // Update nomor urut di tabel number_sequences
                $sequence->increment('value');    
                
            }
            
            if (!$model->isDirty('created_by')) {
                $model->created_by = auth()->user()->id;
            }
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = auth()->user()->id;
            }
        });

        // updating updated_by when model is updated
        static::updating(function ($model) {
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = auth()->user()->id;
            }
        });
    }
}
