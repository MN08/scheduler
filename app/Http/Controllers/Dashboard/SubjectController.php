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
        return view('scheduler.admin.subject.form', [
            'button'        => 'Simpan',
            'url'           => 'dashboard.subjects.store'
        ]);
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
            'type' => 'required',
            'available_time' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard.subjects.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $subject->name = $request->input('name');
            $subject->code = $request->input('code');
            $subject->type = $request->input('type');
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
    public function edit(Subject $subject)
    {
        return view('scheduler.admin.subject.form', [
            'subject'       => $subject,
            'button'        => 'Simpan',
            'url'           => 'dashboard.subjects.update'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        $validator = VALIDATOR::make($request->all(), [
            'name' => 'required',
            'code' => 'required',
            'type' => 'required',
            'available_time' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard.subjects.edit', $subject->id)
                ->withErrors($validator)
                ->withInput();
        } else {
            $subject->name = $request->input('name');
            $subject->code = $request->input('code');
            $subject->type = $request->input('type');
            $subject->available_time = $request->input('available_time');
            $subject->save();

            return redirect()->route('dashboard.subjects');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('dashboard.subjects');
    }
}
