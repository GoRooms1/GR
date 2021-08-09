<!DOCTYPE html>
<html>
<head>
    <title>Email from site {{ config('app.name', 'Laravel') }}</title>
</head>
<body>
Message from: {{ $form->page }} <br>
User ip: {{ $form->ip }} <br>
Fields: <br>
@foreach(json_decode($form->fields) AS $name => $value)
    <strong>{{ $name }}</strong>: <span> {{ $value }} </span><br>
@endforeach
<p>Thank you</p>
</body>
</html>