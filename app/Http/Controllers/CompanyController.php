<?php

namespace App\Http\Controllers;

use App\Company;
use App\Http\Requests\CompanyRequest;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::get();

        return view('companies.index', 
            array(
                'companies' => $companies
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
    public function store(CompanyRequest $request)
    {
        $companies = new Company;
        $companies->code = $request->code;
        $companies->name = $request->name;
        $companies->status = 'Active';
        $companies->save();

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
    public function update(CompanyRequest $request, $id)
    {
        $companies = Company::findOrFail($id);
        $companies->code = $request->code;
        $companies->name = $request->name;
        $companies->save();

        toastr()->success('Successfully Saved');
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
        $companies = Company::findOrFail($id);
        $companies->status = 'Active';
        $companies->save();

        toastr()->success('Successfully Activated');
        return back();
    }

    public function deactive($id)
    {
        $companies = Company::findOrFail($id);
        $companies->status = 'Inactive';
        $companies->save();

        toastr()->success('Successfully Deactivated');
        return back();
    }
}
