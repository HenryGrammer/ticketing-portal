<?php
namespace App\Services\ticket_services;

use App\Helper\HelperClass;
use App\Ticket;
use App\TicketingComment;
use App\TicketingThread;
use Illuminate\Support\Facades\DB;

class TicketService {

    public function getTicket($request) {
        $columns = ["id","created_at","subject","priority","assigned_to","status"];

        $tickets = Ticket::with("assignTo")
            ->select(DB::raw("LPAD(id, 5, '0') as ticket_id"),DB::raw("DATE(created_at) as date_created"),"subject",DB::raw("IFNULL(priority, 'No data') as priority"),"assigned_to","status", "id")
            ->where("created_by", auth()->id());

        return HelperClass::dataTable($columns,$tickets,$request);
    }

    public function listData($request) {
        $columns = ["id","created_at","subject","priority","assigned_to","status"];

        $tickets = Ticket::with("assignTo")
            ->select(
                DB::raw("LPAD(id, 5, '0') as ticket_id"),
                DB::raw("DATE(created_at) as date_created"),
                "subject",
                DB::raw("
                    CASE
                        WHEN priority = 1 THEN 'High'
                        WHEN priority = 2 THEN 'Medium'
                        WHEN priority = 3 THEN 'Low'
                    END as priority
                "),
                "assigned_to",
                "status", 
                "id"
            );

        return HelperClass::dataTable($columns,$tickets,$request);
    }

    public function assignData($request) {
        $columns = ["id","created_at","subject","priority","assigned_to","status"];

        $tickets = Ticket::with("assignTo")
            ->select(
                DB::raw("LPAD(id, 5, '0') as ticket_id"),
                DB::raw("DATE(created_at) as date_created"),
                "subject",
                DB::raw("IFNULL(priority, 'No data') as priority"),
                "assigned_to",
                "status", 
                "id"
            )
            ->where("assigned_to", auth()->id());

        return HelperClass::dataTable($columns,$tickets,$request);
    }

    public function storeTicket($request) {
        $tickets = new Ticket();
        $tickets->viber_number = $request->viber_number;
        $tickets->department_id = $request->department;
        $tickets->subject = $request->title;
        $tickets->task = $request->task;
        $tickets->status = 'Open';
        $tickets->created_by = auth()->user()->id;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time().'-'.$file->getClientOriginalName();
            $file->move(public_path('attachment'),$filename);
            $fileName = '/attachment/'.$filename;

            $tickets->attachment = $fileName;
        }
        $tickets->save();

        return $tickets;
    }

    public function getComment($request) {
        $comments = TicketingThread::with("user")
            ->select(
                "ticket_id", 
                "comment", 
                "id", 
                "user_id",
                DB::raw("
                    CASE 
                        WHEN TIMESTAMPDIFF(SECOND, created_at, NOW()) < 60 THEN 'Just now'
                        WHEN TIMESTAMPDIFF(MINUTE, created_at, NOW()) < 60 THEN CONCAT(TIMESTAMPDIFF(MINUTE, created_at, NOW()), ' minutes ago')
                        WHEN TIMESTAMPDIFF(HOUR, created_at, NOW()) < 24 THEN CONCAT(TIMESTAMPDIFF(HOUR, created_at, NOW()), ' hours ago')
                        ELSE CONCAT(TIMESTAMPDIFF(DAY, created_at, NOW()), ' days ago')
                    END AS createdAt
                ")
            )
            ->where("ticket_id", $request->id)
            ->get();

        return $comments;
    }

    public function storeComment($request,$id) {
        $thread = new TicketingThread;
        $thread->ticket_id = $id;
        $thread->comment = $request->comment;
        $thread->user_id = auth()->user()->id;
        $thread->save();

        return $thread;
    }

    public function editComment($id) {
        $thread = TicketingThread::findOrFail($id);

        return $thread;
    }

    public function updateComment($request,$id) {
        $thread = TicketingThread::findOrFail($id);
        $thread->comment = $request->editComment;
        $thread->user_id = auth()->user()->id;
        $thread->save();

        return $thread;
    }

    public function deleteComment($id) {
        $thread = TicketingThread::findOrFail($id);
        $thread->delete();
        
        return $thread;
    }

    public function itPersonnel() {
        return HelperClass::getItPersonnel();
    }

    public function priority() {
        return HelperClass::priority();
    }

    public function category() {
        return HelperClass::getCategory();
    }

    public function assignTicket($request,$id) {
        $tickets = $this->getTicketData($id);
        $tickets->assigned_to = $request->assigned_to;
        $tickets->priority = $request->priority;
        $tickets->category_id = $request->category;
        $tickets->date_assign = date('Y-m-d');
        $tickets->assign_by = auth()->user()->id;
        $tickets->save();

        return $tickets;
    }

    public function acknowledgeTicket($request,$id) {
        $ticket = $this->getTicketData($id);
        $ticket->status = "Acknowledge";
        $ticket->save();

        $this->ticketingThreadActivity($request,$id);

        return $ticket;
    }

    public function getTicketData($id) {
        $thread = Ticket::findOrFail($id);

        return $thread;
    }

    public function ticketingComment($ticketingType) {
        $ticketing_comment = TicketingComment::where('ticketing_type_id', $ticketingType)->first();

        return $ticketing_comment->information;
    }

    public function cancelTicket($request, $id) {
        $ticket = $this->getTicketData($id);
        $ticket->status = "Cancelled";
        $ticket->save();

        $this->ticketingThreadActivity($request,$id);

        return $ticket;
    }

    public function ticketingThreadActivity($request,$id) {
        $thread = new TicketingThread;
        $thread->ticket_id = $id;
        $thread->comment = $this->ticketingComment($request->ticketing_type);
        $thread->user_id = auth()->user()->id;
        $thread->save();
    }

    public function closeTicket($request,$id) {
        $ticket = $this->getTicketData($id);
        $ticket->status = 'Closed';
        $ticket->date_closed = date('Y-m-d');
        $ticket->save();

        $this->ticketingThreadActivity($request,$id);

        return $ticket;
    }
}