<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Settimana Flessibile Galilei PG</title>
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/bootstrap.min.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/font-awesome.min.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/bootstrap-theme.min.css') }}"/>

    </head>
    <body>
        <div class="container fluid">
            <?php $name = "Orazio Grinzosi"; $class = "5L"; ?>
            @include('partials._header')  
        </div>
        <div class="container fluid">
            <div class="row fluid">
                <div class="col-md-4 col-sm-12">
                    @yield('navigation')
                </div>
                <div class="col-md-8 col-sm-12">
                    @yield('content')
                </div>
            </div>
        </div>
        <script type="text/javascript" src="{{ URL::asset('js/jquery-3.1.1.min.js') }}"></script>
        <script type="text/javascript" src="{{ URL::asset('js/bootstrap.min.js') }}"></script>

    </body>
</html>
