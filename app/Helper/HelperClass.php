<?php
namespace App\Helper;

use App\Company;
use App\Department;
use App\Module;
use App\Role;

class HelperClass {

    public static function modules() {
        return Module::with([
                        "submodule" => function($q) {
                            $q->where("status", 1)->orderBy("order_by", "asc");
                        }
                    ])
                    ->orderBy("order_by", "asc")
                    ->where("status", 1)
                    ->get();
    }

    public static function dataTable($columns,$query,$request) {
        // Total Records
        $total = $query->count();
        
        // Search
        if ($search = $request->input('search.value')) {
            $query->where(function ($q) use ($search, $columns) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'LIKE', "%{$search}%");
                }
            });
        }

        // Filtered Records
        $filtered = $query->count();

        // Ordering
        if ($request->has('order')) {
            $columnIndex = $request->input('order.0.column');
            $columnName = $columns[$columnIndex];
            $direction = $request->input('order.0.dir');

            $query->orderBy($columnName, $direction);
        }
        
        // Pagination
        $start = $request->input('start');
        $length = $request->input('length');

        $data = $query->skip($start)->take($length)->get();
        
        return [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => $total,
            "recordsFiltered" => $filtered,
            "data" => $data
        ];
    }

    public static function getActiveCompany() {
        $companies = Company::select("name", "code", "status","id")
                        ->where("status",1)
                        ->get();

        return $companies;
    }

    public static function getActiveDepartment() {
        $departments = Department::select("name", "code", "status","id")
                        ->where("status",1)
                        ->get();

        return $departments;
    }

    public static function getActiveRole() {
        $roles = Role::select("name", "code", "status","id")
                        ->where("status",1)
                        ->get();

        return $roles;
    }

    public static function successResponse($message) {
        return response()->json(['status' => 'success', 'message' => $message], 200);
    }

    public static function errorResponse($errorMessage = "Something went wrong") {
        return response()->json(['status' => 'success', 'message' => $errorMessage], 200);
    }
}