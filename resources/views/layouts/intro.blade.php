<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        {{ Html::style(asset('css/intro.css')) }}
        <link rel="icon" type="image/png" href="{{ URL::asset('img/splash.png') }}" />
        {{ Html::style(asset('css/google/google-fonts.css')) }}

        {{ Html::script(asset('js/jquery/jquery.min.js')) }}
        {{ Html::script(asset('js/TweenMax.min.js')) }}
        {{ Html::script(asset('js/Draggable.min.js')) }}
        {{ Html::script(asset('js/CSSPlugin.min.js')) }}
        {{ Html::script(asset('js/IntegralImage.js')) }}

        @yield('header')
        <title>GeoVISIT</title>


        <!-- Styles -->
        <style>
            @yield('styles')
        </style>

    </head>
    <body>


        @yield('content')


        <!-- JavaScripts -->

        @yield('scripts')

    </body>
</html>
