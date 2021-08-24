<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Room;
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

        $teachersubejects = $teacherSubjects->when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('grade', 'like', '%' . $search . '%');
        })
            ->paginate(15);

        $request = $request->all();
        dd($teacherSubjects);
        return view('scheduler.admin.teachersubject.list', [
            'teachersubjects' => $teachersubejects,
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
        $rooms = Room::get();
        return view('scheduler.admin.teachersubject.form', [
            'button'    => 'Simpan',
            'url'       => 'dashboard.teachersubjects.store',
            'teacher' => $teachers,
            'subject' => $subjects,
            'room' => $rooms,
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
            'teacher_name' => 'required',
            'subject_name' => 'required',
            'room_grade' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard.teachersubjects.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $teacherSubject->name = $request->input('teacher_name');
            $teacherSubject->name = $request->input('subject_name');
            $teacherSubject->grade = $request->input('room_grade');
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
        $rooms = Room::get();
        return view('scheduler.admin.schoolyear.form', [
            'teachersubject'   => $teacherSubject,
            'button'    => 'Simpan',
            'url'       => 'dashboard.teachersubjects.update',
            'teacher' => $teachers,
            'subject' => $subjects,
            'room' => $rooms,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TeacherSubject  $teacherSubject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TeacherSubject $teacherSubject, Teacher $teacher, Subject $subject, Room $room)
    {
        $validator = VALIDATOR::make($request->all(), [
            'teacher_name' => 'required',
            'subject_name' => 'required',
            'room_grade' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard.teachersubjects.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $teacherSubject->teacher->name = $request->input('teacher_name');
            $teacherSubject->subject->name = $request->input('subject_name');
            $teacherSubject->room->grade = $request->input('room_grade');
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
