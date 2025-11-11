<?php

namespace App\Http\Controllers;

use App\Category;
use App\Ticket;
use Illuminate\Http\Request;
use stdClass;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd($request->all());
        if ($request->week)
        {
            $week = explode('-W', $request->week);
        }
        $categories = Category::get();
        $data=[];
        foreach($categories as $category)
        {
            if ($request->week)
            {
                $tickets = Ticket::whereYear('created_at', $request->week)->whereRaw('WEEK(created_at, 1) = ?', $week[1])->where('category_id',$category->id)->get();
    
                $object = new stdClass;
                $object->category_name = $category->name;
                $object->issues = count($tickets);
                $object->closed = count($tickets->where('status','Closed'));
                $object->ongoing = count($tickets->where('status','Open'));
                $data[] = $object;
            }
            else
            {
                $object = new stdClass;
                $object->category_name = $category->name;
                $object->issues = 0;
                $object->closed = 0;
                $object->ongoing = 0;
                $data[] = $object;
            }
        }
        
        return view('reports.index',
            array(
                'data' => $data
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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
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
}
