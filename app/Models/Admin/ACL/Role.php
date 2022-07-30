<?php

namespace App\Models\Admin\ACL;

use App\Models\Admin\User\User;
use App\Models\Admin\ACL\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    protected $fillable = ['name' , 'slug' , 'status'];

    public function permissions() {
        return $this->belongsToMany(Permission::class,'permissions_roles');
     }

     public function users() {
        return $this->belongsToMany(User::class ,'role_id');
     }
}
