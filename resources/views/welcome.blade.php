  <!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <title>ระบบเก็บคะแนนเสียงเลือกตั้ง</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
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
                font-size: 30px;
            }

            .links > a {
                color: #000000;
                padding: 0 25px;
                font-size: 20px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
        <style>
        .bgimg-1, .bgimg-2, .bgimg-3 {
          position: relative;
          opacity: 0.65;
          background-position: center;
          background-repeat: no-repeat;
          background-size: cover;

        }
        .bgimg-1 {
          background-image: url("image/bg_login.jpg");
          height: 100%;
        }

        .caption {
          position: absolute;
          left: 0;
          top: 50%;
          width: 100%;
          text-align: center;
          color: #000;
        }

        .caption span.borderlogin {
          background-color: #111;
          color: #fff;
          padding: 18px;
          font-size: 25px;
          letter-spacing: 10px;
        }

        h3 {
          letter-spacing: 5px;
          text-transform: uppercase;
          font: 20px "Lato", sans-serif;
          color: #111;
        }
        </style>
        <style>
          .btn {
            border: none;
            color: white;
            padding: 14px 28px;
            font-size: 16px;
            cursor: pointer;
          }
          .default {background-color: #e7e7e7; color: black;} /* Gray */
          .default:hover {background: #ddd;}
          </style>
    </head>
    <body>
      <div class="bgimg-1">
        <div class="flex-center position-ref full-height">
            <!-- @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else

                    @endauth
                </div>
            @endif -->
         <div class="caption">
            <div class="content">
                <div class="title m-b-md">
                    <span class="borderlogin">เก็บคะแนนเสียงเลือกตั้ง</span><br><br>
                    <div class="links">
                        <a href="{{ url('login') }}" class="btn default">Master</a>
                        <a href="{{ url('header') }}" class="btn default">Header</a>
                        <a href="{{ url('admin') }}" class="btn default">Admin</a>
                    </div>

            </div>
        </div>
      </div>
      </div>
    </body>
</html>
