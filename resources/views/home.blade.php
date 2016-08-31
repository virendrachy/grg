@extends('layouts.app')

@section('headerTitle')
Home :: Blog
@endsection

@section('title')
Latest Posts
@endsection

@section('content')

@if(Session::has('flash_message'))
<div class="alert alert-success">
    {{ Session::get('flash_message') }}
</div>
@endif
@if(!Auth::guest() && (Auth::user()->is_admin() || Auth::user()->is_author() ))
<h4 style='text-align: right;'><a href="{{ url('post/add') }}" class="btn btn-success">Add new post</a></h4><br />
@endif

@if ( !$posts->count() )
There is no post till now. Login and write a new post now!!!
@else
@foreach( $posts as $post )
<div class="list-group">
    <div class="list-group-item">
        <h3><a href="{{ url('post/show/'.$post->slug) }}">{{ $post->title }}</a></h3>
        @if(Auth::user() && (Auth::user()->is_admin() || (Auth::user()->is_author() && $post->user_id == Auth::user()->id)))
        <a href="{{ url('post/edit/'.$post->slug)}}" class="btn" style="float:right">Edit Post</a>
        @endif

        <p>{{ $post->created_at->format('Y-m-d H:i') }} By <b>{{ $post->author->name }}</b></p>
    </div>
    <div class="list-group-item">
        <article>
            {!! str_limit($post->body, $limit = 250, $end = ' ....... <a href='.url("post/show/".$post->slug).'>Read More</a>') !!}
        </article>
    </div>
</div>
@endforeach
{!! str_replace('/?', '?', $posts->render()) !!}
@endif

@endsection
