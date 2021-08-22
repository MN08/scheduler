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
    public function index(Request $request, schoolyear $schoolyears)
    {
        // $search = $request->input('search');

        // $schoolyears = $schoolyears->when($search, function ($query) use ($search) {
        //     return $query->where('name', 'like', '%' . $search . '%')
        //         ->orWhere('grade', 'like', '%' . $search . '%');
        // })
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
        return view('scheduler.admin.schoolyear.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, SchoolYear $schoolYear)
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
            $schoolYear->year = $request->input('year');
            $schoolYear->semester = $request->input('semester');
            $schoolYear->save();

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
    public function edit($id)
    {

        $schoolyear = schoolyear::find($id);

        return view('scheduler.admin.schoolyear.form', ['schoolyear' => $schoolyear]);
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

        $schoolyear = schoolyear::find($id);
        $validator = VALIDATOR::make($request->all(), [
            'year' => 'required',
            'semester' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('dashboard/schoolyears/edit/' . $id)
                ->withErrors($validator)
                ->withInput();
        } else {
            $schoolyear->year = $request->input('year');
            $schoolyear->semester = $request->input('semester');
            $schoolyear->save();

            return redirect('dashboard/schoolyears');
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
        $schoolyear = schoolyear::find($id);
        $schoolyear->delete();

        return redirect('dashboard/schoolyears');
    }
}
