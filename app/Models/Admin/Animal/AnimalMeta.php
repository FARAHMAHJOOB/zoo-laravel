<?php

namespace App\Models\Admin\Animal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnimalMeta extends Model
{
    use HasFactory,SoftDeletes;

    protected $table='animal_meta';

    protected $guarded=['id'];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}
