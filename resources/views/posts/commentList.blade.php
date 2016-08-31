@extends('layouts.app')

@section('headerTitle')
Manage Comment:: Blog
@endsection

@section('title')
Manage Comments
@endsection

@section('content')

@if(Session::has('flash_message'))
<div class="alert alert-success">
    {{ Session::get('flash_message') }}
</div>
@endif

@if ( !$comments->count() )
There is no Comment till now. Write a new Comment now!!!
@else
<table class="post-list">
    @foreach( $comments as $comment )
        @if(Auth::user()->is_admin() || (Auth::user()->is_author() && $comment->post->user_id == Auth::user()->id))
        <tr>        
            <td class="title"><a href="{{ url('post/show/'.$comment->post->slug) }}">{{ $comment->post->title }}</a></td>
            <td class="detail">
                <article>
                    {!! str_limit($comment->body, $limit = 150) !!}
                </article>
            </td>
            <td class="date">{{ $comment->created_at->format('Y-m-d H:i') }} By 
                <b>{{ $comment->author->name }}</b></td>
            <td class="link-active">            
                    @if($comment->active == 1)
                    <a href="{{ url('comment/disable/'.$comment->id) }}">Disable</a>
                    @else
                    <a href="{{ url('comment/active/'.$comment->id) }}">Active</a>
                    @endif            
            </td>
            <td class="link-delete"><a href="{{ url('comment/delete/'.$comment->id) }}">Delete</a></td>
        </tr>
        @endif
    @endforeach
</table>
{!! str_replace('/?', '?', $comments->render()) !!}
@endif

@endsection
