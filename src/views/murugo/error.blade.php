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
            margin-top: 120px
        }

        .error-conatiner a {
            text-decoration: none;
            color: #3490dc;
            margin-top: 20px
        }
    </style>
</head>

<body>
    <div>
        <img src="{{ asset('vendor/rwandabuild/murugo_api_auth/menubg.png') }}" style="width:100%" />
        {{-- <script type="text/javascript" charset="utf-8" src="{{ asset('vendor/rwandabuild/murugo_api_auth/MurugoCloud%20Animation.hyperesources/murugocloudanimation_hype_generated_script.js?92246g')}}"></script> --}}
    </div>
    <div class="error-conatiner">
        {{ $message }}
        <a href="{{ route('redirect') }}">Login</a>
    </div>
</body>

</html>