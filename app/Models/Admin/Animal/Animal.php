<?php

namespace App\Models\Admin\Animal;

use App\Models\Admin\Comment\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Animal extends Model
{
    use HasFactory, SoftDeletes, Sluggable,Notifiable;
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    protected $guarded = ['id'];
    protected $casts = ['image' => 'array'];
    public function category()
    {
        return $this->belongsTo(AnimalCategory::class, 'category_id');
    }

   public function comments()
   {
      return $this->morphMany(Comment::class , 'commentable');
   }

    public function metas()
    {
        return $this->hasMany(AnimalMeta::class);
    }

     public function images()
    {
        return $this->hasMany(AnimalImage::class);
    }

    public function protective()
    {
        return $this->belongsTo(AnimalProtectiveStatus::class);
    }

    public function getStatusAttribute($status)
    {
        if ($status == 0) {
            return 'غیرفعال';
        } else {
            return 'فعال';
        }
    }
}
