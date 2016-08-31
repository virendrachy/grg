@extends('layouts.app')

@section('headerTitle')
New Post :: Blog
@endsection

@section('title')
Add New Post
@endsection

@section('content')
@include('errors.common')
{{ Form::open(array('url' => 'post/store')) }}
{{ csrf_field() }}
<div class="form-group">
    {{ Form::label('title', 'Title:') }}
    {!! Form::text('title', '' , array('class' => 'form-control' )) !!}
</div>
<div class="form-group">
    {{ Form::label('body', 'Description:') }}
    {{ Form::textarea('body', null, ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('publish_date', 'Publish Date:') }} <br />
    {!! Form::date('publish_date', date('Y-m-d'), ['id' => 'datepicker']) !!}
</div>
{!! Form::submit('Publish', array('name' => 'publish', 'class' => 'btn btn-success' )) !!}

{{ Form::close() }}


@endsection

@section('bottomJs')
<script>
    $('#datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        minDate: 0
    });
</script>
@endsection