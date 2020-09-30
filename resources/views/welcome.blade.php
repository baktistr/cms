<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 80px;
            }

            .subtitle {
                font-size: 40px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/backoffice') }}">Home</a>
                    @else
                        <a href="{{ url('backoffice/login') }}">Login</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <img src="{{ asset('img/telkom-logo.svg') }}" alt="">
                <div class="title">
                    Telkom Property
                </div>

                <div class="subtitle">
                    {{ config('app.name') }}
                </div>
                @if (env('APP_ENV') == 'local')
                <div>
                    Super admin email: <strong>superadmin1@cms.irent.id</strong> password: <strong>password</strong>
                </div>
                @endif
            </div>
        </div>
    </body>
</html>
