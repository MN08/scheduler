<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\TeacherSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeacherSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, TeacherSubject $teacherSubjects)
    {
        $search = $request->input('search');

        $teachersubejects = $teacherSubjects->when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('grade', 'like', '%' . $search . '%');
        })
            ->paginate(15);

        $request = $request->all();

        $pengampu = TeacherSubject::with(['teacher', 'subject', 'room'])->get();

        return view('scheduler.admin.teachersubject.list', [
            'teachersubjects' => $teachersubejects,
            'request' => $request,
            'pengampu' => $pengampu,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('scheduler.admin.teachersubject.form', [
            'button'    => 'Simpan',
            'url'       => 'dashboard.teachersubjects.store'
        ]);
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
     * @param  \App\Models\TeacherSubject  $teacherSubject
     * @return \Illuminate\Http\Response
     */
    public function show(TeacherSubject $teacherSubject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TeacherSubject  $teacherSubject
     * @return \Illuminate\Http\Response
     */
    public function edit(TeacherSubject $teacherSubject)
    {
        return view('scheduler.admin.schoolyear.form', [
            'teachersubject'   => $teacherSubject,
            'button'    => 'Simpan',
            'url'       => 'dashboard.teachersubjects.update'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TeacherSubject  $teacherSubject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TeacherSubject $teacherSubject)
    {
        // $validator = VALIDATOR::make($request->all(), [
        //     'year' => 'required',
        //     'semester' => 'required'
        // ]);

        // if ($validator->fails()) {
        //     return redirect()->route('dashboard.teachersubject.edit' . $teacherSubject->id)
        //         ->withErrors($validator)
        //         ->withInput();
        // } else {
        //     $teacherSubject->year = $request->input('year');
        //     $teacherSubject->semester = $request->input('semester');
        //     $teacherSubject->save();

        //     return redirect()->route('dashboard.teachersubjects');
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TeacherSubject  $teacherSubject
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeacherSubject $teacherSubject)
    {
        //
    }
}
