<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Jonathan Watkins - BigChoice</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">

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

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .relative {
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
                font-size: 84px;
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

            .m-b-md {
                margin-bottom: 30px;
            }

            .block {
                display: block;
            }
            .p-1{padding: 0.25rem;}
            .mr-2{	margin-right: 0.5rem;}
            .w-20 {
                width: 5rem;
            }
            .flex{
                display: flex;
            }
            .justify-end{
                justify-content: flex-end;
            }

            td{
                padding: .25rem;
            }
        </style>
    </head>
    <body>
        <div class="flex relative @if(!isset($countries) || !$countries->count()) h-screen justify-center items-center @else items-start  @endif">
            @include('searchForm')
            @include('results')
        </div>
    </body>
</html>
