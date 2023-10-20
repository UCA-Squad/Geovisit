<?php

/* 
 * 
 * 
 * Observatoire de Physique du Globe de Clermont-Ferrand
 * Campus Universitaire des Cezeaux
 * 4 Avenue Blaise Pascal
 * TSA 60026 - CS 60026
 * 63178 AUBIERE CEDEX FRANCE
 * 
 * Author: Yannick Guehenneux
 *         y.guehenneux [at] opgc.fr
 * 
 */

?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        {{ Html::style(asset('js/pannellum/pannellum.css')) }}
        <style>
            html {
                height: 100%;
            }

            body {
                height: 100%;
            }

            .overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: #000;
                filter: alpha(opacity=50);
                -moz-opacity: 0.5;
                -khtml-opacity: 0.5;
                opacity: 0.85;
                z-index: 10000;
            }
        </style>
        {{ Html::script(asset('js/jquery/jquery.min.js')) }}
        {{ Html::script(asset('js/pannellum/pannellum.js')) }}
        {{ Html::script(asset('js/howler/howler.js')) }}
        {{ Html::script(asset('js/TweenMax.min.js')) }}
    </head>
    <body>
        <div id="panorama"></div>
    </body>
    <script>
        var fov;
        var fovBounds;

        var pan = pannellum.viewer('panorama', {
            type: 'equirectangular',
            panorama: "{{ asset($url . '/pano.jpg') }}",
            autoLoad: true,
            showControls: true,
            showFullscreenCtrl: false,
            hfov: 120,
            haov: {{ $atelier->haov }},
            vaov: {{ $atelier->vaov }},
            vOffset:  {{ $atelier->vOffset }}
        });

        var sceneLoadListener = function() {
            $('#overlay_temp').click();
            $('#zoomNomAtelier').empty();
            $('#zoomNomAtelier').append('Titre Atelier n°{{ $atelier->id }}');
            $('#zoomOverlay').show();
        };

        pan.on('load', sceneLoadListener);

        setInterval(function() {
            fov = pan.getHfov();
            fovBounds = pan.getHfovBounds();
            $('#ligneZoom').css({top: (-520*(fovBounds[0] - fov) - (fovBounds[1] - fovBounds[0]) * 560) / (fovBounds[1] - fovBounds[0]) + 'px'});
            $('#zoomNbExercices').css({top: (-520*(fovBounds[0] - fov) - (fovBounds[1] - fovBounds[0]) * 560) / (fovBounds[1] - fovBounds[0]) + 'px'});
        }, 30);

        var snd_360 = new Howl({
            urls: ['{{$url}}/snd.mp3'],
            loop: true,
            volume: 0.3
        });
        snd_360.play();

        snd_soundscape.fadeOut(0.0, snd_fadeLength);
        snd_wind.fadeOut(0.0, snd_fadeLength);
        snd_kalimba.fadeOut(0.0, snd_fadeLength);
        snd_insitu = true;
    </script>
</html>