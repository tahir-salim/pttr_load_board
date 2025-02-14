<!DOCTYPE html>
<html>
<head>
    <title>Welcoming Email</title>
</head>

<body>
    <div style="font-size: 16px; line-height: 140%; text-align: left; word-wrap: break-word;">
        <p style="line-height: 140%;"><strong>Your email is registered as SubAdmin in {{config('app.name')}}!</strong></p>
        <hr />
        <p style="line-height: 140%;"><strong>Name: {{$name}}</strong></p> <br>
                <p style="line-height: 140%;"><strong>Email: {{$email}}</strong></p><br>
                <p style="line-height: 140%;"><strong>Phone: {{$phone}}</strong></p><br>
                <p style="line-height: 140%;"><strong>Password: {{$password}}</strong></p><br>
    </div>
</body>

</html>
