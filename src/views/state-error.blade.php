<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="authoring-tool" content="Murugo Cloud" />
    <title>Murugo Cloud</title>
    <link rel="icon" href="images/Icon@1x.png" type="image/gif" sizes="16x16" />
       <script src="https://kit.fontawesome.com/c3877622d0.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-140040130-2"></script>
    <style>
        .error-conatiner {
            width: 100%;
            text-align: center;
        }

        .error-conatiner a {
            text-decoration: none;
            color: #3490dc;
            margin-top: 20px
        }
    </style>
</head>
<body>
    <div class="murugo-top-section-wrapper" style="height:20vh">
        <div class="murugo-top-section-container bg-white">
            <div id="murugocloudanimation_hype_container">
                <script  type="text/javascript" src="../public/js/murugocloudanimation_hype_generated_script.js"></script>
                <script type="text/javascript" charset="utf-8"
                    src="{{ asset('js/murugocloudanimation_hype_generated_script.js?92246') }}"></script>
            </div>
        </div>
    </div>
    <div class="error-conatiner">
        {{ $message }}
        @inject('MurugoAuth', RwandaBuild\MurugoAuth\Facades\MurugoAuth::class)
        <a href="{{ $MurugoAuth::redirect()->getTargetUrl() }}">Login</a>
    </div>
</body>

</html>
