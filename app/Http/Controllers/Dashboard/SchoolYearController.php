<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SchoolYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, SchoolYear $schoolyears)
    {
        $schoolyears = $schoolyears->paginate(15);

        $request = $request->all();

        return view('scheduler.admin.schoolyear.list', [
            'schoolyears' => $schoolyears,
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
        return view('scheduler.admin.schoolyear.form', [
            'button'    => 'Simpan',
            'url'       => 'dashboard.schoolyears.store'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, SchoolYear $schoolyear)
    {
        $validator = VALIDATOR::make($request->all(), [
            'year' => 'required',
            'semester' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard.schoolyears.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $schoolyear->year = $request->input('year');
            $schoolyear->semester = $request->input('semester');
            $schoolyear->save();

            return redirect()->route('dashboard.schoolyears');
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
    public function edit(SchoolYear $schoolyear)
    {
        return view('scheduler.admin.schoolyear.form', [
            'schoolyear'   => $schoolyear,
            'button'    => 'Simpan',
            'url'       => 'dashboard.schoolyears.update'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SchoolYear $schoolyear)
    {
        $validator = VALIDATOR::make($request->all(), [
            'year' => 'required',
            'semester' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard.schoolyears.edit' . $schoolyear->id)
                ->withErrors($validator)
                ->withInput();
        } else {
            $schoolyear->year = $request->input('year');
            $schoolyear->semester = $request->input('semester');
            $schoolyear->save();

            return redirect()->route('dashboard.schoolyears');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SchoolYear $schoolyear)
    {
        $schoolyear->delete();

        return redirect()->route('dashboard.schoolyears');
    }
}
