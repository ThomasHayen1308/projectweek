<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Json;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_id = $request->input('sort');
        $text_sort = '%' . $request->input('name') . '%';
        if ($sort_id == 0) {
            $users = User::orderBy('name', 'asc')
                ->where('name', 'like', $text_sort)
                ->where('email', 'like', $text_sort)
                ->paginate(10) //Sorted by ID, All users 10/page
                ->appends(['name' => $request->input('name'), 'email' => $request->input('name')]);
        }
        if ($sort_id == 1) {
            $users = User::orderBy('name', 'desc')
                ->where('name', 'like', $text_sort)
                ->where('email', 'like', $text_sort)
                ->paginate(10) //Sorted by ID, All users 10/page
                ->appends(['name' => $request->input('name'), 'email' => $request->input('name')]);
        }
        if ($sort_id == 2) {
            $users = User::orderBy('email', 'asc')
                ->where('name', 'like', $text_sort)
                ->where('email', 'like', $text_sort)
                ->paginate(10) //Sorted by ID, All users 10/page
                ->appends(['name' => $request->input('name'), 'email' => $request->input('name')]);
        }
        if ($sort_id == 3) {
            $users = User::orderBy('email', 'desc')
                ->where('name', 'like', $text_sort)
                ->where('email', 'like', $text_sort)
                ->paginate(10) //Sorted by ID, All users 10/page
                ->appends(['name' => $request->input('name'), 'email' => $request->input('name')]);
        }
        if ($sort_id == 4) {
            $users = User::orderBy('id')
                ->where('name', 'like', $text_sort)
                ->where('email', 'like', $text_sort)
                ->where('active', 'like', '%0%')
                ->paginate(10) //Sorted by ID, All users 10/page
                ->appends(['name' => $request->input('name'), 'email' => $request->input('name')]);
        }
        if ($sort_id == 5) {
            $users = User::orderBy('id', 'desc')
                ->where('name', 'like', $text_sort)
                ->where('email', 'like', $text_sort)
                ->where('admin', 'like', '%1%')
                ->paginate(10)
                ->appends(['name' => $request->input('name'), 'email' => $request->input('name')]);
        }

        $users1 = User::orderBy('name', 'asc')->get(); //name A-Z
        \Facades\App\Helpers\Json::dump($users);
        $result = compact('users1', 'users');

        return view('admin.users.index', $result);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return redirect('admin/users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $result = compact('user');
        \Facades\App\Helpers\Json::dump($result);
        return view('admin.users.edit', $result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|min:3|unique:users,name,' . $user->id,
            'email' => 'required|min:3|unique:users,email,' . $user->id,

        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $admin_test = $request->admin;
        $active_test = $request->active;

        if ($active_test != 1) {
            $user->active = 0;
        } else {
            $user->active = $active_test;
        }

        if ($admin_test != 1) {
            $user->admin = 0;
        } else {
            $user->admin = $admin_test;
        }
        $user->save();
        session()->flash('success', "<b>$user->name</b> has been updated");
        return redirect('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */

    public function destroy(User $user)
    {
        if ($user->admin != 1) {
            $user->delete();
            return response()->json([
                'type' => 'success',
                'text' => "The user <b>$user->name</b> has been deleted"
            ]);
        } else {
            return response()->json([
                'type' => 'error',
                'text' => "The user <b>$user->name</b> Will not be deleted in order to not exclude yourself from the website"
            ]);
        }
    }

}
