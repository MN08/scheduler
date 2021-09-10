<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Lab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Lab $labs)
    {
        $search = $request->input('search');

        $labs = $labs->when($search, function ($query) use ($search) {
            return $query->where('code', 'like', '%' . $search . '%')
                ->orWhere('grade', 'like', '%' . $search . '%');
        })
            ->paginate(8);

        $request = $request->all();

        return view('scheduler.admin.lab.list', [
            'labs' => $labs,
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
        return view('scheduler.admin.lab.form', [
            'button'    => 'Simpan',
            'url'       => 'dashboard.labs.store'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Lab $lab)
    {
        $validator = VALIDATOR::make($request->all(), [
            'name' => 'required',
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard.labrooms.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $lab->name = $request->input('name');
            $lab->code = $request->input('code');
            $lab->save();

            return redirect()->route('dashboard.labs');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lab  $lab
     * @return \Illuminate\Http\Response
     */
    public function show(Lab $lab)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lab  $lab
     * @return \Illuminate\Http\Response
     */
    public function edit(Lab $lab)
    {
        return view('scheduler.admin.lab.form', [
            'lab'   => $lab,
            'button'    => 'Simpan',
            'url'       => 'dashboard.labs.update'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lab  $lab
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Lab $lab)
    {
        $validator = VALIDATOR::make($request->all(), [
            'name' => 'required',
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard.rooms.edit' . $lab->id)
                ->withErrors($validator)
                ->withInput();
        } else {
            $lab->name = $request->input('name');
            $lab->code = $request->input('code');
            $lab->save();

            return redirect()->route('dashboard.rooms');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lab  $lab
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lab $lab)
    {
        //
    }
}
