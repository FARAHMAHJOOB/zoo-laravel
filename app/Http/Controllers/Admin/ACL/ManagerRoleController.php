<?php

namespace App\Http\Controllers\Admin\ACL;

use Exception;
use Throwable;
use ErrorException;
use Illuminate\Http\Request;
use App\Models\Admin\ACL\Role;
use App\Models\Admin\User\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ACL\UpdateManagerRolesRequest;

class ManagerRoleController extends Controller
{
    public function editRole(User $admin)
    {
        $roles = Role::all();
        return view('admin.user.manager.edit-role', compact('admin', 'roles'));
    }

    public function updateRole(UpdateManagerRolesRequest $request, User $admin)
    {
        try {
            $admin->update(['role_id' => $request->role_id]);
            return to_route('admin.manager.index')->with('swal-success', 'نقش با موفقیت ویرایش شد');
        } catch (Throwable $e) {
            return redirect()->back()->with('swal-error', 'در ویراش نقش خطایی رخ داد. دوباره امتحان کنید');
        }
    }
}
