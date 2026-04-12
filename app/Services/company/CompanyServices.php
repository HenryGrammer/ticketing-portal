<?php 
namespace App\Services\company;

use App\Company;
use App\Helper\HelperClass;
use Illuminate\Support\Facades\DB;

class CompanyServices {
    public function getCompany($request) {
        $columns = ['id', 'code', 'name', 'status'];
        $users = Company::select("id","code","name", DB::raw("IF(status = 1, 'Active', 'Inactive') AS status"));

        return HelperClass::dataTable($columns,$users,$request);
    }

    public function storeCompany($request) {
        $company = new Company();
        $company->name = $request->name;
        $company->code = $request->code;
        $company->status = 1;
        $company->save();

        return $company;
    }

    public function editCompany($id) {
        $company = Company::findOrFail($id);

        return $company;
    }

    public function updateCompany($request,$id) {
        $company = Company::findOrFail($id);
        $company->name = $request->name;
        $company->code = $request->code;
        $company->save();

        return $company;
    }

    public function deactivate($id) {
        $company = Company::findOrFail($id);
        $company->status = 0;
        $company->save();

        return $company;
    }

    public function activate($id) {
        $company = Company::findOrFail($id);
        $company->status = 1;
        $company->save();

        return $company;
    }
}