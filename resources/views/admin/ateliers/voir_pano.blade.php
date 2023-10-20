<!DOCTYPE>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Atelier 2</title>

        <meta name="description" content="Atelier 2" />

        <meta name="keywords" content="vigny,Atelier2" />
        <meta name="medium" content="mult" />
        <meta name="video_height" content="480"></meta>
        <meta name="video_width" content="640"></meta>
        <link rel="image_src" href="vigny2data/thumbnail.jpg" />
        <!-- <meta name="directory" content="PATH/"></meta> -->
        <!-- <link rel="target_url" href="vigny2.html" /> -->
        <meta name="generator" content="Panotour Pro V2.5.0 64bits" />

        <meta name="viewport" content="target-densitydpi=device-dpi, width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui"/>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <style type="text/css">
            @-ms-viewport { width: device-width; }
            @media only screen and (min-device-width: 800px) { html { overflow:hidden; } }
            * { padding: 0; margin: 0; }
            html { height: 100%; }
            body { height: 100%; overflow:hidden; }
            @media only screen and (min-device-width : 320px) and (max-device-width : 568px) and (-webkit-min-device-pixel-ratio: 2) { body{ height: 100.18%; } }
            div#container { height: 100%; min-height: 100%; width: 100%; margin: 0 auto; }
            div#tourDIV {
                height:100%;
                position:relative;
                overflow:hidden;
            }
            div#panoDIV {
                height:100%;
                position:relative;
                overflow:hidden;
                -webkit-user-select: none;
                -khtml-user-select: none;
                -moz-user-select: none;
                -o-user-select: none;
                user-select: none;
            }
        </style>
        <!--[if !IE]><!-->
        {{ Html::script(asset('js/jquery/jquery.min.js')) }}
        {{ Html::script(asset('js/jquery/jquery-ui.js')) }}
        <!--<![endif]-->
        <!--[if lte IE 8]>
        <script type="text/javascript" src="vigny2data/lib/jquery-1.11.1.min.js"></script>
        <![endif]-->
        <!--[if gt IE 8]>
        <script type="text/javascript" src="vigny2data/lib/jquery-2.1.1.min.js"></script>
        <![endif]-->
        <?php
        $parts = explode("/", (string) $url_pano);
        $name = $parts[5];
        $id_pano = str_replace(".swf", "", (string) $url_pano);
        $pano_js = str_replace(".swf", ".js", (string) $url_pano);
        $pano_xml = str_replace(".swf", "_vr.js", (string) $url_pano);
        $pano_cursor = str_replace($name, "graphics/cursors_move_html5.cur", (string) $url_pano);
        ?>

        <style type="text/css">
            div#panoDIV.cursorMoveMode {
                cursor: move;
                cursor: url("{{asset($pano_cursor)}}"), move;
            }
            div#panoDIV.cursorDragMode {
                cursor: grab;
                cursor: -moz-grab;
                cursor: -webkit-grab;
                cursor: url("{{asset($pano_cursor)}}"), default;
            }
        </style>

        <script type="text/javascript">
            function webglAvailable() {
                try {
                    var canvas = document.createElement("canvas");
                    return !!window.WebGLRenderingContext && (canvas.getContext("webgl") || canvas.getContext("experimental-webgl"));
                } catch (e) {
                    return false;
                }
            }
            function getWmodeValue() {
                var webglTest = webglAvailable();
                if (webglTest) {
                    return 'direct';
                }
                return 'opaque';
            }
            function readDeviceOrientation() {
                // window.innerHeight is not supported by IE
                var winH = window.innerHeight ? window.innerHeight : jQuery(window).height();
                var winW = window.innerWidth ? window.innerWidth : jQuery(window).width();
                //force height for iframe usage
                if (!winH || winH == 0) {
                    winH = '100%';
                }
                // set the height of the document
                jQuery('html').css('height', winH);
                // scroll to top
                window.scrollTo(0, 0);
            }
            jQuery(document).ready(function () {
                if (/(iphone|ipod|ipad|android|iemobile|webos|fennec|blackberry|kindle|series60|playbook|opera\smini|opera\smobi|opera\stablet|symbianos|palmsource|palmos|blazer|windows\sce|windows\sphone|wp7|bolt|doris|dorothy|gobrowser|iris|maemo|minimo|netfront|semc-browser|skyfire|teashark|teleca|uzardweb|avantgo|docomo|kddi|ddipocket|polaris|eudoraweb|opwv|plink|plucker|pie|xiino|benq|playbook|bb|cricket|dell|bb10|nintendo|up.browser|playstation|tear|mib|obigo|midp|mobile|tablet)/.test(navigator.userAgent.toLowerCase())) {
                    // add event listener on resize event (for orientation change)
                    if (window.addEventListener) {
                        window.addEventListener("load", readDeviceOrientation);
                        window.addEventListener("resize", readDeviceOrientation);
                        window.addEventListener("orientationchange", readDeviceOrientation);
                    }
                    //initial execution
                    setTimeout(function () {
                        readDeviceOrientation();
                    }, 10);
                }
            });

            function accessWebVr() {
                unloadPlayer();

                setTimeout(function () {
                    loadPlayer(true);
                }, 100);
            }
            function accessStdVr() {
                unloadPlayer();

                setTimeout(function () {
                    loadPlayer(false);
                }, 100);
            }
            function loadPlayer(isWebVr) {
                if (isWebVr) {
                    embedpano({
                        id: "krpanoSWFObject"
                        , xml: "{{asset($pano_xml)}}"
                        , target: "panoDIV"
                        , passQueryParameters: true
                        , bgcolor: "#000000"
                        , html5: "only+webgl"
                        , vars: {skipintro: true, norotation: true}
                    });
                } else {
                    embedpano({
                        id: "krpanoSWFObject"

                        , swf: "{{asset($url_pano)}}"

                        , target: "panoDIV"
                        , passQueryParameters: true
                        , bgcolor: "#000000"

                        , html5: "prefer"


                    });
                }
                //apply focus on the visit if not embedded into an iframe
                if (top.location === self.location) {
                    kpanotour.Focus.applyFocus();
                }
            }
            function unloadPlayer() {
                if (jQuery('#krpanoSWFObject')) {
                    removepano('krpanoSWFObject');
                }
            }


            //CREATION POINTS
            $(document).ready(function ()
            {
                var krpano = document.getElementById("krpanoSWFObject");
                if (krpano && krpano.get)
                {
                    krpano.call("screentosphere({{$h}}, {{$v}}, mouseath, mouseatv); js(creerpoint());");


                }

                function creerpoint()
                {
                    krpano.call("addhotspot(essaipoint)");
                    //IMAGE DU POINT
                    krpano.set("hotspot[essaipoint].url", "{{asset('css/img/ICONE_TEXTE_TRANSPARENT')}}");
                    //ABCISSE DU POINT(h)                
                    krpano.set("hotspot[essaipoint].ath", mouseath);
                    //ORDONNEE DU POINT(v)                
                    krpano.set("hotspot[essaipoint].atv", mouseatv);
                    krpano.set("hotspot[essaipoint].visible", true);

                }
            });






            //
        </script>
    </head>
    <body>
        <?php
        var_dump($parts);
        ?>
        <a href="{{ url('/admin') }}"><div id="icon_admin"></div><div class="libelle">Administration</div></a>
        <div id="container">

            <div id="tourDIV">
                <div id="panoDIV">
                    <noscript>


                    <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="100%" height="100%" id="{{$id_pano}}">
                        <param name="movie" value="{{asset($url_pano)}}"/>
                        <param name="allowFullScreen" value="true"/>
                        <!--[if !IE]>-->
                        <object type="application/x-shockwave-flash" data="{{$url_pano}}" width="100%" height="100%">
                            <param name="movie" value="{{asset($url_pano)}}"/>
                            <param name="allowFullScreen" value="true"/>
                            <!--<![endif]-->
                            <a href="http://www.adobe.com/go/getflash">
                                <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player to visualize the Virtual Tour : vigny2 (Virtual tour generated by Panotour)"/>
                            </a>
                            <!--[if !IE]>-->
                        </object>
                        <!--<![endif]-->
                    </object>

                    </noscript>
                </div>

                <script type="text/javascript" src="{{asset($pano_js)}}"></script>
                <script type="text/javascript">
    accessStdVr();
                </script>
            </div>
        </div>

    </body>

</html>
