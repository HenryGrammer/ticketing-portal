<?php

namespace App\Http\Controllers;

use App\AccessModule;
use App\Http\Requests\RoleRequest;
use App\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::get();

        return view('roles.index',
            array(
                'roles' => $roles
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $roles = new Role;
        $roles->name = $request->name;
        $roles->code = $request->code;
        $roles->status = 'Active';
        $roles->save();

        toastr()->success('Successfully Saved');
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::findOrFail($id);

        return view('roles.access',
            array(
                'role' => $role
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        $roles = Role::findOrFail($id);
        $roles->name = $request->name;
        $roles->code = $request->code;
        $roles->save();

        toastr()->success('Successfully Updated');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function deactive($id)
    {
        $roles = Role::findOrFail($id);
        $roles->status = 'Inactive';
        $roles->save();

        toastr()->success('Successfully Deactivated');
        return back();
    }

    public function active($id)
    {
        $roles = Role::findOrFail($id);
        $roles->status = 'Active';
        $roles->save();

        toastr()->success('Successfully Activated');
        return back();
    }

    public function storeAccess(Request $request)
    {
        $access = AccessModule::where('role_id', $request->role_id)->delete();
        foreach($request->permissions as $permission)
        {
            $access = new AccessModule;
            $access->role_id = $request->role_id;
            $access->permissions = $permission;
            $access->save();
        }

        toastr()->success('Successfully Saved');
        return back();
    }
}
