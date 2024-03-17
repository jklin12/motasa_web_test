<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryDo extends Model
{
    use HasFactory;
    protected $primaryKey = 'history_id';

    protected $fillable = ['do_id','do_status','history_notes'];

    public function owner(){

        return $this->hasOne(User::class,'id','created_by');
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

    public function getCreatedAtFormatAttribute($value)
    {
        // Konversi format tanggal yang disimpan di basis data ke format yang diinginkan untuk ditampilkan
        return  Carbon::parse($value)->format('d M, Y - H:i') ;
    }

    protected static function boot()
    {
        parent::boot();

        // updating created_by and updated_by when model is created
        static::creating(function ($model) {
            
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
