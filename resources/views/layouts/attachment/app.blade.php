<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>{{ env('APP_NAME') }}</title>
        <!-- Bootstrap Core CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
        <!-- QUOTATION CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/quotation.css?v=') }}{{env('ASSET_VERSION', 1)}}">
        <!-- EPOLIS CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/epolis.css') }}">

</head>
<body>
    <div id="page-wrapper">
        <div class="row ds-cs-nomargin">
            <div class="col-lg-12 ds-cs-nopadding">
                <center>
                    <img class="header-quotation" src="{{ asset('assets/img/header-2-LGI.png') }}">
                </center>
            </div>
        </div>

        <div class="row ds-cs-nomargin ds-cs-content">
            <div class="col-lg-12 ds-cs-nopadding">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
