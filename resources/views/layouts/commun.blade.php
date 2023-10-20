<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="img/splash.png" />
    {{ Html::style('css/google/google-fonts.css')) }}
        @yield('header')
    <title>GeoVISIT</title>

   
    <!-- Styles -->
        <style>
        @yield('styles')
        </style>
    
</head>
<body id="app-layout">
   
        <div class="container">
        
            @yield('content')
         </div>
    
    
 <!-- JavaScripts -->

    @yield('scripts')
</body>
</html>
    