<?php 
namespace App\Services\role;

use App\Helper\HelperClass;
use App\Role;
use Illuminate\Support\Facades\DB;

class RoleService {
    public function getRole($request) {
        $columns = ['id', 'code', 'name', 'status'];
        $roles = Role::select("id","code","name", DB::raw("IF(status = 1, 'Active', 'Inactive') AS status"));

        return HelperClass::dataTable($columns,$roles,$request);
    }

    public function storeRole($request) {
        $roles = new Role;
        $roles->name = $request->name;
        $roles->code = $request->code;
        $roles->status = 1;
        $roles->save();

        return $roles;
    }

    public function editRole($id) {
        $role = Role::findOrFail($id);

        return $role;
    }

    public function updateRole($request,$id) {
        $roles = Role::findOrFail($id);
        $roles->name = $request->name;
        $roles->code = $request->code;
        $roles->save();

        return $roles;
    }

    public function deactivate($id) {
        $role = Role::findOrFail($id);
        $role->status = 0;
        $role->save();

        return $role;
    }

    public function activate($id) {
        $role = Role::findOrFail($id);
        $role->status = 1;
        $role->save();

        return $role;
    }
}