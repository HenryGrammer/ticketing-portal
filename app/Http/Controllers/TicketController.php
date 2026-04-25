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
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\Helper;

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
    public function itPersonnel() {
        try {
            $it_personnels = $this->tickets->itPersonnel();

            return response()->json($it_personnels);
        } catch (\Throwable $e) {
            return HelperClass::errorResponse();
        }
    }

    public function priority() {
        try {
            $priorities = $this->tickets->priority();

            return response()->json($priorities);
        } catch (\Throwable $e) {
            return HelperClass::errorResponse();
        }
    }

    public function category() {
        try {
            $categories = $this->tickets->category();

            return response()->json($categories);
        } catch (\Throwable $e) {
            return HelperClass::errorResponse();
        }
    }

    public function update(Request $request, $id)  {
        $request->validate([
            'assigned_to' => ['required', 'exists:users,id'],
            'priority' => ['required'],
            'category' => ['required', 'exists:categories,id']
        ]);

        try {
            $this->tickets->assignTicket($request,$id);

            return HelperClass::successResponse("Succesfully Assigned");
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
        try {
            DB::beginTransaction();
            
            $this->tickets->acknowledgeTicket($request,$id);
            
            DB::commit();
            return HelperClass::successResponse("Successfully Acknowledge");
        } catch (\Throwable $th) {
            DB::rollBack();
            return HelperClass::errorResponse();
        }
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

    public function cancelled(Request $request,$id) {
        try {
            $this->tickets->cancelTicket($request,$id);

            return HelperClass::successResponse("Successfully Cancelled");
        } catch (\Throwable $th) {
            
            return HelperClass::errorResponse();
        }
    }

    public function closeTicket(Request $request,$id) {
        try {
            $this->tickets->closeTicket($request,$id);

            return HelperClass::successResponse("Successfully Saved");
        } catch (\Throwable $e) {
            return HelperClass::errorResponse();
        }
    }
}
