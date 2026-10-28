<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PMCSFES v2</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="{{ asset('public/images/favicon.ico') }}">

    @include('shared.css_links.css_links')
    </head>
    <body class="hold-transition sidebar-mini">
        <div class="wrapper">
            <form action="{{ url('../RapidX') }}">
            {{-- <form action="{{ url('https:pornhub.com') }}"> --}}
                <button type="submit" class="btn btn-warning position-absolute mt-3 ml-3"><i class="fa fa-xl fa-arrow-left"></i>&nbsp; <strong>Go back to RapidX and log-in again</strong></button>
            </form>
            <img src="{{ asset('public/images/Facility.jpg') }}" alt="" style="height:100%; width:100%;">
        </div>
        @include('shared.js_links.js_links')
        @yield('js_content')

        <script type="text/javascript">
            $(document).ready(function(){

            });
        </script>
    </body>
</html>
