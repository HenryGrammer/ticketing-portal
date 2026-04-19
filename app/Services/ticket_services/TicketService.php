<?php
namespace App\Services\ticket_services;

use App\Helper\HelperClass;
use App\Ticket;
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
            ->select(DB::raw("LPAD(id, 5, '0') as ticket_id"),DB::raw("DATE(created_at) as date_created"),"subject",DB::raw("IFNULL(priority, 'No data') as priority"),"assigned_to","status", "id");

        return HelperClass::dataTable($columns,$tickets,$request);
    }

    public function assignData($request) {
        $columns = ["id","created_at","subject","priority","assigned_to","status"];

        $tickets = Ticket::with("assignTo")
            ->select(DB::raw("LPAD(id, 5, '0') as ticket_id"),DB::raw("DATE(created_at) as date_created"),"subject",DB::raw("IFNULL(priority, 'No data') as priority"),"assigned_to","status", "id")
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
}