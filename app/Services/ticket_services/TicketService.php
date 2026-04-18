<?php
namespace App\Services\ticket_services;

use App\Helper\HelperClass;
use App\Ticket;
use Illuminate\Support\Facades\DB;

class TicketService {

    public function getTicket($request) {
        $columns = ["id","created_at","subject","priority","assigned_to","status"];

        $tickets = Ticket::with("assignTo")
            ->select(DB::raw("LPAD(id, 5, '0') as ticket_id"),DB::raw("DATE(created_at) as date_created"),"subject",DB::raw("IFNULL(priority, 'No data') as priority"),"assigned_to","status", "id");

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
}