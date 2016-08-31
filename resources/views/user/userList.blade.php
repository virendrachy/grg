@extends('layouts.app')

@section('headerTitle')
Manage User :: Blog
@endsection

@section('title')
Manage User
@endsection

@section('content')

@if(Session::has('flash_message'))
<div class="alert alert-success">
    {{ Session::get('flash_message') }}
</div>
@endif

<table class="post-list">
    <tr>
        <th> Name </th>
        <th> Email </th>
        <th> Role </th>
        <th> Block </th>
        <th>  </th>
    </tr>
    @foreach( $users as $user )
    <tr>
        <td> {{ $user->name }} </td>
        <td> {{ $user->email }} </td>
        <td> {{ $user->role }} </td>
        <td> 
            @if($user->block == 0)
                Active
            @else 
                Block
            @endif            
        </td>
        <td><a href="{{ url('user/edit/'.$user->id) }}">Edit</a></td>
        
    </tr>
    @endforeach
</table>    
{!! str_replace('/?', '?', $users->render()) !!}
@endsection