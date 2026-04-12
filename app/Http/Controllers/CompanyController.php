<?php

namespace App\Http\Controllers;

use App\Company;
use App\Helper\HelperClass;
use App\Http\Requests\CompanyRequest;
use App\Services\company\CompanyServices;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $companyServices;
    public function __construct(CompanyServices $companyServices) {
        $this->companyServices = $companyServices;
    }

    public function index() {
        return view('companies.index');
    }

    public function list(Request $request) {
        try {
            $companies = $this->companyServices->getCompany($request);

            return response()->json($companies, 200);
        } catch (\Throwable $e) {
            return HelperClass::errorResponse();
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
    public function store(CompanyRequest $request)
    {
        try {
            $this->companyServices->storeCompany($request);

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
            $users = $this->companyServices->editCompany($id);

            return response()->json($users);
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
    public function update(CompanyRequest $request, $id)
    {
        try {
            $this->companyServices->updateCompany($request,$id);

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

    public function deactive($id)
    {
        try {
            $this->companyServices->deactivate($id);

            return HelperClass::successResponse("Successfully Deactivated");
        } catch (\Throwable $e) {

            return HelperClass::errorResponse();
        }
    }

    public function active($id)
    {
        try {
            $this->companyServices->activate($id);

            return HelperClass::successResponse("Successfully Activated");
        } catch (\Throwable $e) {
            
            return HelperClass::errorResponse();
        }
    }
}
