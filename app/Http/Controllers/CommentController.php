<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;

class CommentController extends Controller
{

    /**
     * Add new comment in DB
     *
     * @param  array  $request
     * @redirect view home
     */
    public function store(Request $request)
    {
        Input::merge(array_map('trim', Input::all()));
        $this->validate($request, [
            'body' => 'required | min:6',
                ]
        );
        $input['user_id'] = $request->user()->id;
        $input['post_id'] = $request->input('post_id');
        $input['body'] = $request->input('body');
        $input['active'] = 0;
        Comment::create($input);
        \Session::flash('flash_message', 'Comment will publish after admin review!');
        return redirect('/home');
    }

    /**
     * Manage comments .. view only for admin user
     *
     * @redirect view commentlist
     */
    public function manage()
    {
        if (Auth::user()->is_admin()) {
            $comments = Comment::orderBy('created_at', 'desc')->paginate(5);
        } else {
            $comments = Comment::whereHas('Post', function($query) {
                                $query->where('user_id', Auth::id());
                            })
                            ->orderBy('created_at', 'desc')->paginate(5);
        }
        $comments->setPath('list/');
        return view('posts.commentList')->withComments($comments);
    }

    /**
     * Disable active comment
     *
     * @param  array  $request
     * @param $c_id .. comment id
     * @redirect view comment.list
     */
    public function disable($c_id)
    {
        $comment = Comment::where('id', '=', $c_id)->get()->first();
        $comment->active = 0;
        $comment->save();
        \Session::flash('flash_message', 'Comment successfully Disabled!');
        return redirect('comment/list');
    }

    /**
     * Active disabled comment
     *
     * @param  array  $request
     * @param $c_id .. comment id
     * @redirect view comment.list
     */
    public function active($c_id)
    {
        $comment = Comment::where('id', '=', $c_id)->get()->first();
        $comment->active = 1;
        $comment->save();
        \Session::flash('flash_message', 'Comment successfully Active!');
        return redirect('comment/list');
    }

    /**
     * Delete comment
     *
     * @param  array  $request
     * @param $c_id .. comment id
     * @redirect view comment.list
     */
    public function delete($c_id)
    {
        $comment = Comment::where('id', '=', $c_id)->get()->first();
        $comment->delete();
        \Session::flash('flash_message', 'Comment successfully Deleted!');
        return redirect('comment/list');
    }

}
