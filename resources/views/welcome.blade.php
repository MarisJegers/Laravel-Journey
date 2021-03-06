

<!-- otrs variants -->
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Ceļazīmes</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                background-image: url('image/myimage.jpg');
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
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
                font-size: 4em;
            }
            .title small {
                font-size: 1em;
            }
            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
            .m-b-md {
                margin-bottom: 30px;
            }
            .p {
                color: black;
                text-indent: 30px;
                text-transform: uppercase;
                }
                .hero-image {
                    background-image: url("image/myimage.jpg"); /* The image used */
                    background-color: #cccccc; /* Used if the image is unavailable */
                    height: 500px; /* You must set a specified height */
                    background-position: center; /* Center the image */
                    background-repeat: no-repeat; /* Do not repeat the image */
                    background-size: cover; /* Resize the background image to cover the entire container */
                }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Pieteikties</a>
                        {{-- <a href="{{ url('/register') }}">Register</a> --}}
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Kaskāde<br /><small>v.1.0</small>
                </div>

                <div class="links">
                    <!--<a href="https://laravel.com/docs">Documentation</a>-->
                    <p style="color: black">Veidots ar Laravel v.8</p>
                    <p style="color: black">Novembris, 2021.</p>
                </div>
            </div>
        </div>
    </body>
</html>
