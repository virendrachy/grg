@extends('layouts.app')

@section('headerTitle')
Edit User :: Blog
@endsection

@section('title')
Edit Posts
@endsection

@section('content')
@include('errors.common')
<div>
{{ Form::open(array('url' => 'user/update')) }}

{{ Form::hidden('user_id', $user->id) }}

<div class="form-group">
    {{ Form::label('name', 'Name:') }}
    {!! Form::text('name', $user->name, array('class' => 'form-control' )) !!}
</div>
<div class="form-group">
    {{ Form::label('email', 'Email:') }}
    {!! Form::text('email', $user->email, array('class' => 'form-control' )) !!}
</div>
<?php $roleArray = array('admin' => 'Admin', 'author' => 'Author', 'register' => 'Register'); ?>
<div class="form-group">
    {{ Form::label('role', 'Role:') }}
    {!! Form::select('role', $roleArray , $user->role) !!}
</div>

<div class="form-group">
    {{ Form::label('block', 'Block:') }}
    @if( $user->block == 1) 
    {{ Form::checkbox('block', 1, true) }}
    @else 
    {{ Form::checkbox('block', 1) }}
    @endif
</div>


 
{!! Form::submit('Update', array('name' => 'update', 'class' => 'btn btn-success' )) !!}

{{ Form::close() }}
</div>
@endsection