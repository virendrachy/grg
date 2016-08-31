@extends('layouts.app')

@section('headerTitle')
Edit Post :: Blog
@endsection

@section('title')
Edit Posts
@endsection

@section('content')

  
@if($post->count() && !Auth::guest() && (Auth::user()->is_admin())  || (Auth::user()->is_author() && $post->user_id == Auth::user()->id))
@include('errors.common')
{{ Form::open(array('url' => 'post/update')) }}

{{ Form::hidden('post_id', $post->id) }}

<div class="form-group">
    {{ Form::label('title', 'Title:') }}
    {!! Form::text('title', $post->title , array('class' => 'form-control' )) !!}
</div>
<div class="form-group">
    {{ Form::label('body', 'Description:') }}
    {{ Form::textarea('body', $post->body , ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('publish_date', 'Publish Date:') }} <br />
    {!! Form::date('publish_date', $post->publish_date , ['id' => 'datepicker']) !!}
</div>
 
 
{!! Form::submit('Publish', array('name' => 'publish', 'class' => 'btn btn-success' )) !!}

{{ Form::close() }}
@endif

@endsection

@section('bottomJs')
<script>
    $('#datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: 0
    });
</script>
@endsection