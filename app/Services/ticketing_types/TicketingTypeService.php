<?php 
namespace App\Services\ticketing_types;

use App\Helper\HelperClass;
use App\TicketingType;
use Illuminate\Support\Facades\DB;

class TicketingTypeService {
    
    public function getTicketingTypes($request) {
        $columns = ['id', 'name', 'status'];
        $companies = TicketingType::select("id","name", DB::raw("IF(status = 1, 'Active', 'Inactive') AS status"));

        return HelperClass::dataTable($columns,$companies,$request);
    }

    public function storeTicketingType($request) {
        $ticketing_types = new TicketingType;
        $ticketing_types->name = $request->name;
        $ticketing_types->status = 1;
        $ticketing_types->save();

        return $ticketing_types;
    }

    public function editTicketingType($id) {
        $ticketing_types = TicketingType::findOrFail($id);

        return $ticketing_types;
    }

    public function updateTicketingType($request,$id) {
        $ticketing_types = TicketingType::findOrFail($id);
        $ticketing_types->name = $request->name;
        $ticketing_types->save();

        return $ticketing_types;
    }

    public function deactivate($id) {
        $ticketing_types = TicketingType::findOrFail($id);
        $ticketing_types->status = 0;
        $ticketing_types->save();

        return $ticketing_types;
    }

    public function activate($id) {
        $ticketing_types = TicketingType::findOrFail($id);
        $ticketing_types->status = 1;
        $ticketing_types->save();

        return $ticketing_types;
    }
}