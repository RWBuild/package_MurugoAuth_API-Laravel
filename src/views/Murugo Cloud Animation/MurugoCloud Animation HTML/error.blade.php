<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="chrome=1,IE=edge" />
    <title>MurugoCloud Animation</title>
    <meta name="viewport" content="user-scalable=yes, width=device-width" />
    <style>
        html {
            height: 100%;
        }

        body {
            background-color: #FFFFFF;
            margin: 0;
            width: 100%;
            height: 100%;
        }

        .error-conatiner {
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .error-conatiner a {
            text-decoration: none;
            color: #3490dc;
            margin-top: 20px
        }
    </style>
</head>

<body>
    <div id="murugocloudanimation_hype_container">
        <script type="text/javascript" charset="utf-8" src="{{ asset('vendor/rwandabuild/murugo_api_auth/MurugoCloud%20Animation.hyperesources/murugocloudanimation_hype_generated_script.js?92246g')}}"></script>
    </div>
    <div class="error-conatiner">
        {{ $message }}
        @inject('MurugoAuth', RwandaBuild\MurugoAuth\Facades\MurugoAuth::class)
        <a href="{{ $MurugoAuth::redirect()->getTargetUrl() }}">Login</a>
    </div>
</body>


</html>