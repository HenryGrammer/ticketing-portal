<?php

namespace App\Http\Controllers;

use App\Helper\HelperClass;
use App\Http\Requests\TicketingTypeRequest;
use App\Services\ticketing_types\TicketingTypeService;
use App\TicketingType;
use Illuminate\Http\Request;

class TicketingTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $ticketingType;
    public function __construct(TicketingTypeService $ticketingType) {
        $this->ticketingType = $ticketingType;
    }

    public function index() {
        return view('ticketing_types.index');
    }

    public function list(Request $request) {
        try {
            $ticketing_types = $this->ticketingType->getTicketingTypes($request);

            return response()->json($ticketing_types, 200);
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
    public function store(TicketingTypeRequest $request)
    {
        try {
            $this->ticketingType->storeTicketingType($request);

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
            $ticketing_types = $this->ticketingType->editTicketingType($id);

            return response()->json($ticketing_types, 200);
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
    public function update(TicketingTypeRequest $request, $id)
    {
        try {
            $this->ticketingType->updateTicketingType($request,$id);

            return HelperClass::successResponse("Successfully Saved");
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

    public function deactive($id) {
        try {
            $this->ticketingType->deactivate($id);

            return HelperClass::successResponse("Successfully Deactivated");
        } catch (\Throwable $e) {
            return HelperClass::errorResponse();
        }
    }

    public function active($id) {
        try {
            $this->ticketingType->activate($id);

            return HelperClass::successResponse("Successfully Activated");
        } catch (\Throwable $e) {
            return HelperClass::errorResponse();
        }
    }
}
