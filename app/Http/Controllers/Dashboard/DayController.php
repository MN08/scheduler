<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Days;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class DayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Days $days)
    {
        // $search = $request->input('search');

        $days = $days->paginate(8);

        $request = $request->all();

        return view('scheduler.admin.day.list', [
            'days' => $days,
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
        return view('scheduler.admin.day.form', [
            'button'    => 'Simpan',
            'url'       => 'dashboard.days.store'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Days $day)
    {
        $validator = VALIDATOR::make($request->all(), [
            'name' => 'required',
            'slot' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard.days.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $day->name = $request->input('name');
            $day->slot = $request->input('slot');
            $day->save();

            return redirect()->route('dashboard.days');
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
    public function edit(Days $day)
    {
        return view('scheduler.admin.day.form', [
            'day'   => $day,
            'button'    => 'Simpan',
            'url'       => 'dashboard.days.update'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Days $day)
    {
        $validator = VALIDATOR::make($request->all(), [
            'name' => 'required',
            'slot' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard.days.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $day->name = $request->input('name');
            $day->slot = $request->input('slot');
            $day->save();

            return redirect()->route('dashboard.days');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Days $day)
    {
        $day->delete();

        return redirect()->route('dashboard.days');
    }
}
