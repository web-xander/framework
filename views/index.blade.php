@extends('layout.app')

@section('content')
	<h1>Welcome to WebXander Framework</h1>
	@foreach($users as $user)
			<p>{{$user->firstname}} - {{$user->getId()}}</p>
	@endforeach
	
@endsection