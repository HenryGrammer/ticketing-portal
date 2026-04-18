<?php

namespace App\Http\Controllers;

use App\Helper\HelperClass;
use App\Http\Requests\TicketingCommentRequest;
use App\Services\ticketing_comments\TicketingCommentService;
use App\TicketingComment;
use App\TicketingType;
use Illuminate\Http\Request;

class TicketingCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $ticketingComment;
    public function __construct(TicketingCommentService $ticketingComment) {
        $this->ticketingComment = $ticketingComment;
    }

    public function index() {
        return view('ticketing_comments.index');
    }

    public function list(Request $request) {
        try {
            $ticketing_comments = $this->ticketingComment->getTicketingComment($request);

            return response()->json($ticketing_comments, 200);
        } catch (\Throwable $e) {
            return HelperClass::errorResponse();
        }
    }

    public function ticketingType() {
        try {
            $ticketing_types = $this->ticketingComment->ticketingType();
            
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
    public function store(TicketingCommentRequest $request)
    {
        try {
            $this->ticketingComment->storeTicketingComment($request);

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
            $ticketing_comment = $this->ticketingComment->editTicketingComment($id);

            return response()->json($ticketing_comment, 200);
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
    public function update(TicketingCommentRequest $request, $id)
    {
        try {
            $this->ticketingComment->updateTicketingComment($request,$id);

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
            $this->ticketingComment->deactive($id);

            return HelperClass::successResponse("Successfully Deactivated");
        } catch (\Throwable $e) {
            return HelperClass::errorResponse();
        }
    }

    public function active($id)
    {
        try {
            $this->ticketingComment->active($id);

            return HelperClass::successResponse("Successfully Activated");
        } catch (\Throwable $e) {
            return HelperClass::errorResponse();
        }
    }
}
