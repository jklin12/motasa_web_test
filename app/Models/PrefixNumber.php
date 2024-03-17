<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrefixNumber extends Model
{
    use HasFactory;

    protected $primaryKey = 'key';
    public $incrementing = false;

    protected $fillable = ['value'];
}
