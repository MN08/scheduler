<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, User $users)
    {
        $search = $request->input('search');

        $users = $users->when($search, function ($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%');
        })
            ->paginate(10);

        $request = $request->all();

        return view('scheduler.admin.user.list', [
            'users' => $users,
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

        return view('scheduler.admin.user.form', [
            'button'    => 'Simpan',
            'url'       => 'dashboard.users.store'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $validator = VALIDATOR::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:App\Models\User,email,' . $user->id
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard.users.create')
                ->withErrors($validator)
                ->withInput();
        } else {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->save();

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
    public function edit(User $user)
    {

        // $user = USER::find($id);

        return view('scheduler.admin.user.form', [
            'user' => $user,
            'button'    => 'Simpan',
            'url'       => 'dashboard.users.update'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validator = VALIDATOR::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:App\Models\User,email,' . $user->id
        ]);

        if ($validator->fails()) {
            return redirect()->route('dashboard.users.edit', $user->id)
                ->withErrors($validator)
                ->withInput();
        } else {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->save();

            return redirect()->route('dashboard.users');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('dashboard.users.delete');
    }
}
