<!DOCTYPE html>
<html>
<head>
	<title>Scan the following QR code</title>
</head>
<body>
    <h4>User Information</h4>
	<p>Name: {{ $name }}</p>
	<p>Email: {{ $email }}</p>
	<p>Password: {{ $password }}</p>
	<br/>
	<h3>Scan the following QR code:</h3>
	<img src="{{ $message->embed(public_path().$image) }}" width="200px;" />
</body>
</html>
