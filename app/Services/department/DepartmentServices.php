<?php 
namespace App\Services\department;

use App\Department;
use App\Helper\HelperClass;
use Illuminate\Support\Facades\DB;

class DepartmentServices {
    public function getDepartment($request) {
        $columns = ['id', 'code', 'name', 'status', 'company_id'];
        $departments = Department::with([
                'user' => function($q) {
                    $q->select('id','name')->where("status", 1);
                },
                'company' => function($q) {
                    $q->select('id', 'name')->where("status",1);
                }
            ])
            ->select("id","code","name", DB::raw("IF(status = 1, 'Active', 'Inactive') AS status"), 'user_id','company_id');

        return HelperClass::dataTable($columns,$departments,$request);
    }

    public function storeDepartment($request) {
        $department = new Department();
        $department->company_id = $request->company;
        $department->user_id = $request->user;
        $department->name = $request->name;
        $department->code = $request->code;
        $department->status = 1;
        $department->save();

        return $department;
    }

    public function editDepartment($id) {
        $department = Department::findOrFail($id);

        return $department;
    }

    public function updateDepartment($request,$id) {
        $department = Department::findOrFail($id);
        $department->company_id = $request->company;
        $department->user_id = $request->user;
        $department->name = $request->name;
        $department->code = $request->code;
        $department->status = 1;
        $department->save();


        return $department;
    }

    public function deactivate($id) {
        $department = Department::findOrFail($id);
        $department->status = 0;
        $department->save();

        return $department;
    }

    public function activate($id) {
        $department = Department::findOrFail($id);
        $department->status = 1;
        $department->save();

        return $department;
    }

    public function companyList() {
        return HelperClass::getActiveCompany();
    }

    public function userList() {
        return HelperClass::getActiveUsers();
    }
}