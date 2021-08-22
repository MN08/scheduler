<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, subject $subjects)
    {
        $search = $request->input('search');

        $subjects = $subjects->when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('code', 'like', '%' . $search . '%')
                ->orWhere('grade', 'like', '%' . $search . '%');
        })
            ->paginate(15);

        $request = $request->all();

        return view('scheduler.admin.subject.list', [
            'subjects' => $subjects,
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
        return view('scheduler.admin.subject.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Subject $subject)
    {
        $validator = VALIDATOR::make($request->all(), [
            'name' => 'required',
            'code' => 'required',
            'grade' => 'required',
            'available_time' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard.subjects.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $subject->name = $request->input('name');
            $subject->code = $request->input('code');
            $subject->grade = $request->input('grade');
            $subject->available_time = $request->input('available_time');
            $subject->save();

            return redirect()->route('dashboard.subjects');
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

        $subject = subject::find($id);

        return view('scheduler.admin.subject.form', ['subject' => $subject]);
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

        $subject = subject::find($id);
        $validator = VALIDATOR::make($request->all(), [
            'name' => 'required',
            'code' => 'required',
            'grade' => 'required',
            'available_time' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('dashboard/subjects/edit/' . $id)
                ->withErrors($validator)
                ->withInput();
        } else {
            $subject->name = $request->input('name');
            $subject->code = $request->input('code');
            $subject->grade = $request->input('grade');
            $subject->available_time = $request->input('available_time');
            $subject->save();

            return redirect('dashboard/subjects');
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
        $subject = subject::find($id);
        $subject->delete();

        return redirect('dashboard/subjects');
    }
}
