<?php

namespace App\Http\Controllers;

use App\Company;
use App\Department;
use App\Helper\HelperClass;
use App\Http\Requests\DepartmentRequest;
use App\Services\department\DepartmentServices;
use App\User;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $departmentServices;
    public function __construct(DepartmentServices $departmentServices) {
        $this->departmentServices = $departmentServices;
    }

    public function index() {
        return view('departments.index');
    }

    public function list(Request $request) {
        try {
            $departments = $this->departmentServices->getDepartment($request);
            return response()->json($departments);
        } catch (\Throwable $e) {
            return HelperClass::errorResponse();
        }
    }

    public function companyList() {
        try {
            $companies = $this->departmentServices->companyList();

            return response()->json($companies);
        } catch (\Throwable $th) {
            return HelperClass::errorResponse();
        }
    }

    public function userList() {
        try {
            $users = $this->departmentServices->userList();

            return response()->json($users);
        } catch (\Throwable $th) {
            return HelperClass::errorResponse();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request) {
        try {
            $this->departmentServices->storeDepartment($request);

            return HelperClass::successResponse("Successfully Saved");
        } catch (\Throwable $e) {
            return HelperClass::errorResponse();
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
    public function edit($id)
    {
        try {
            $edit_department = $this->departmentServices->editDepartment($id);

            return response()->json($edit_department);
        } catch (\Throwable $e) {
            return HelperClass::errorResponse();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentRequest $request, $id)
    {
        try {
            $this->departmentServices->updateDepartment($request,$id);

            return HelperClass::successResponse("Successfully Updated");
        } catch (\Throwable $e) {
            return HelperClass::errorResponse();
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

    public function active($id)
    {
        try {
            $this->departmentServices->activate($id);

            return HelperClass::successResponse("Successfully Activated");
        } catch (\Throwable $e) {
            return HelperClass::errorResponse();
        }
    }

    public function deactive($id)
    {
        try {
            $this->departmentServices->deactivate($id);

            return HelperClass::successResponse("Successfully Deactivated");
        } catch (\Throwable $e) {
            return HelperClass::errorResponse();
        }
    }
}
