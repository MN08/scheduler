<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Time;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, time $times)
    {
        // $search = $request->input('search');

        // $times = $times->when($search, function ($query) use ($search) {
        //     return $query->where('name', 'like', '%' . $search . '%')
        //         ->orWhere('grade', 'like', '%' . $search . '%');
        // })
        $times = $times->paginate(15);

        $request = $request->all();

        return view('scheduler.admin.time.list', [
            'times' => $times,
            'request' => $request,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('scheduler.admin.time.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Time $time)
    {
        $validator = VALIDATOR::make($request->all(), [
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard.times.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $time->start_time = $request->input('start_time');
            $time->end_time = $request->input('end_time');
            $time->save();

            return redirect()->route('dashboard.times');
        }
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

        $time = time::find($id);

        return view('scheduler.admin.time.form', ['time' => $time]);
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

        $time = time::find($id);
        $validator = VALIDATOR::make($request->all(), [
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('dashboard/times/edit/' . $id)
                ->withErrors($validator)
                ->withInput();
        } else {
            $time->start_time = $request->input('start_time');
            $time->end_time = $request->input('end_time');
            $time->save();

            return redirect('dashboard/times');
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
        $time = time::find($id);
        $time->delete();

        return redirect('dashboard/times');
    }
}
