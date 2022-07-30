<?php
namespace App\Permissions;

use App\Models\Admin\ACL\Role;
use App\Models\Admin\ACL\Permission;

trait HasPermissionsTrait {
  public function hasPermissionTo($permission) {
    return $this->hasPermission($permission);
  }

  public function hasRole($role) {
      if ($this->role->slug == $role) {
        return true;
      }
    return false;
  }

  public function role() {
    return $this->belongsTo(Role::class , 'role_id');
  }

  public function permissions() {

    return $this->belongsToMany(Permission::class,'permissions_users');

  }
  protected function hasPermission($permission) {
    return (bool) $this->role->permissions->where('slug', $permission->slug)->count();
  }

}

