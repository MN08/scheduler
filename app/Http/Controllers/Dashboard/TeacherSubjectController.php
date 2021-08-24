<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\TeacherSubject;
use App\Http\Controllers\Controller;
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

        $teachersubjects = $teacherSubjects->when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('grade', 'like', '%' . $search . '%');
        })
            ->paginate(15);

        $request = $request->all();
        return view('scheduler.admin.teachersubject.list', [
            'teachersubjects' => $teachersubjects,
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
        $teachers = Teacher::get();
        $subjects = Subject::get();
        return view('scheduler.admin.teachersubject.form', [
            'button'    => 'Simpan',
            'url'       => 'dashboard.teachersubjects.store',
            'teachers' => $teachers,
            'subjects' => $subjects
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, TeacherSubject $teacherSubject)
    {
        $validator = VALIDATOR::make($request->all(), [
            'teacher_id' => 'required',
            'subject_id' => 'required',
            'grade' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard.teachersubjects.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $teacherSubject->teacher_id = $request->input('teacher_id');
            $teacherSubject->subject_id = $request->input('subject_id');
            $teacherSubject->grade = $request->input('grade');
            $teacherSubject->save();

            return redirect()->route('dashboard.teachersubjects');
        }
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
        $teachers = Teacher::get();
        $subjects = Subject::get();
        return view('scheduler.admin.schoolyear.form', [
            'teachersubject'   => $teacherSubject,
            'button'    => 'Simpan',
            'url'       => 'dashboard.teachersubjects.update',
            'teachers' => $teachers,
            'subjects' => $subjects,
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
        $validator = VALIDATOR::make($request->all(), [
            'teacher_id' => 'required',
            'subject_id' => 'required',
            'grade' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard.teachersubjects.edit')
                ->withErrors($validator)
                ->withInput();
        } else {
            $teacherSubject->teacher_id = $request->input('teacher_id');
            $teacherSubject->subject_id = $request->input('subject_id');
            $teacherSubject->grade = $request->input('grade');
            $teacherSubject->save();

            return redirect()->route('dashboard.teachersubjects');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TeacherSubject  $teacherSubject
     * @return \Illuminate\Http\Response
     */
    public function destroy(TeacherSubject $teacherSubject)
    {
        $teacherSubject->delete();

        return redirect()->route('dashboard.teachersubjects');
    }
}
