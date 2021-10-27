<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Days;
use App\Models\Room;
use App\Models\Schedule;
use App\Models\Time;
use App\Models\SchoolYear;
use App\Models\TeacherSubject;
use App\Tools\GeneticAlgorithmClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Psy\sh;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Schedule $schedules)
    {
        $search = $request->input('search');

        $schedules = $schedules->when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('grade', 'like', '%' . $search . '%');
        })
            ->orderBy('room_id', 'asc')
            ->orderBy('day_id', 'asc')
            ->orderBy('time_id', 'asc')
            ->paginate(15);



        $request = $request->all();
        return view('scheduler.admin.schedule.list', [
            'schedules' => $schedules,
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
        $teachersubjects = TeacherSubject::get();
        $schoolyears = SchoolYear::get();
        $times = Time::whereRaw('sequence % 2 !=0')->whereIsBreak(0)->get();
        $days = Days::get();
        $rooms = Room::get();
        return view('scheduler.admin.schedule.form', [
            'button'    => 'Generate',
            'url'       => 'dashboard.schedules.store',
            'teachers' => $teachersubjects,
            'schoolyears' => $schoolyears,
            'times' => $times,
            'days' => $days,
            'rooms' => $rooms,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Schedule $schedule)
    {
        $teachersubjects = TeacherSubject::get();
        // $times = Time::get();
        $times = Time::whereRaw('sequence % 2 !=0')->whereIsBreak(0)->get();
        $all_times = Time::whereIsBreak(0)->get();
        $days = Days::get();
        $rooms = Room::get();
        $schoolyears = SchoolYear::get();
        $geneticAlgotihm = new GeneticAlgorithmClass($teachersubjects, $times, $all_times, $days, $schoolyears, $rooms);
        $resultGenerate = $geneticAlgotihm->init();
        $generateSchedule = $geneticAlgotihm->generate();
        // dd($generateSchedule);
        // exit;
        //save result

        // Schedule::insert($resultGenerate);

        return redirect()->route('dashboard.schedules');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        //
    }
}
