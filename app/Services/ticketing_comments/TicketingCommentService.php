<?php 
namespace App\Services\ticketing_comments;

use App\Helper\HelperClass;
use App\TicketingComment;
use Illuminate\Support\Facades\DB;

class TicketingCommentService {
    public function getTicketingComment($request) {
        $columns = ["id", "ticketing_type_id", "information", "status"];
        $companies = TicketingComment::with([
                "ticketing_type" => function($q) {
                    $q->where("status", 1);
                }
            ])
            ->select("id","ticketing_type_id", "information", DB::raw("IF(status = 1, 'Active', 'Inactive') AS status"));

        return HelperClass::dataTable($columns,$companies,$request);
    }

    public function ticketingType() {
        return HelperClass::getActiveTicketingType();
    }

    public function storeTicketingComment($request) {
        $ticketing_comments = new TicketingComment;
        $ticketing_comments->ticketing_type_id = $request->type;
        $ticketing_comments->information = $request->info;
        $ticketing_comments->status = 1;
        $ticketing_comments->save();

        return $ticketing_comments;
    }

    public function editTicketingComment($id) {
        $ticketing_comment = TicketingComment::findOrFail($id);

        return $ticketing_comment;
    }

    public function updateTicketingComment($request,$id) {
        $ticketing_comments = TicketingComment::findOrFail($id);
        $ticketing_comments->ticketing_type_id = $request->type;
        $ticketing_comments->information = $request->info;
        $ticketing_comments->save();

        return $ticketing_comments;
    }

    public function deactive($id) {
        $ticketing_comments = TicketingComment::findOrFail($id);
        $ticketing_comments->status = 0;
        $ticketing_comments->save();

        return $ticketing_comments;
    }

    public function active($id) {
        $ticketing_comments = TicketingComment::findOrFail($id);
        $ticketing_comments->status = 1;
        $ticketing_comments->save();

        return $ticketing_comments;
    }
}