<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, room $rooms)
    {
        $search = $request->input('search');

        $rooms = $rooms->when($search, function ($query) use ($search) {
            return $query->where('code', 'like', '%' . $search . '%')
                ->orWhere('grade', 'like', '%' . $search . '%')
                ->orWhere('type', 'like', '%' . $search . '%');
        })
            ->paginate(8);

        $request = $request->all();

        return view('scheduler.admin.room.list', [
            'rooms' => $rooms,
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
        return view('scheduler.admin.room.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, room $room)
    {
        $validator = VALIDATOR::make($request->all(), [
            'grade' => 'required',
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard.rooms.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $room->grade = $request->input('grade');
            $room->code = $request->input('code');
            $room->save();

            return redirect()->route('dashboard.rooms');
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

        $room = ROOM::find($id);

        return view('scheduler.admin.room.form', ['room' => $room]);
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

        $room = ROOM::find($id);
        $validator = VALIDATOR::make($request->all(), [
            'grade' => 'required',
            'code' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('dashboard/rooms/edit/' . $id)
                ->withErrors($validator)
                ->withInput();
        } else {
            $room->name = $request->input('grade');
            $room->code = $request->input('code');
            $room->type = $request->input('type');
            $room->save();

            return redirect('dashboard/rooms');
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
        $room = ROOM::find($id);
        $room->delete();

        return redirect('dashboard/rooms');
    }
}
