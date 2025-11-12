<?php

namespace App\Http\Controllers;

use App\Category;
use App\Ticket;
use App\User;
use Illuminate\Http\Request;
use stdClass;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // dd($request->all());
        $months=[];
        for($m=1; $m<=12; $m++) {
            if(auth()->user()->role->name == "Administrator")
            {
                $tickets = Ticket::whereYear('created_at',date('Y'))->whereMonth('created_at', date('m', mktime(0,0,0,$m,1,date('Y'))))->count();
            }
            elseif(in_array(auth()->user()->role->name, ["IT Head", "IT Staff"]))
            {
                $tickets = Ticket::whereYear('created_at',date('Y'))->whereMonth('created_at', date('m', mktime(0,0,0,$m,1,date('Y'))))->where('assign_by', auth()->user()->id)->count();
            }
            elseif(auth()->user()->role->name == "User")
            {
                $tickets = Ticket::whereYear('created_at',date('Y'))->whereMonth('created_at', date('m', mktime(0,0,0,$m,1,date('Y'))))->where('created_by', auth()->user()->id)->count();
            }
            
            $object = new stdClass;
            $object->month = date('M-Y', mktime(0,0,0,$m,1,date('Y')));
            $object->tickets = $tickets;
            $months[] = $object;
        }

        $categoryArray = [];
        $categories = Category::where('status','Active')->get();
        foreach($categories as $category)
        {
            $tickets = Ticket::where('category_id', $category->id)->whereYear('created_at', date('Y'))->count();
            $object = new stdClass;
            $object->name = $category->name;
            $object->count = $tickets;
            $categoryArray[] = $object;
        }

        $it_personnels = User::where('department_id',1)->where('status','Active')->get();
        if (in_array(auth()->user()->role->name, ["Administrator", "IT Head"]))
        {
            $tickets_per_personnel = Ticket::with('assignTo','createdBy')->whereYear('created_at', date('Y', strtotime($request->month)))->whereMonth('created_at', date('m', strtotime($request->month)))->where('assigned_to', $request->personnel)->where('status','Closed')->get();
        }
        elseif(auth()->user()->role->name == "IT Staff")
        {
            $tickets_per_personnel = Ticket::with('assignTo','createdBy')->whereYear('created_at', date('Y', strtotime($request->month)))->whereMonth('created_at', date('m', strtotime($request->month)))->where('assigned_to', auth()->user()->id)->where('status','Closed')->get();
        }
        elseif (auth()->user()->role->name == "User") 
        {
            $tickets_per_personnel = Ticket::with('assignTo','createdBy')->whereYear('created_at', date('Y'))->where('created_by', auth()->user()->id)->get();
        }
        // $tickets = Ticket
        
        return view('home',
            array(
                'months' => $months,
                'categoryArray' => $categoryArray,
                'it_personnels' => $it_personnels,
                'month_data' => $request->month,
                'personnel_data' => $request->personnel,
                'tickets_per_personnel' => $tickets_per_personnel
            )
        );
    }
}
