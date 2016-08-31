<?php
namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    /**
     * Admin view for manage User
     */
    public function manage()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(5);
        return view('user.userList')->withUsers($users);
    }

    /**
     * Edit exisiting User
     *
     * @param  array  $request
     * @param $id
     * @return view post.edit
     */
    public function edit(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        return view('user.edit')->with('user', $user);
    }

    /**
     * Update existing User
     *
     * @param  array  $request
     * @return view post
     */
    public function update(Request $request)
    {
        Input::merge(array_map('trim', Input::all()));
        $this->validate(
                $request, [
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|max:255'
                ]
        );

        $user_id = $request->input('user_id');
        $user = User::find($user_id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->block = $request->input('block');
        $user->save();
        Session::flash('flash_message', 'User successfully Updated!');
        return redirect('/user');
    }

}
