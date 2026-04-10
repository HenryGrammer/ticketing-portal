<?php

namespace App\Http\Controllers;

use App\Company;
use App\Department;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UserRequest;
use App\Role;
use App\Services\users\UserServices;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $userServices;
    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
    }

    public function index()
    {
        return view('users.index');
    }

    public function company() {
        $companies = $this->userServices->companies();

        return response()->json($companies);
    }

    public function department() {
        $departments = $this->userServices->department();

        return response()->json($departments);
    }

    public function role() {
        $roles = $this->userServices->role();

        return response()->json($roles);
    }

    public function list(Request $request) {
        try {
            $users = $this->userServices->getUsers($request);

            return response()->json($users, 200);
        } catch (\Throwable $e) {
            
            return response()->json(['status' => 'error', 'message' => 'User list not found'], 500);
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
    public function store(UserRequest $request) {
        try {
            $this->userServices->storeUsers($request);

            return response()->json(['status' => 'success', 'message' => 'Successfully Saved']);
        } catch (\Throwable $e) {

            return response()->json(['status' => 'error', 'errors' => $e->getMessage(), 'message' => 'Something went wrong']);
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
    public function edit($id) {
        try {
            $users = $this->userServices->editUser($id);

            return response()->json($users);
        } catch (\Throwable $e) {

            return response()->json(['status' => 'error', 'message' => 'User not found']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id) {
        try {
            $this->userServices->updateUsers($request,$id);

            return response()->json(['status' => 'success', 'message' => 'Successfully Updated']);
        } catch (\Throwable $e) {

            return response()->json(['status' => 'error', 'errors' => $e->getMessage()]);
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
            $this->userServices->deactivateUser($id);

            return response()->json(['status' => 'success', 'message' => 'Successfully Deactivated']);
        } catch (\Throwable $e) {

            return response()->json(['status' => 'error', 'errors' => $e->getMessage(), 'message' => 'Something went wrong']);
        }
    }

    public function active($id)
    {
        try {
            $this->userServices->activateUser($id);

            return response()->json(['status' => 'success', 'message' => 'Successfully Activated']);
        } catch (\Throwable $e) {

            return response()->json(['status' => 'error', 'errors' => $e->getMessage(), 'message' => 'Something went wrong']);
        }
    }

    public function password(PasswordRequest $request, $id)
    {
        // dd($request->all()); 
        // $user = User::findOrFail($id);
        // $user->password = $request->password;
        // $user->save();

        // toastr()->success('Successfully changed password');
        // return back();

    }
}
