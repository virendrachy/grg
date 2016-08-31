<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\StorePostRequest;
use Auth;
use App\Repositories\Contracts\PostRepositoryInterface;

class PostController extends Controller
{

    /**
     * @var PostRepository
     */
    protected $repository;

    public function __construct(PostRepositoryInterface $post)
    {
        $this->post = $post;
    }

    /**
     * Display active posts on home page
     */
    public function index()
    {
        
        $posts = $this->post->getActive()->paginate(5);
        $posts->setPath('home');

        return view('/home')->withPosts($posts);
    }

    /**
     * Admin view for manage posts
     */
    public function manage()
    {
        if (Auth::user()->is_admin()) {
            $posts = $this->post->getAll()->paginate(5);         
        } else {
            $posts = Post::where('user_id', '=', Auth::id())
                            ->orderBy('created_at', 'desc')->paginate(5);
        }
        $posts->setPath('list/');

        return view('posts.postList')->withPosts($posts);
    }

    /**
     * Create new post
     *
     * @param  array  $request
     * @return view post.create
     */
    public function add()
    {
        return view('posts.create');
    }

    /**
     * Add new post in DB
     *
     * @param  array  $request
     * @return view post
     */
    public function store(StorePostRequest $request)
    {
        Input::merge(array_map('trim', Input::all()));
        $this->validate(
                $request, [
            'title' => 'required | min:6 | max:255 | unique:posts'
                ]
        );
        $dataArray = array(
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'slug' => str_slug($request->get('title')),
            'user_id' => $request->user()->id,
            'active' => 1,
            'publish_date' => $request->get('publish_date')
        );
        Post::create($dataArray);
        \Session::flash('flash_message', 'Post successfully added!');

        return redirect('/post');
    }

    /**
     * Detail view of post
     *
     * @param  array  $slug .. title of post
     * @return view post.show
     */
    public function show($slug)
    {
        //dd($this->post->find(5));
        $post = $this->post->findBy('slug', $slug)->first();
        if (!$post) {
            \Session::flash('flash_message', 'Post Not Found');

            return redirect('/');
        }

        $comments = $post->comment->where('active', 1);
        return view('posts.show')->withPost($post)->withComments($comments);
    }

    /**
     * Edit exisiting post
     *
     * @param  array  $request
     * @param $slug
     * @return view post.edit
     */
    public function edit($slug)
    {
        $post = Post::where('slug', $slug)->first();
        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update existing post
     *
     * @param  array  $request
     * @return view post
     */
    public function update(StorePostRequest $request)
    {
        Input::merge(array_map('trim', Input::all()));
        $post_id = $request->input('post_id');
        $this->validate(
                $request, [
            'title' => 'required | min:6 | max:255 | unique:posts,title,' . $post_id
                ]
        );
        $dataArray = array(
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'slug' => str_slug($request->get('title')),
            'user_id' => $request->user()->id,
            'publish_date' => $request->get('publish_date')
        );
        $post = Post::find($post_id);
        $post->update($dataArray);
        \Session::flash('flash_message', 'Post successfully Updated!');
        return redirect('/post');
    }

    /**
     * Disable active post
     *
     * @param  array  $request
     * @param $p_id .. post id
     * @redirect view post.list
     */
    public function disable($p_id)
    {
        $post = Post::where('id', '=', $p_id)->get()->first();
        $post->active = 0;
        $post->save();
        \Session::flash('flash_message', 'Post successfully Disabled!');

        return redirect('post/list');
    }

    /**
     * Active disabled post
     *
     * @param  array  $request
     * @param $p_id .. post id
     * @redirect view post.list
     */
    public function active($p_id)
    {
        $post = Post::where('id', '=', $p_id)->get()->first();
        $post->active = 1;
        $post->save();
        \Session::flash('flash_message', 'Post successfully Active!');
        return redirect('post/list');
    }

    /**
     * Remove post
     *
     * @param  array  $request
     * @param $p_id .. post id
     * @redirect view post.list
     */
    public function delete($p_id)
    {
        $post = Post::where('id', '=', $p_id)->get()->first();
        $post->delete();
        \Session::flash('flash_message', 'Post successfully Deleted!');
        return redirect('post/list');
    }

}
