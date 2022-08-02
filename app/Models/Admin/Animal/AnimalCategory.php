<?php

namespace App\Models\Admin\Animal;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnimalCategory extends Model
{
   use HasFactory, SoftDeletes, Sluggable;

   public function sluggable(): array
   {
       return [
           'slug' => [
               'source' => 'name'
           ]
       ];
   }

   public function getStatusAttribute($status)
   {
       return $status == 0 ? 'غیرفعال':'فعال';
   }

    protected $guarded=['id'];

    public function parent()
    {
       return $this->belongsTo(AnimalCategory::class);
    }
    public function childs()
    {
       return $this->hasMany(AnimalCategory::class);
    }
    public function animals()
    {
       return $this->hasMany(Animal::class,'category_id');
    }



}
