<?php

namespace App\Models\Admin\ACL;

use App\Models\Admin\ACL\Role;
use App\Models\Admin\User\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name' , 'slug'];

    public function roles() {
        return $this->belongsToMany(Role::class,'permissions_roles');

     }

  
}
