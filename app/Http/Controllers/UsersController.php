<?php

namespace EMMA5\Http\Controllers;

use EMMA5\Board;
use EMMA5\User;
use EMMA5\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input as Input;
use File;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::with('board')->with('avatar')->with('board')->with('center')->orderBy('last_name')->get();
        return view('management.crud.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $user = new User();
        $boards = Board::all();
        return view('management.crud.users.create_form');
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
     * @param User $user
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(User $user)
    {
        //
        return view('management.crud.users.edit_form')->with('user', $user->load('avatar'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request, User $user)
    {
        //TODO validation
        $user->name = $request->name;
        $user->last_name = $request->last_name;
        $user->center_id = $request->center_id;
        $user->board_id = $request->board_id;
        $user->update($request->all());
        if ($request->hasFile('avatar')) {
            //Helper::gt
            $request->file('avatar');
            $path = public_path('images/avatars/users/'.$user->board_id);
            if (!File::exists($path)) {
                File::makeDirectory($path, 0775, true);
            }

            $imageUpload = $request->file('avatar')->move(
                public_path('images/avatars/users/'.$user->board_id),
                $user->id.".".$request->avatar->getClientOriginalExtension()
        );
            $image = new Image;
            $image->imageable_type = 'EMMA5\\user';
            $image->imageable_id = $user->id;
            $image->source = $user->id.".".$request->avatar->getClientOriginalExtension();
            $image->save();

        }

        flash('Usuario actualizado', 'success')->important();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     * @internal param int $user
     */
    public function destroy(User $user)
    {
            //
            try {
                    $user->delete();
            } catch (\Exception $e) {
                    return back(550);
            }
            $message = 'Usuario borrado';
            flash($message, 'info')->important();
            return redirect('locations');
    }
}
