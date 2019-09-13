<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Ticket</title>
    <link rel="stylesheet" href="dist/app.scss" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:400,500,700,400italic|Material+Icons">
    <style rel="stylesheet" type="text/css">
        *,
        :after,
        :before {
            box-sizing: border-box transition: all ease-in-out 150ms;
        }

        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            height: 100vh;
            margin: 0;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
            -ms-overflow-style: scrollbar;
            -webkit-tap-highlight-color: rgba(0, 0, 0, 0)
        }

        .konten {
            margin-right: 5vw;
            margin-left: 5vw;
        }

        .full-height-title {
            height: 10vh;
            background-color: #3c6382;
        }

        .full-height-title>h1 {
            font-size: xx-large;
            color: azure;
        }

        .full-height-content {
            height: 100vh;
            font-size: 19px;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
            font-family: 'Nunito', sans-serif;
        }

        .position-ref {
            position: relative;
        }

        ul.paginate-links {
            display: inline-flex;
            list-style-type: none;
            margin-right: 10px;
        }

        ul.paginate-links>li.number.active>a{
            background-color: #b71540;
            color: #fff;
        }

        ul.paginate-links>li.number>a {
            display: block;
            color: #636B6f;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
            padding-block-start: 10px; 
        }
        ul.paginate-links>li.ellipses>a {
            display: block;
            color: #636B6f;
            text-align: center;
            cursor: pointer;
            text-decoration: none;
            padding-block-start: 10px;
        }

        ul.paginate-links>li.left-arrow>a {
            display: block;
            color: #636B6f;
            width: 100%;
            height: 100%;
            padding-left: 10px;
            padding-right: 10px;
            padding-top: 10px;
            padding-bottom: 10px;
            cursor: pointer;
            text-decoration: none;
        }

        ul.paginate-links>li.right-arrow>a {
            display: block;
            color: #636B6f;
            width: 100%;
            height: 100%;
            padding-left: 10px;
            padding-right: 10px;
            padding-top: 10px;
            padding-bottom: 10px;
            cursor: pointer;
            text-decoration: none;
        }


        span.page-item {
            display: inline-block;
            padding-top: 10px;
            padding-bottom: 10px;
            margin-top: 14px;
            margin-bottom: 14px;
        }

        </style>
</head>

<body>
    <div class="flex-center full-height-title">
        <h1>Request Ticketing</h1>
    </div>
    <div id="app" class="konten">
        <p class="vlink">
            <router-link to="/masuk">form masuk ticket</router-link>
            <router-link to="/asd">tes</router-link>
            <router-link to="/tesapi">tesapi</router-link>
        </p>
        <router-view></router-view>
    </div>
    <script src="dist/app.js"></script>
    <!-- Required MDC Web JavaScript library -->
    <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
</body>

</html>