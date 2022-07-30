<?php

namespace App\Models\Admin\Animal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnimalProtectiveStatus extends Model
{
    use HasFactory,SoftDeletes;

    protected $table='animal_protective_status';

    protected $guarded=['id'];

    public function animals()
    {
        return $this->hasMany(Animal::class,'protective_id');
    }
}
