<?php

namespace App\Http\Controllers;

use App\Category;
use App\Helper\HelperClass;
use App\Http\Requests\TicketRequest;
use App\Services\ticket_services\TicketService;
use App\Ticket;
use App\Ticketing;
use App\TicketingComment;
use App\TicketingThread;
use App\TicketingType;
use App\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $tickets;
    public function __construct(TicketService $tickets) {
        $this->tickets = $tickets;
    }

    public function index() {
        return view('tickets.index');
    }

    public function data(Request $request) {
        try {
            $tickets = $this->tickets->getTicket($request);

            return response()->json($tickets);
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
    public function store(TicketRequest $request)
    {
        try {
            $this->tickets->storeTicket($request);

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
    public function show($id) {
        $ticket = Ticket::with('department','assignTo','createdBy', 'ticketing_thread.user')->findOrFail($id);

        return view('tickets.view',
            array(
                'ticket' => $ticket
            )
        );
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'assigned_to' => ['required', 'exists:users,id'],
            'priority' => ['required'],
            'category' => ['required', 'exists:categories,id']
        ]);

        $tickets = Ticket::findOrFail($id);
        $tickets->assigned_to = $request->assigned_to;
        $tickets->priority = $request->priority;
        $tickets->category_id = $request->category;
        $tickets->date_assign = date('Y-m-d');
        $tickets->assign_by = auth()->user()->id;
        $tickets->save();

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

    public function list() {
        return view("tickets.list");
    }

    public function listData(Request $request) {
        try {
            $tickets = $this->tickets->listData($request);

            return response()->json($tickets);
        } catch (\Throwable $e) {
            return HelperClass::errorResponse();
        }
    }

    public function assign(Request $request) {
        return view('tickets.assign');
    }

    public function assignData(Request $request) {
        try {
            $tickets = $this->tickets->assignData($request);

            return response()->json($tickets);
        } catch (\Throwable $e) {
            // dd($e->getMessage());
            return HelperClass::errorResponse();
        }
    }

    public function acknowledgement(Request $request,$id)
    {
        // dd($request->all());
        $ticket = Ticket::findOrFail($id);
        $ticketing_type = TicketingType::where('name', $request->ticketing_type)->first();
        $ticketing_comment = TicketingComment::where('ticketing_type_id', $ticketing_type->id)->first();
        
        $thread = new TicketingThread;
        $thread->ticket_id = $ticket->id;
        $thread->comment = $ticketing_comment->information;
        $thread->user_id = auth()->user()->id;
        $thread->save();

        toastr()->success('Successfully Saved');
        return back();
    }

    public function comment(Request $request) {
        try {
            $comments = $this->tickets->getComment($request);

            return response()->json($comments);
        } catch (\Throwable $e) {
            return HelperClass::errorResponse();
        }
    }

    public function storeComment(Request $request, $id) {
        $request->validate([
            'comment' => 'required|string'
        ]);

        try {
            $this->tickets->storeComment($request,$id);

            return HelperClass::successResponse("Successfully Commented");
        } catch (\Throwable $th) {
            return HelperClass::errorResponse();
        }
    }

    public function editComment($id) {
        try {
            $comments = $this->tickets->editComment($id);

            return response()->json($comments);
        } catch (\Throwable $e) {
            return HelperClass::errorResponse();
        }
    }
    public function updateComment(Request $request,$id) {
        try {
            $this->tickets->updateComment($request,$id);

            return HelperClass::successResponse("Successfully Updated");
        } catch (\Throwable $e) {
            return HelperClass::errorResponse();
        }
    }

    public function deleteComment($id) {
        try {
            $this->tickets->deleteComment($id);

            return HelperClass::successResponse("Successfully Deleted");
        } catch (\Throwable $th) {
            
            return HelperClass::errorResponse();
        }
    }

    public function closeTicket(Request $request,$id)
    {
        // dd($request->all(), $id);
        $request->validate([
            'proof' => ['required', 'max:2048']
        ]);

        $ticket = Ticket::findOrFail($id);
        if ($request->hasFile('proof'))
        {
            $file = $request->file('proof');
            $name = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('proof'),$name);
            $ticket->proof = '/proof/'.$name;
        }
        $ticket->status = 'Closed';
        $ticket->date_closed = date('Y-m-d');
        $ticket->save();

        $ticketing_type = TicketingType::where('name', $request->ticketing_type)->first();
        $ticketing_comment = TicketingComment::where('ticketing_type_id', $ticketing_type->id)->first();
        
        $thread = new TicketingThread;
        $thread->ticket_id = $ticket->id;
        $thread->comment = $ticketing_comment->information;
        $thread->user_id = auth()->user()->id;
        $thread->save();

        toastr()->success('Successfully Closed');
        return back();
    }
}
