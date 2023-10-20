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

if ($id != 0) {
    $tpn = App\Models\Tpn::find(App\Models\Atelier_tpn::find($id)->tpn_id);
    $atelier_titre = App\Models\Atelier_tpn::find($id)->titre_atelier;

    $hotspots = [];
    $exercices = App\Models\Atelier_tpn::find($id)->exercices;
    foreach ($exercices as $exercice) {
        array_push($hotspots, ['yaw' => $exercice->x, 'pitch' => $exercice->y * -1, 'cssClass' => $exercice->type . ($exercice->isDone(Auth::user()->userable_id) > 0 ? 'Done' : ''), 'clickHandlerArgs' => ['id' => $exercice->id, 'type' => $exercice->type, 'site' => $atelier->site->titre, 'prof' => $tpn->professeur->user->prenom . ' ' . $tpn->professeur->user->nom, 'content' => str_replace(['\n', '\r', CHR(10), CHR(13), PHP_EOL], "", (string) $exercice->contenu)]]);
    }
} else {
    $atelier_titre = '';
}
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        {{ Html::style(asset('js/pannellum/pannellum.css')) }}
        {{ Html::style(asset('css/exercices.css')) }}
        <style>
            html {
                height: 100%;
            }

            body {
                height: 100%;
                margin: 0px;
            }
            
            .video {
                height: 66px;
                width: 66px;
                background-image: url('../img/iconeVideo_none.png');
                cursor: pointer;
            }

            .photo {
                height: 66px;
                width: 80px;
                background-image: url('../img/iconePhoto_none.png');
                cursor: pointer;
            }

            .texte {
                height: 106px;
                width: 78px;
                background-image: url('../img/iconeArticle_none.png');
                cursor: pointer;
            }
            
            .qcm {
                height: 66px;
                width: 66px;
                background-image: url('../img/iconeQcm_none.png');
                cursor: pointer;
            }
            
            .qcmDone {
                height: 66px;
                width: 66px;
                background-image: url('../img/iconeQcm.png');
                cursor: pointer;
            }

            .videoDone {
                height: 66px;
                width: 66px;
                background-image: url('../img/iconeVideo.png');
                cursor: pointer;
            }

            .photoDone {
                height: 66px;
                width: 80px;
                background-image: url('../img/iconePhoto.png');
                cursor: pointer;
            }

            .texteDone {
                height: 106px;
                width: 78px;
                background-image: url('../img/iconeArticle.png');
                cursor: pointer;
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
        
        var displayExercice = function (evt, args) {

            if ($('#overlay_temp').length === 0) {
                $('body').append('<div id="overlay_temp" class="overlay"></div>');
                $('#overlay_temp').click(function (e) {
                    $('#overlay_temp').remove();
                    TweenLite.to($('#container'), 1, {autoAlpha: 1});
                    TweenLite.to($('#endroit'), 0, {autoAlpha: 0.5});
                });
            }

            $('#overlay_temp').css({'z-index': '50000'});
            $('#overlay_temp').empty();
            $('#overlay_temp').load("{{ url('/exercice') }}", function () {
                if (args.type !== 'qcm') {
                    $('#oc_texte').append(args.content);
                } else {
                    $('#oc_texte').load(host + '/qcm/' + JSON.parse(args.content).qcm_id, function() {
                    });
//                    $.ajax({
//                        url: host + '/qcm/' + JSON.parse(args.content).qcm_id,
//                        method: 'GET',
//                        success: function(data) {
//                            console.log(data);
//                        }
//                    });
                }
                $('#nom_site').append(args.site.toUpperCase());
                $('#nom_responsable_site').append(args.prof);
                $('#overlay_temp').css({opacity: 0.85});
                TweenLite.to($('#overlay_temp'), 0.5, {autoAlpha: 0.85});
            });

            TweenLite.to($('#container'), 0, {autoAlpha: 0});
            TweenLite.to($('#endroit'), 0.5, {autoAlpha: 0});

            if ($('#icon_active')) {
                $('#icon_active').remove();
            }  
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            
            $.ajax({
                url: "{{ url('/exercice_user') }}",
                type: 'POST',
                data: {
                    exercice: args.id
                },
                error: function(error) {
                    console.log(error);
                },
                success: function(result) {
                    if (result.new) {
                        var nb = $('#realise').html();
                        nb++;
                        $('#realise').empty();
                        $('#realise').html(nb);
                        $(evt.target).removeClass(args.type);
                        $(evt.target).addClass(args.type + 'Done');
                        interets.find(x => x.point === {{ App\Models\Atelier_tpn::find($id)->atelier_id }}).nbExercicesFaits = nb;
                    }
                }
            });
        };

        var hotspots = {!! json_encode($hotspots) !!};

        hotspots.forEach(function (point) {
            point.clickHandlerFunc = displayExercice;
        });

        var pan = pannellum.viewer('panorama', {
            type: 'equirectangular',
            panorama: "{{ asset($url . '/pano.jpg') }}",
            autoLoad: true,
            showControls: true,
            showFullscreenCtrl: false,
            hfov: 120,
            hotSpots: hotspots,
            haov: {{ $atelier->haov }},
            vaov: {{ $atelier->vaov }},
            vOffset:  {{ $atelier->vOffset }}
        });

        var sceneLoadListener = function () {
            $("#overlay_temp").click();
            $('#zoomNomAtelier').empty();
            $('#zoomNomAtelier').append('{{ $atelier_titre }}');
            $('#realise').empty();
            $('#realise').append('{{ Auth::user()->exercices()->whereAtelier_tpn_id($id)->count() }}');
            $('#total').empty();
            $('#total').append('{{ count($exercices) }}');
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

        setTimeout(function () {
            if(pan.isLoaded() === undefined) {
                pan.destroy();
                var originalImageURL = "{{ asset($url . '/pano.jpg') }}";
                var newWidth = 1920;
                var newHeight = 1080;
                getMeta(originalImageURL, (err, img) => {
                    newWidth = img.naturalWidth * 0.9;
                    newHeight= img.naturalWidth * 0.9;
                });
                getOriginalSizeAndResize(newWidth, newHeight, originalImageURL);
            }
        }, 300);
        function getOriginalSizeAndResize(newWidth,newHeight, originalImageURL) {
            resizeImage(originalImageURL, newWidth, newHeight, function(resizedImageUrl) {
                pan = pannellum.viewer('panorama', {
                    "type": "equirectangular",
                    "panorama": resizedImageUrl,
                    autoLoad: true,
                    showControls: true,
                    showFullscreenCtrl: false,
                    hfov: 120,
                    hotSpots: hotspots,
                    haov: {{ $atelier->haov }},
                    vaov: {{ $atelier->vaov }},
                    vOffset:  {{ $atelier->vOffset }}
                });
                setTimeout(function () {
                    if(pan.isLoaded() === undefined) {
                        pan.destroy();
                        getOriginalSizeAndResize(newWidth*0.9, newHeight*0.9, originalImageURL);
                    }
                }, 100);
            });
        }
        function resizeImage(imageUrl, newWidth, newHeight, callback) {
            var img = new Image();
            img.onload = function() {
                var canvas = document.createElement('canvas');
                canvas.width = newWidth;
                canvas.height = newHeight;
                var ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, newWidth, newHeight);
                var resizedImageUrl = canvas.toDataURL(); // Convert the canvas to a data URL
                callback(resizedImageUrl);
            };
            img.src = imageUrl;
        }

        const getMeta = (url, cb) => {
            const img = new Image();
            img.onload = () => cb(null, img);
            img.onerror = (err) => cb(err);
            img.src = url;
        };

    </script>
</html>