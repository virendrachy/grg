@extends('layouts.app')

@section('headerTitle')
Post Details :: Blog
@endsection

@section('title')
@if($post)
{!! $post->title !!}
@else
Post Not Found
@endif
@endsection

@section('content')

@if($post)
<p>{{ $post->created_at->format('Y-m-d H:i') }} By <b>{{ $post->author->name }}</b></p>
<div>
    {!! $post->body !!}
</div>
@if(Auth::user() && (Auth::user()->is_admin() || (Auth::user()->is_author() && $post->user_id == Auth::user()->id)))
<div><a href="{{ url('post/edit/'.$post->slug)}}" class="btn" style="float:right">Edit Post</a></div>
@endif
<div class="panel panel-default" style='margin-top:20px;'>
    <div class="panel-heading">
        <h4>Comments ( {{ count($comments) }} )</h4>
    </div>
</div>
<div class="panel-body">
    @if($comments)
    <ul style="list-style: none; padding: 0">
        @foreach($comments as $comment)
        <li class="">
            <div class="list-group">
                <div class="list-group-item">
                    <p>{{ $comment->body }}</p>
                    <p>Created By : <span style="font-weight: bold;"> {{ $comment->author->name }} </span>
                        at {{ $comment->created_at->format('Y-m-d H:i') }}</p>
                </div>

            </div>
        </li>
        @endforeach
    </ul>
    @endif
</div>
@if(!Auth::guest())
@include('errors.common')
{{ Form::open(array('url' => 'comment/add')) }}
{{ csrf_field() }}
{{ Form::hidden('post_id', $post->id) }}
<div class="form-group">
    {{ Form::label('body', 'Comments:') }}
    {{ Form::textarea('body', null, ['class' => 'form-control']) }}
</div>

{!! Form::submit('Add Comment', array('name' => 'publish', 'class' => 'btn btn-success' )) !!}

{{ Form::close() }}
@else
<div> * Required login for add comment. </div>
@endif

@endif


@endsection