<?php

namespace App\Http\Controllers;

use App\AccessModule;
use App\Http\Requests\RoleRequest;
use App\Module;
use App\Role;
use App\Services\role\RoleService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $roleServices;
    public function __construct(RoleService $roleServices) {
        $this->roleServices = $roleServices;
    }

    public function index() {
        return view('roles.index');
    }

    public function list(Request $request) {
        try {
            $users = $this->roleServices->getRole($request);

            return response()->json($users, 200);
        } catch (\Throwable $e) {
            return response()->json(['status' => 'error', 'message' => 'Role list not found'], 500);
        }
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
        try {
            $this->roleServices->storeRole($request);

            return response()->json(['message' => 'Successfully Saved', 'status' => 'success']);
        } catch (\Throwable $e) {

            return response()->json(['message' => $e->getMessage(), 'status' => 'error']);
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
        try {
            $roles = $this->roleServices->editRole($id);

            return response()->json($roles);
        } catch (\Throwable $e) {

            return response()->json(['message' => $e->getMessage(), 'status' => 'error']);
        }
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
        try {
            $this->roleServices->updateRole($request,$id);

            return response()->json(['message' => 'Successfully Updated', 'status' => 'success']);
        } catch (\Throwable $e) {

            return response()->json(['message' => $e->getMessage(), 'status' => 'error']);
        }
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
        try {
            $this->roleServices->deactivate($id);

            return response()->json(['message' => 'Successfully Deactivated', 'status' => 'success']);
        } catch (\Throwable $e) {

            return response()->json(['message' => $e->getMessage(), 'status' => 'error']);
        }
    }

    public function active($id)
    {
        try {
            $this->roleServices->activate($id);

            return response()->json(['message' => 'Successfully Activated', 'status' => 'success']);
        } catch (\Throwable $e) {

            return response()->json(['message' => $e->getMessage(), 'status' => 'error']);
        }
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
