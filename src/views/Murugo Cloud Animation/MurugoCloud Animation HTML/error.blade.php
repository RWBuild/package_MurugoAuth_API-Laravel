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

        .error-container {
            width: 100%;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            font-size: 16px;

        }

        .error-container p {
            font-size: 20px;
        }

        .error-container a {
            text-decoration: none;
            color: #3490dc;
            font-size: 20px;
            margin-left: 10px;
        }

        #murugocloudanimation_hype_container {
            width: 100% !important;
        }

        .HYPE_scene {
            width: 100% !important;
        }

        @media screen and (max-width: 500px) {
            body {
                background-color: #FFFFFF;
                margin: 0;
                width: 100%;
                height: 100%;
            }

            .error-container {
                width: 1200px;
                margin-top:300px;
                display: flex;
                flex-direction: row;
                justify-content: center;
                align-items: center;
                font-size: 48px;

            }

            .error-container a {
                text-decoration: none;
                font-size: 48px;
            }

            #murugocloudanimation_hype_container {
                min-width: 2000px !important;
                height: 300px !important;
            }

            .HYPE_scene {
                min-width: 2000px !important;
            }
        }
    </style>
</head>

<body>
    <div id="murugocloudanimation_hype_container">
        <script type="text/javascript" charset="utf-8"
            src="{{ asset('vendor/rwandabuild/murugo_api_auth/MurugoCloud%20Animation.hyperesources/murugocloudanimation_hype_generated_script.js?92246g') }}">
        </script>
    </div>
    <div class="error-container">
        {{ $message }}
        <p style="font-size:26px"> @inject('MurugoAuth', RwandaBuild\MurugoAuth\Facades\MurugoAuth::class)

            <a href="{{ $MurugoAuth::redirect()->getTargetUrl() }}">Login</a>

        </p>
    </div>
</body>

</html>
