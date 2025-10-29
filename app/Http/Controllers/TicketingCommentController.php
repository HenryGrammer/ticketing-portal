<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketingCommentRequest;
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
    public function index()
    {
        $ticketing_comments = TicketingComment::with('ticketing_type')->get();
        $ticketing_types = TicketingType::where('status','Active')->get();
        
        return view('ticketing_comments.index',
            array(
                'ticketing_comments' => $ticketing_comments,
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
    public function store(TicketingCommentRequest $request)
    {
        // dd($request->all());
        $ticketing_comments = new TicketingComment;
        $ticketing_comments->ticketing_type_id = $request->type;
        $ticketing_comments->information = $request->info;
        $ticketing_comments->status = 'Active';
        $ticketing_comments->save();

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
    public function update(TicketingCommentRequest $request, $id)
    {
        $ticketing_comments = TicketingComment::findOrFail($id);
        $ticketing_comments->ticketing_type_id = $request->type;
        $ticketing_comments->information = $request->info;
        $ticketing_comments->save();

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
        $ticketing_comments = TicketingComment::findOrFail($id);
        $ticketing_comments->status = 'Inactive';
        $ticketing_comments->save();

        toastr()->success('Successfully Deactivated');
        return back();
    }

    public function active($id)
    {
        $ticketing_comments = TicketingComment::findOrFail($id);
        $ticketing_comments->status = 'Active';
        $ticketing_comments->save();

        toastr()->success('Successfully Activated');
        return back();
    }
}
