<?php

namespace App\Http\Controllers;

use App\Company;
use App\Department;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('company', 'department')->get();

        $companies = Company::where('status', 'Active')->get();
        $departments = Department::where('status', 'Active')->get();

        return view(
            'users.index',
            array(
                'users' => $users,
                'companies' => $companies,
                'departments' => $departments
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
    public function store(UserRequest $request)
    {
        // dd($request->all());
        $user = new User;
        $user->company_id = $request->company;
        $user->department_id = $request->department;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->roles;
        $user->password = bcrypt('wgroup123');
        $user->status = 'Active';
        $user->save();

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
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->company_id = $request->company;
        $user->department_id = $request->department;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->roles;
        $user->save();

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
        $user = User::findOrFail($id);
        $user->status = 'Inactive';
        $user->save();

        toastr()->success('Successfully Deactivated');
        return back();
    }

    public function active($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'Active';
        $user->save();

        toastr()->success('Successfully Activated');
        return back();
    }

    public function password(PasswordRequest $request, $id)
    {
        // dd($request->all()); 
        $user = User::findOrFail($id);
        $user->password = $request->password;
        $user->save();

        toastr()->success('Successfully changed password');
        return back();

    }
}
