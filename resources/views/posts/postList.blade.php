@extends('layouts.app')

@section('headerTitle')
Manage Post :: Blog
@endsection

@section('title')
Manage Posts
@endsection

@section('content')

@if(Session::has('flash_message'))
<div class="alert alert-success">
    {{ Session::get('flash_message') }}
</div>
@endif


@if ( !$posts->count() )
There is no post till now. Write a new post now!!!
@else
@if(!Auth::guest() && (Auth::user()->is_admin() || Auth::user()->is_author()))
<h4 style='text-align: right;'><a href="{{ url('post/add') }}" class="btn btn-success">Add new post</a></h4><br />
@endif
<table class="post-list">
    @foreach( $posts as $post )
        @if(Auth::user()->is_admin() || (Auth::user()->is_author() && $post->user_id == Auth::user()->id))
        <tr>
            <td class="title"><a href="{{ url('post/show/'.$post->slug) }}">{{ $post->title }}</a></td>
            <td class="date">{{ $post->created_at->format('Y-m-d H:i') }} By <b>{{ $post->author->name }}</b></td>
            <td class="detail">
                <article>
                    {!! str_limit($post->body, $limit = 150) !!}
                </article>
            </td>
            <td class="link-active">                
                    @if($post->active == 1)
                    <a href="{{ url('post/disable/'.$post->id) }}">Disable</a>
                    @else
                    <a href="{{ url('post/active/'.$post->id) }}">Active</a>
                    @endif

            </td>
            <td class="link-delete">
                @if(Auth::user()->is_admin())
                    <a href="{{ url('post/delete/'.$post->id) }}">Delete</a>
                @endif
            </td>
        </tr>
        @endif
    @endforeach
</table>
{!! str_replace('/?', '?', $posts->render()) !!}
@endif

@endsection
