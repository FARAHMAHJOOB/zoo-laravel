<?php

namespace App\Models\Admin\Animal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnimalImage extends Model
{
    use HasFactory,SoftDeletes;


    protected $guarded = ['id'];
    protected $casts = ['animal_image' => 'array'];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}
