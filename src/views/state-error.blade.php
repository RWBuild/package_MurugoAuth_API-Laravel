<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
</head>

<body>
    {{$message}}

    @inject('MurugoAuth', RwandaBuild\MurugoAuth\Facades\MurugoAuth::class)

    <a href="{{ $MurugoAuth::redirect()->getTargetUrl() }}">Login</a>
</body>

</html>