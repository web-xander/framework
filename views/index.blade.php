<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to WebXander Framework</title>
	
</head>
<body>
	<h1>Welcome to WebXander Framework</h1>
	@foreach($users as $user)
			<p>{{$user->firstname}} - {{$user->id}}</p>
	@endforeach

	<p>{{$msg}}</p>

	<img src="img/logo.png" alt="logo">
	

</body>
</html>