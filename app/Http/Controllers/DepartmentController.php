<?php

namespace App\Http\Controllers;

use App\Company;
use App\Department;
use App\Http\Requests\DepartmentRequest;
use App\User;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::with('user','company')->get();
        $companies = Company::get();
        $users = User::where('status','Active')->get();

        return view('departments.index',
            array(
                'departments' => $departments,
                'companies' => $companies,
                'users' => $users
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
    public function store(DepartmentRequest $request)
    {
        $departments = new Department;
        $departments->company_id = $request->company;
        $departments->code = $request->code;
        $departments->name = $request->name;
        $departments->user_id = $request->user;
        $departments->status = 'Active';
        $departments->save();

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
        //
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
        $departments = Department::findOrFail($id);
        $departments->company_id = $request->company;
        $departments->code = $request->code;
        $departments->name = $request->name;
        $departments->user_id = $request->user;
        $departments->save();

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

    public function active($id)
    {
        $companies = Department::findOrFail($id);
        $companies->status = 'Active';
        $companies->save();

        toastr()->success('Successfully Activated');
        return back();
    }

    public function deactive($id)
    {
        $companies = Department::findOrFail($id);
        $companies->status = 'Inactive';
        $companies->save();

        toastr()->success('Successfully Deactivated');
        return back();
    }
}
