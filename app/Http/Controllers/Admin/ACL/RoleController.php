<?php

namespace App\Http\Controllers\Admin\ACL;

use Illuminate\Http\Request;
use App\Models\Admin\ACL\Role;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Admin\ACL\Permission;
use Database\Seeders\PermissionsSeeder;
use App\Http\Requests\Admin\ACL\RoleRequest;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Permission::exists()) {
            $default = new PermissionsSeeder;
            $default->run();
        }
        $roles = Role::orderByDesc('id')->get();
        return view('admin.user.ACL.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.user.ACL.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $inputs = $request->validated();
        $flag = DB::transaction(function () use ($inputs) {
            $role = Role::create($inputs);
            $inputs['permission'] = $inputs['permission'] ?? [];
            $role->permissions()->sync($inputs['permission']);
            return true;
        });
        return endTransaction($flag, 'admin.role.index', 'نقش جدید با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();

        return view('admin.user.ACL.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        $inputs = $request->all();
        $flag = DB::transaction(function () use ($inputs, $role) {
            $role->update($inputs);
            $inputs['permission'] = $inputs['permission'] ?? [];
            $role->permissions()->sync($inputs['permission']);
            return true;
        });
        return endTransaction($flag, 'admin.role.index', 'نقش با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.role.index')->with('swal-success', 'نقش با موفقیت حذف گردید');
    }


}
