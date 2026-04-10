<?php 
namespace App\Services\users;

use App\Helper\HelperClass;
use App\User;
use Illuminate\Support\Facades\DB;

class UserServices {
    public function getUsers($request) {
        $columns = ['name', 'email', 'company_id', 'department_id', 'role_id', 'status'];
            $users = User::with([
                        "company" => function($q) {
                            $q->select("name as Company","id");
                        },
                        'department' => function($q) {
                            $q->select("name as Department", "id");
                        },
                        'role' => function($q) {
                            $q->select("name as Role", "id");
                        }
                    ])
                    ->select("name", "email", "company_id", "department_id", "role_id", DB::raw("IF(status = 1, 'Active', 'Inactive') AS status"),"id");

        return HelperClass::dataTable($columns,$users,$request);
    }

    public function storeUsers($request) {
        $user = new User;
        $user->company_id = $request->company;
        $user->department_id = $request->department;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->roles;
        $user->password = bcrypt('wgroup123');
        $user->status = 1;
        $user->role_id = $request->role;
        $user->save();

        return $user;
    }

    public function editUser($id) {
        $user = User::findOrFail($id);
        
        return $user;
    }

    public function updateUsers($request,$id) {
        $user = User::findOrFail($id);
        $user->company_id = $request->company;
        $user->department_id = $request->department;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role;
        $user->save();

        return $user;
    }

    public function deactivateUser($id) {
        $user = User::findOrFail($id);
        $user->status = 0;
        $user->save();

        return $user;
    }

    public function activateUser($id) {
        $user = User::findOrFail($id);
        $user->status = 1;
        $user->save();

        return $user;
    }

    public function companies() {
        $companies = HelperClass::getActiveCompany();

        return $companies;
    }

    public function department() {
        $departments = HelperClass::getActiveDepartment();

        return $departments;
    }

    public function role() {
        $roles = HelperClass::getActiveRole();

        return $roles;
    }
}