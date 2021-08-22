<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, teacher $teachers)
    {
        $search = $request->input('search');

        $teachers = $teachers->when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })
            ->paginate(8);

        $request = $request->all();

        return view('scheduler.admin.teacher.list', [
            'teachers' => $teachers,
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
        return view('scheduler.admin.teacher.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Teacher $teacher)
    {
        $validator = VALIDATOR::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard.teachers.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $teacher->name = $request->input('name');
            $teacher->save();

            return redirect()->route('dashboard.teachers');
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

        $teacher = teacher::find($id);

        return view('scheduler.admin.teacher.form', ['teacher' => $teacher]);
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

        $teacher = teacher::find($id);
        $validator = VALIDATOR::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('dashboard/teachers/edit/' . $id)
                ->withErrors($validator)
                ->withInput();
        } else {
            $teacher->name = $request->input('name');
            $teacher->save();

            return redirect('dashboard/teachers');
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
        $teacher = teacher::find($id);
        $teacher->delete();

        return redirect('dashboard/teachers');
    }
}
