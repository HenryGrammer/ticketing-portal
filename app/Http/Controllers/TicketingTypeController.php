<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketingTypeRequest;
use App\TicketingType;
use Illuminate\Http\Request;

class TicketingTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ticketing_types = TicketingType::get();

        return view('ticketing_types.index',
            array(
                'ticketing_types' => $ticketing_types
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
    public function store(TicketingTypeRequest $request)
    {
        $ticketing_types = new TicketingType;
        $ticketing_types->name = $request->name;
        $ticketing_types->status = 'Active';
        $ticketing_types->save();

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
    public function update(TicketingTypeRequest $request, $id)
    {
        // dd($request->all());
        $ticketing_types = TicketingType::findOrFail($id);
        $ticketing_types->name = $request->name;
        $ticketing_types->save();

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
        $ticketing_types = TicketingType::findOrFail($id);
        $ticketing_types->status = 'Inactive';
        $ticketing_types->save();

        toastr()->success('Successfully Deactivated');
        return back();
    }

    public function active($id)
    {
        $ticketing_types = TicketingType::findOrFail($id);
        $ticketing_types->status = 'Active';
        $ticketing_types->save();

        toastr()->success('Successfully Activated');
        return back();
    }
}
