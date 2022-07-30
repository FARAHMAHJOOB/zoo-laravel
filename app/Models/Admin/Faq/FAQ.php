<?php

namespace App\Models\Admin\Faq;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FAQ extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='faqs';
    protected $guarded=['id'];

}
