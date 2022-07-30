<?php

namespace App\Http\Controllers\Admin\ACL;

use Illuminate\Http\Request;
use App\Models\Admin\ACL\Role;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Admin\ACL\Permission;
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

        // $permissions = Permission::all();
        $roles = Role::orderByDesc('id')->get();
        // if ($permissions === null) {
        //     $default = new PermissionSeeder;
        //     $default->run();
        //     $permissions = Permission::first();
        // }
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
        $flag = DB::transaction(function () use ($request) {
            $inputs = $request->all();
            $role = Role::create($inputs);
            $inputs['permission'] = $inputs['permission'] ?? [];
            $role->permissions()->sync($inputs['permission']);
            return true;
        });

        if ($flag) {
            return redirect()->route('admin.role.index')->with('swal-success', 'نقش جدید با موفقیت ثبت شد');
        } else {
            return redirect()->route('admin.role.create')->with('swal-error', 'در ثبت نقش جدید خطایی رخ داد. دوباره امتحان کنید');
        }
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
        if ($flag) {
            return redirect()->route('admin.role.index')->with('swal-success', 'نقش با موفقیت ویرایش شد');
        } else {
            return redirect()->route('admin.role.edit', $role->id)->with('swal-error', 'در ویراش نقش خطایی رخ داد. دوباره امتحان کنید');
        }
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

    public function status(Role $role)
    {
        $role->status = $role->status == 0 ? 1 : 0;
        $result = $role->save();
        if ($result) {
            if ($role->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }
    }
}