<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JMI Task Tracking System</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.2/css/bootstrap.min.css" integrity="sha512-CpIKUSyh9QX2+zSdfGP+eWLx23C8Dj9/XmHjZY2uDtfkdLGo0uY12jgcnkX9vXOgYajEKb/jiw67EYm+kBf+6g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        // Colors
        $text: white;
        $link: #e34234;
        $link-hover: #ba160c;

        canvas {
            display: block;
            vertical-align: bottom;
        }

        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;

            background: {
                image: url(https://marcbruederlin.github.io/particles.js/img/background.jpg);
                position: bottom;
                repeat: no-repeat;
                color: black;
                size: cover;
            }
        }

        .text {
            color: $text;
            max-width: 90%;
            padding: 2em 3em;
            background: rgba(0, 0, 0, 0.45);
            text-shadow: 0px 0px 2px #131415;
            font-family: 'Open Sans', sans-serif;
        }

        .text a {
            text-decoration: none;
            color: white;
            font-size: 34px;
        }

        .text a:hover {
            color: #0e84b5;
            cursor: pointer;
        }

        h1 {
            font-size: 2.25em;
            font-weight: 700;
            letter-spacing: -1px;
        }

        a,
        a:visited {
            color: $link;
            transition: 0.25s;
        }

        a:hover,
        a:focus {
            color: $link-hover;
        }

        .min-height-100vh {
            min-height: 100vh;
        }

        #my-canvas {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .content-wrappwer {
            z-index: 1;
        }
         .footer-logo {
            width: 55px;
            height: 55px;
        }

        

    </style>
</head>
<body>
    <div id="particles-js"></div>
    <canvas id="my-canvas" class="custom-canvas"></canvas>

    <div class="content-wrappwer d-flex flex-column align-items-center justify-content-center min-height-100vh position-relative">
        <div class="text">
             <a href="{{route('get.login')}}">JMI Product Tracking System</a>
        </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js" integrity="sha512-Kef5sc7gfTacR7TZKelcrRs15ipf7+t+n7Zh6mKNJbmW+/RRdCW9nwfLn4YX0s2nO6Kv5Y2ChqgIakaC6PW09A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-confetti@latest/dist/js-confetti.browser.js"></script>

</body>
</html>
