<?php

$interets = [];
$points = [];

if ($site->ateliers->count() > 0) {
    foreach($site->ateliers as $atelier) {
        array_push($interets, ['point' => $atelier->id, 'image' => url('/') . $atelier->image, 'abscisse' => $atelier->timeline * 100, 'radius' => $atelier->rayon, 'adresse' => $atelier->lien_360, 'legende' => 'Titre Atelier n°' . $atelier->id, 'coordX' => $atelier->x_sommaire, 'coordY' => $atelier->y_sommaire, 'site' => $atelier->site->titre, 'description' => 'Description Atelier n°' . $atelier->id, 'nbExercices' => 0, 'nbExercicesFaits' => 0, 'mapX' => $atelier->x_carte, 'mapY' => $atelier->y_carte, 'idtpn' => 0]);
        
        array_push($points, ['lat' => $atelier->x_carte, 'lon' => $atelier->y_carte]);
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link rel="icon" type="image/png" href="{{URL::asset('img/splash.png') }}" />

        @yield('header')
        
        <title>Visualisation site</title>


        <!-- Styles -->        
        {{ Html::style(asset('css/final.css')) }}
        {{ Html::style(asset('css/google/google-fonts.css')) }}
        {{ Html::style(asset('css/zoom.css')) }}
        {{ Html::style(asset('js/leaflet/leaflet.css')) }}
        @yield('styles')
        
        {{ Html::script(asset('js/jquery/jquery.min.js')) }}
        {{ Html::script(asset('js/TweenMax.min.js')) }}
        {{ Html::script(asset('js/Draggable.min.js')) }}
        {{ Html::script(asset('js/CSSPlugin.min.js')) }}
        {{ Html::script(asset('js/vivus.min.js')) }}
        {{ Html::script(asset('js/chain_selector.js')) }}
        {{ Html::script(asset('js/howler/howler.js')) }}
        {{ Html::script(asset('js/leaflet/leaflet.js')) }}
        {{ Html::script(asset('js/admin/map.js')) }}
        
        @yield('scripts.header')
        
        <script>
            var interets = [];
            var snd_wind = new Howl({urls:["{{URL::asset('snd/wind.mp3')}}"], loop:true, volume:0.0, buffer:true});
            var snd_kalimba = new Howl({urls:["{{URL::asset('snd/kalimba.mp3')}}"], loop:true, volume:0.0});
            var dict = {!! $site->sound !!};
            var snd_soundscape = new ChainSelector(dict);
            var snd_la;
            var snd_firstTime = 0;
            var snd_insitu = false;
            var snd_fadeLength = 750;
            var chain_index = 0.0;
            var snd_on = true;
            var host = "{{ URL::to('/') }}";
            function toggleSound() {
                snd_on = !snd_on;
                if (snd_on == true) {
                    document.getElementById("mute").src = "{{URL::asset('img/sound_on.png')}}";
                    Howler.unmute();
                } else {
                    document.getElementById("mute").src = "{{URL::asset('img/sound_off.png')}}";
                    Howler.mute();
                }
            }
            snd_wind.play();
            snd_soundscape.play(0.0, 0.0);
        </script>
    </head>
    <body>
        <!--Vidéo du background-->
        <video id="v1" autobuffer preload autoplay>
                <!--<source src="vids/loya.mp4" type="video/mp4">-->
        </video>
        <!--Filtre vidéo-->
        <div id="overlay"></div>
        <!--Éléments de HUD : Menu latéral et pied de page-->
        <div id="burgermenu">
            <img src="{{ URL::asset('img/burgermenu.png') }}"/>
        </div>
        <div id="menuicon">
            <div id="menuicon_bloc">
                <div id="icon_intro"><img src="{{ URL::asset('img/icon_intro.png') }}"/></div>
                <div id="icon_circle"><img src="{{ URL::asset('img/icon_circle.png') }}"/></div>
                <div id="icon_location"><img src="{{ URL::asset('img/icon_location.png') }}"/></div>
                <div id="icon_user"><img src="{{ URL::asset('img/icon_user.png') }}"/></div>
            </div>
        </div>
        <div id="footer">
            <div id="universite">© 2016-2020  Universtié Clermont Auvergne & Université Pierre Marie Curie</div>
            <img id="expand" src="{{ URL::asset('img/icon_expand.png') }}" />
            <div id="tutoriel">Tutoriel</div>
            <img id="img_tuto" src="{{ URL::asset('img/icon_tuto.png') }}" />
        </div>
        <div id="endroit">
            <div id="endroit_bloc">
                <div id="tp_endroit"></div>
                <div id="nom_endroit">{!!strtoupper($site->titre)!!}</div>
                <div id="responsable_endroit">Enseignant <span id="nom_responsable_endroit"></span></div>
            </div>
        </div>
        <!--Frise chronologique-->
        <div id="container" width="100%" height="100%">
            <canvas id="canvas" width="5000px" height="500px">
            </canvas>
        </div>
        <div id="legende">
            <div id="nomAtelier"></div>
            <div id="numAtelier"></div>
        </div>
        <svg id="tracker">
        <path stroke="#E2714B" data-start="20" data-duration="50" d="M50 300 L50 150"/>
        <path fill="none" stroke="#E2714B" stroke-width="5" data-start="0" data-duration="20" d="M43,305a7.087,7.087 0 1,0 14.174,0a7.087,7.087 0 1,0 -14.174,0"/>
        </svg>	
        <div id="overlay_temp"></div>
        <div id="overlay_pano"></div>
        <div id="zoomOverlay" style="display: none;">
            <div id="zoomBloc">
                <div id="zoomHaut">MAX</div>
                <div id="zoomBar">
                    <svg id="ligneZoom" width="80" height="1200">
                        <path stroke="#ffffff"  stroke-width="2" d="M40 0 L40 562"/>
                        <path stroke="#fa7346"  stroke-width="2" d="M40 638 L40 1200"/>
                        <circle id="cerclePasFait" cx="40" cy="600" r="38"fill="none" stroke="#ffffff" stroke-width="2" />
                        <circle id="cercleFait" cx="40" cy="600" r="38"fill="none" stroke="#fa7346" stroke-width="2" />
                    </svg>
                    <div id="zoomNbExercices">
                        <span id="realise"></span> / <span id="total"></span>
                        <br/>EXERCICES
                    </div>
                </div>
                <div id="zoomBas">MIN</div>
            </div>
            <div id="zoomEndroit">
                <div id="zoomEndroitBloc">
                   <div id="zoomNomAtelier"></div> 
                   <div id="zoomSite">Site&nbsp;<span id="zoomNomSite">{{ $site->titre }}</span></div>
                </div>
            </div>            
        </div>
        <div id="chargement">
            <div id="fondChargement"></div>
            <div id="animationChargement">
                <svg style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);" height="200" width="200">
                <circle cx="100" cy="100" r="75" fill="white" />
                </svg>
            </div>
            <div id="pourcentageChargement"></div>
        </div>

        @yield('content')

        <!-- JavaScripts -->
        @yield('scripts')
        <script>
            var myVideo = document.getElementById("v1");
            
            myVideo.src = "{{URL($site->video)}}";
            myVideo.play();
            myVideo.playbackRate = 2;
            
            myVideo.addEventListener('loadedmetadata', function() {
                var canvas;
                var ctx;
                var x = 0;
                var newX;
                var trackerAnim = new Vivus('tracker', {type: "scenario"});
                trackerAnim.reset();
                trackerAnim.stop();
                var container = document.getElementById("container");
                var sdTemp = - 1;
                var tl = new TimelineLite();
                tl.to($('#legende'), 0.3, {autoAlpha:1}, "+=0.7");
                tl.pause();
                var tl2 = [];
                var tl_overlay = new TimelineLite();
                //Valeur de la position du dernier cercle
                var cxMax = x;
                //Définir l'angle de la courbe
                var courbe = 20;
                //Définir la position de la fin de la vidéo
                var finVideo = myVideo.duration * 100;
                
                function compareNombres(a, b) {
                    return a - b;
                }
                
                //Substituant BDD - pt.2 (lien entre la base et le script)
                function remplirInterets(){
                    interets = {!! json_encode($interets) !!};
                    //Tri nécessaire pour dessiner la courbe
                    interets.sort(function(a, b) {
                        return a.abscisse - b.abscisse;
                    });
                }

                function center(i) {
                    x = i;
                    if (i > $(window).width() / 2){
                        i = $(window).width() / 2;
                    }

                    if (i < $(window).width() / 2 - (cxMax)){
                        i = $(window).width() / 2 - (cxMax);
                    }

                    for (j = 0; j < interets.length; j++){
                        TweenLite.to($('#sd' + interets[j].point), 0.3, {attr:{cx:x + (interets[j].abscisse)}});
                        if (i >= $(window).width() / 2 - (interets[j].abscisse) - 150 && i <= $(window).width() / 2 - (interets[j].abscisse) + 150){
                            tl2[j].play();
                            chargerLegende(j);
                            trackerAnim.play(2);
                            tl.play();
                        } else {
                            tl2[j].reverse();
                            if (sdTemp == j){
                                trackerAnim.play( - 4);
                                tl.reverse();
                                sdTemp = - 1;
                            }
                        }
                    }
                }

                function clear() {
                    ctx.clearRect(0, 0, $(window).width(), 500);
                }

                function draw() {
                    clear();
                    ctx.beginPath();
                    ctx.moveTo(x, 70);
                    ctx.quadraticCurveTo(x + ((interets[0].abscisse) / 2), 70, x + (interets[0].abscisse), 70);
                    ctx.strokeStyle = "white";
                    ctx.stroke();
                    courbe = courbe * ( - 1);

                    for (i = 1; i < interets.length; i++){
                        ctx.beginPath();
                        ctx.moveTo(x + (interets[i - 1].abscisse), 70);
                        ctx.quadraticCurveTo(x + (((interets[i - 1].abscisse) + (interets[i].abscisse)) / 2), 70 - courbe, x + (interets[i].abscisse), 70);
                        ctx.strokeStyle = "white";
                        ctx.stroke();
                        courbe = courbe * ( - 1);
                    }

                    ctx.beginPath();
                    ctx.moveTo(x + (interets[interets.length - 1].abscisse), 70);
                    ctx.quadraticCurveTo(x + (((interets[interets.length - 1].abscisse) + (finVideo)) / 2), 70, x + (finVideo), 70);
                    ctx.strokeStyle = "white";
                    ctx.stroke();
                    courbe = 20;
                }

                function chargerLegende(x){
                    if (sdTemp != x){
                        $("#nomAtelier").empty().append(interets[x].legende);
                        $("#numAtelier").empty().append("Atelier " + (x + 1));
                        $("#legende").css({"top": interets[x].coordY + "%", "left": interets[x].coordX + "%"});
                        $("#tracker").css({"top": interets[x].coordY + "%", "left": interets[x].coordX + "%"});
                        sdTemp = x;
                    }
                }

                function createOneCircle(i){
                    //Créer les timelines
                    tl2[i] = new TimelineLite();

                    //Créer les cercles
                    var svgElement = $('<svg class=\"cerclecont\" id=\"myPoint' + interets[i].point 
                            + '\" width=\"1000px\" height=\"500px\"><defs><pattern id=\"myImage' 
                            + interets[i].point + '\" x=\"0%\" y=\"0%\" height=\"100%\" width=\"100%\" viewBox=\"0 0 512 512\"><image x=\"0%\" y=\"0%\" width=\"512\" height=\"512\" xlink:href=\"' 
                            + interets[i].image + '\"></image></defs><circle id=\"sd' + interets[i].point + '\" class=\"cercle\" cx=\"' 
                            + (interets[i].abscisse) + 'px\" cy=\"70px\" r=\"' + interets[i].radius + 'px\" fill=\"url(#myImage' 
                            + interets[i].point + ')\" stroke=\"white\" stroke-width=\"2px\" stroke-opacity=\"0.7\" /></svg>');
                    $("#container").append(svgElement);

                    //Déplacer les cercles
                    TweenLite.to($('#sd' + interets[i].point), 0.3, {attr:{cx:x + (interets[i].abscisse)}}, "#center");

                    //Animation survol
                    tl2[i].to($('#sd' + interets[i].point), 0.3, {attr:{r:"60px"}}, "#over");
                    tl2[i].to($('#myImage' + interets[i].point), 0.3, {attr:{x:"-50%", y:"-50%", height:"200%", width:"200%"}}, "#over");
                    tl2[i].pause();

                    document.getElementById("sd" + interets[i].point).addEventListener("mousedown", function(e){
                        var park = $(window).width() / 2 - (interets[i].abscisse);
                        center(park);
                    });

                    function chargerOverlay(){
                        $("#oc_titre").empty().append(interets[i].legende);
                        $("#soustitre_site").empty().append(interets[i].site);
                        $("#oc_texte").empty().append("<br/>" + interets[i].description);
                        $("#oc_exercices").empty().append("<br/>" + "EXERCICES RÉALISÉS " + interets[i].nbExercicesFaits + "/" + interets[i].nbExercices);

                        $("#oc_boutonforme").click(function(){
                            //remplir nouveau layer au lieu du temp
                            $("#overlay_pano").empty();
                            $("#overlay_temp").empty();
                            $("#overlay_temp").css({"z-index": "50"});
                            $("#overlay_pano").css({"pointer-events":"all"});
                            trackerAnim.reset();
                            trackerAnim.stop();
                            tl.reverse();
                            TweenLite.to($("#container"), 0, {autoAlpha: 0});
                            if ($("#icon_active")) {
                                $("#icon_active").remove();
                            }
                            $("#overlay_pano").load("{{url('/demo')}}" + '/' + interets[i].point + '/0');
                        });
                        tl_overlay.to($("#overlay_temp"), 0.5, {autoAlpha: 0.85});
                    }

                    document.getElementById("sd" + interets[i].point).addEventListener("click", function(e){
                        sdTemp = i;
                        trackerAnim.reset();
                        trackerAnim.stop();
                        tl.reverse();
                        TweenLite.to($("#container"), 0, {autoAlpha: 0});
                        if ($("#icon_active")) {
                            $("#icon_active").remove();
                        }
                        $("#sd" + interets[i].point).css({"pointer-events": "none"});
                        $("#overlay_temp").css({"z-index": "500000008"});
                        $("#overlay_temp").empty();
                        $("#overlay_temp").load("{{url('/overlay')}}", chargerOverlay);
                    });
                }

                function clearTemp(){
                    $("#overlay_temp").empty();
                }

                function clearPano(){
                    $("#overlay_pano").empty();
                }

                $("#overlay_temp").click(function(e){
                    if ($("#overlay_temp").css("opacity") > 0 && e.target.id != "overlay_contenu" 
                            && e.target.id != "oc_boutonforme" && e.target.id != "afficher_grille" 
                            && e.target.id != "afficher_boussole" && e.target.id != "afficher_sentier" 
                            && e.target.id != "overlay_click" && e.target.id != "scrollbarrinette" 
                            && e.target.id != "img_site" && e.target.id != "bloc_identifiants" 
                            && e.target.id != "profil_mail_edit" && e.target.id != "profil_mdp_edit" 
                            && e.target.id != "profil_login" && e.target.id != "profil_mail" 
                            && e.target.id != "profil_mdp" && e.target.id != "edit_mail" 
                            && e.target.id != "edit_validation" && e.target.id != "edit_mdp" 
                            && e.target.id != "confirmation_mdp" && e.target.id != "edit_validation_bouton" 
                            && e.target.id != "edit_annulation_bouton" && e.target.id != "edit_mail_input" 
                            && e.target.id != "edit_validation_input" && e.target.id != "edit_mdp_input" 
                            && e.target.id != "confirmation_mdp_input" && e.target.id != "submitemail" 
                            && e.target.id != "submitmdp" && e.target.id != "map-tp"){

                        $("#overlay_temp").css({"background-color":"black"});
                        tl_overlay.to($("#overlay_temp"), 0.5, {autoAlpha: 0, onComplete:clearTemp});
                        $("#overlay_temp").css({"z-index": "50"});

                        if ($("#icon_active")) {
                            $("#icon_active").remove();
                        }

                        if ($("#overlay_pano").css("pointer-events") == "none"){
                            TweenLite.to($("#container"), 0, {autoAlpha: 1});
                            $("#icon_circle").append("<img id=\"icon_active\" style=\"position: absolute; width: 80px; height: 80px; top: 50%; left: 50%; transform: translate(-50%, -50%)\" src=\"{{ URL::asset('img/icon_active.png') }}\"/>");
                            TweenLite.to($("#endroit"), 0.5, {autoAlpha: 1, delay: 0.5});
                            if (sdTemp >= 0){
                                $("#sd" + interets[sdTemp].point).css({"pointer-events": "all"});
                                tl.play();
                                trackerAnim.play(2);
                            }
                        }
                    }
                });

                $("#icon_circle, #burgermenuimg").click(function (e) {
                    if ($("#overlay_pano").css("pointer-events") == "all"){
                        tl_overlay.to($("#overlay_temp"), 0.5, {autoAlpha: 0, onComplete:clearPano});

                        if ($("#icon_active")) {
                            $("#icon_active").remove();
                        }

                        if ($("#overlay_pano").css("pointer-events") == "all"){
                            TweenLite.to($("#container"), 0, {autoAlpha: 1});
                            $("#icon_circle").append("<img id=\"icon_active\" style=\"position: absolute; width: 80px; height: 80px; top: 50%; left: 50%; transform: translate(-50%, -50%)\" src=\"{{ URL::asset('img/icon_active.png') }}\"/>");
                            TweenLite.to($("#endroit"), 0.5, {autoAlpha: 1, delay: 0.5});
                            if (sdTemp >= 0){
                                $("#sd" + interets[sdTemp].point).css({"pointer-events": "all"});
                                tl.play();
                                trackerAnim.play(2);
                            }
                        }

                        $("#overlay_pano").css({"pointer-events": "none"});
                        $('#zoomOverlay').hide();
                    }
                });

                function lancerTuto(){
                    trackerAnim.reset();
                    trackerAnim.stop();
                    tl.reverse();
                    TweenLite.to($("#container"), 0, {autoAlpha: 0});
                    if ($("#icon_active")) {
                        $("#icon_active").remove();
                    }
                    $("#overlay_temp").css({"z-index": "500000008"});
                    $("#overlay_temp").empty();
                    $("#overlay_temp").load("{{url('/tutoriel')}}");
                    tl_overlay.to($("#overlay_temp"), 0.5, {autoAlpha: 0.85});
                }

                function lancerCarte(){
                    trackerAnim.reset();
                    trackerAnim.stop();
                    tl.reverse();
                    TweenLite.to($("#container"), 0, {autoAlpha: 0});
                    TweenLite.to($("#endroit"), 0.5, {autoAlpha: 0});

                    //afficher l'overlay sur l'icône actif
                    if ($("#icon_active")) {
                        $("#icon_active").remove();
                    }
                    $("#icon_location").append("<img id=\"icon_active\" style=\"position: absolute; width: 80px; height: 80px; top: 50%; left: 50%; transform: translate(-50%, -50%)\" src=\"{{ URL::asset('img/icon_active.png') }}\"/>");
                    $("#overlay_temp").css({"z-index": "500000008"});
                    $("#overlay_temp").empty();
                    $("#overlay_temp").load("{{ url('/carte/' . $site->id) }}", remplirCarte);
                    tl_overlay.to($("#overlay_temp"), 0.5, {autoAlpha: 0.85});
                }

                function remplirCarte(){
                    if ({{ $site->sig_map }}) {
                        if (sdTemp === -1) {
                            drawMapTp({!! json_encode($points) !!});
                        } else {
                            drawMapTp({!! json_encode($points) !!}, sdTemp);
                        }
                    } else {
                        $("#carte").attr({"src":"{{ URL::asset($site->img_mini_map) }}"}); //img carte du tpn
                        $("#sentier").attr({"src":"{{ URL::asset($site->img_sentier) }}"}); //sentier carte du tpn (si existant)

                        if (!$("#sentier").attr("src")){
                            $("#afficher_sentier").remove();
                        }

                        for (i = 0; i < interets.length; i++){
                            if (i == sdTemp){
                                $("#contenu_carte").append("<div id=\"point" + i + "\"><svg style=\"position:absolute; top:" 
                                        + interets[i].mapY + "%; left:" + interets[i].mapX 
                                        + "%; transform: translate(-50%, -50%);\" height=\"50\" width=\"50\"><circle id=\"point_anim\" cx=\"25\" cy=\"25\" r=\"20\" " 
                                        + "stroke=\"#e89261\" stroke-width=\"2px\"  stroke-dasharray=\"20\" stroke-opacity=\"1\" fill=\"#fa7346\" fill-opacity=\"0\" /><circle cx=\"25\" cy=\"25\" r=\"15\" fill=\"#fa7346\" fill-opacity=\"1\" /></svg></div>");
                                var point_anim = new TimelineMax({repeat: - 1});
                                point_anim.to($("#point_anim"), 2, {rotation:360, transformOrigin:"50% 50%", ease:Linear.easeNone});
                            } else {
                                $("#contenu_carte").append("<div id=\"point" + i + "\"><img style=\"position:absolute; top:" + interets[i].mapY + "%; left:" + interets[i].mapX + "%; transform:translate(-50%,-50%)\" src=\"{{ URL::asset('img/point.png') }}\"/></div>");
                            }
                        }
                    }
                }

                function majCercle(o){
                    if (o == - 1) {
                        o = 0;
                    }

                    if ($("#cercleImg1").css("opacity") > 0){
                        $("#img_ateliers2").attr("xlink:href", interets[o].image);
                        zoomCercle2.pause(0).clear();
                        $("#pattern_ateliers2").attr("x", "0%");
                        $("#pattern_ateliers2").attr("y", "0%");
                        $("#pattern_ateliers2").attr("height", "100%");
                        $("#pattern_ateliers2").attr("width", "100%");
                        TweenLite.to($("#cercleImg2"), 0, {autoAlpha: 0});
                        TweenLite.to($("#cercleImg1"), 0, {autoAlpha: 1});
                        zoomCercle2.to($("#cercleImg1"), 0.5, {autoAlpha: 0}, "animImg");
                        zoomCercle2.to($("#cercleImg2"), 0.5, {autoAlpha: 1, onComplete:function(){}}, "animImg");
                        zoomCercle2.to($("#pattern_ateliers2"), 2, {attr:{x:"-2.5%", y:"-2.5%", height:"105%", width:"105%"}}, "animImg").play();
                    } else {
                        $("#img_ateliers1").attr("xlink:href", interets[o].image);
                        zoomCercle1.pause(0).clear();
                        $("#pattern_ateliers1").attr("x", "0%");
                        $("#pattern_ateliers1").attr("y", "0%");
                        $("#pattern_ateliers1").attr("height", "100%");
                        $("#pattern_ateliers1").attr("width", "100%");
                        TweenLite.to($("#cercleImg1"), 0, {autoAlpha: 0});
                        TweenLite.to($("#cercleImg2"), 0, {autoAlpha: 1});
                        zoomCercle1.to($("#cercleImg2"), 0.5, {autoAlpha: 0}, "animImg");
                        zoomCercle1.to($("#cercleImg1"), 0.5, {autoAlpha: 1, onComplete:function(){}}, "animImg");
                        zoomCercle1.to($("#pattern_ateliers1"), 2, {attr:{x:"-2.5%", y:"-2.5%", height:"105%", width:"105%"}}, "animImg").play();
                    }

                    $("#ateliers_exercices_nombre").empty().append(interets[o].nbExercicesFaits + "/" + interets[o].nbExercices);
                    $("#ateliers_nom").empty().append(interets[o].legende);
                    TweenLite.to($("#cercleLigneFait"), 2.5, {
                        "stroke-dasharray": (rayonCercle * interets[o].nbExercicesFaits / interets[o].nbExercices) + " " + (rayonCercle * (interets[o].nbExercices - interets[o].nbExercicesFaits) / interets[o].nbExercices)
                    });
                    TweenLite.to($("#cercleLignePasFait"), 2.5, {
                        "stroke-dasharray": 0 + " " + (rayonCercle * interets[o].nbExercicesFaits / interets[o].nbExercices) + " " + (rayonCercle * (interets[o].nbExercices - interets[o].nbExercicesFaits) / interets[o].nbExercices)
                    });
                }

                function lancerProfil(){
                    trackerAnim.reset();
                    trackerAnim.stop();
                    tl.reverse();
                    TweenLite.to($("#container"), 0, {autoAlpha: 0});
                    TweenLite.to($("#endroit"), 0.5, {autoAlpha: 0});
                    //afficher l'overlay sur l'icône actif
                    if ($("#icon_active")) {
                        $("#icon_active").remove();
                    }
                    $("#icon_user").append("<img id=\"icon_active\" style=\"position: absolute; width: 80px; height: 80px; top: 50%; left: 50%; transform: translate(-50%, -50%)\" src=\"{{ URL::asset('img/icon_active.png') }}\"/>");
                    $("#overlay_temp").css({"z-index": "500000008"});
                    $("#overlay_temp").empty();
                    $("#overlay_temp").load("{{url('/profil')}}", chargerProfil);
                    $("#overlay_temp").css({"background-color":"transparent"});
                    tl_overlay.to($("#overlay_temp"), 0.5, {autoAlpha: 1});
                }

                function chargerProfil(){
                    var x;
                    var y;
                    for (i = 1; i <= interets.length; i++){
                        y = 178 * Math.cos((i - 1) * (2 * Math.PI / interets.length));
                        x = 178 * Math.sin((i - 1) * (2 * Math.PI / interets.length));

                        if ((i - 1) == sdTemp){
                            $("#contenu_ateliers").append("<div class=\"cercleStyle\" id=\"cercleAtelier" + (i - 1) + "\">" + "<svg height=\"20\" width=\"20\"><circle cx=\"10\" cy=\"10\" r=\"2\" stroke=\"none\" stroke-width=\"3\" fill=\"#fa7346\" /></svg>" + "</div>");
                            TweenLite.to($("#cercleAtelier" + (i - 1)), 2, {scale: 3, force3D: false});
                        } else {
                            $("#contenu_ateliers").append("<div class=\"cercleStyle\" id=\"cercleAtelier" + (i - 1) + "\">" + "<svg height=\"20\" width=\"20\"><circle cx=\"10\" cy=\"10\" r=\"2\" stroke=\"none\" stroke-width=\"3\" fill=\"white\" /></svg>" + "</div>");
                        }

                        $("#cercleAtelier" + (i - 1)).css({"transform":"translate(" + (x - 10) + "px, " + (y * ( - 1) - 10) + "px)"});
                    }

                    majCercle(sdTemp);

                    $(".cercleStyle").mouseenter(function(){
                        if (sdTemp != this.id.substr(13)){
                            majCercle(this.id.substr(13));
                            TweenLite.to($("#" + this.id), 0.5, {scale: 3, force3D: false});
                            TweenLite.to($("#" + this.id.substr(0, 13) + sdTemp), 0.5, {scale: 1, force3D: false});
                        }
                    });

                    $(".cercleStyle").mouseleave(function(){
                        if (sdTemp != this.id.substr(13)){
                            majCercle(sdTemp);
                            TweenLite.to($("#" + this.id), 0.5, {scale: 1, force3D: false});
                            TweenLite.to($("#" + this.id.substr(0, 13) + sdTemp), 0.5, {scale: 3, force3D: false});
                        }
                    });
                }

                function toggleFull() {
                    //élément à agrandir
                    var divObj = document.body;
                    if (divObj.requestFullscreen){
                        if (document.fullScreenElement) {
                            document.cancelFullScreen();
                        } else {
                            divObj.requestFullscreen();
                        }
                    } else if (divObj.msRequestFullscreen){
                        if (document.msFullscreenElement) {
                            document.msExitFullscreen();
                        } else {
                            divObj.msRequestFullscreen();
                        }
                    } else if (divObj.mozRequestFullScreen){
                        if (document.mozFullScreenElement) {
                            document.mozCancelFullScreen();
                        } else {
                            divObj.mozRequestFullScreen();
                        }
                    } else if (divObj.webkitRequestFullscreen){
                        if (document.webkitFullscreenElement) {
                            document.webkitCancelFullScreen();
                        } else {
                            divObj.webkitRequestFullscreen();
                        }
                    }
                    e.stopPropagation();
                }

                $("#tutoriel").click(lancerTuto);
                $("#img_tuto").click(lancerTuto);
                $("#icon_location").click(lancerCarte);
                $("#icon_user").click(lancerProfil);
                $("#expand").click(toggleFull);

                function createCircles(){
                    //Remplir le tableau de cercles
                    remplirInterets();
                    //Définir le centre
                    x = $(window).width() / 2;
                    //Créer les cercles
                    for (i = 0; i < interets.length; i++){
                        createOneCircle(i);
                        if (interets[i].abscisse > cxMax){
                            cxMax = interets[i].abscisse;
                        }
                    }
                }

                function init() {
                    canvas = document.getElementById("canvas");
                    ctx = canvas.getContext("2d");
                    TweenLite.to($("#container"), 0, {autoAlpha: 0});
                    if (sdTemp < 0){
                        $("#icon_intro").append("<img id=\"icon_active\" style=\"position: absolute; width: 80px; height: 80px; top: 50%; left: 50%; transform: translate(-50%, -50%)\" src=\"{{ URL::asset('img/icon_active.png') }}\"/>");
                        $("#overlay_temp").load("{{url('/intro')}}");
                    }
                    return setInterval(draw, 30);
                }

                createCircles();
                init();

                $("#overlay_temp").click();

                var dragok = false;

                function myMove(e){
                    if (dragok && compteur == - 2 && $("#overlay_temp").css("opacity") == 0 && $("#overlay_pano").css("pointer-events") == "none"){
                        x = x + (e.pageX - newX);
                        newX = e.pageX;

                        //Bloquer le drag sur les bornes de la timeline
                        if (x > $(window).width() / 2){
                            x = $(window).width() / 2;
                        }
                        if (x < $(window).width() / 2 - (finVideo)){
                            x = $(window).width() / 2 - (finVideo);
                        }

                        for (i = 0; i < interets.length; i++){
                            TweenLite.to($('#sd' + interets[i].point), 0.3, {attr:{cx:x + (interets[i].abscisse)}});
                            if (x >= $(window).width() / 2 - (interets[i].abscisse) - 150 && x <= $(window).width() / 2 - (interets[i].abscisse) + 150){
                                tl2[i].play();
                                chargerLegende(i);
                                trackerAnim.play(2);
                                tl.play();
                            } else {
                                tl2[i].reverse();
                                if (sdTemp == i){
                                    trackerAnim.play( - 4);
                                    tl.reverse();
                                    sdTemp = - 1;
                                }
                            }
                        }
                    }
                }

                function myDown(e){
                    dragok = true;
                    document.onmousemove = myMove;
                    newX = e.pageX;
                }

                function myUp(){
                    dragok = false;
                    document.onmousemove = null;
                }


                document.onmousedown = myDown;
                document.onmouseup = myUp;
                //Page de chargement
                var chargement_anim = [];
                var compteur = - 1;

                function ondeChargement(x){
                    x = compteur + 1;
                    $("#animationChargement").append("<svg style=\"position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);\" height=\"800\" width=\"800\"><circle id=\"animationBord" 
                            + x + "\" cx=\"400\" cy=\"400\" r=\"75\" stroke=\"white\" stroke-width=\"1\" stroke-opacity=\"0.75\" fill=\"none\" /></svg>");
                    chargement_anim[x] = new TimelineMax({onComplete:function(){
                            $("#animationBord" + x).parent().remove();
                        }});
                    chargement_anim[x].to($("#animationBord" + x), 4.5, {autoAlpha: 0, transformOrigin:"50% 50%", ease:Linear.easeNone});
                    chargement_anim[x].to($("#animationBord" + x), 5, {attr:{r:400}, transformOrigin:"50% 50%", ease:Linear.easeNone}, "-=4.5");
                    compteur = x;
                }

                $("#chargement").click(function(){
                    ondeChargement(compteur);
                });

                var pourcentageChargement = 0;

                var loading = setInterval(function(){
                    if (myVideo.duration && 100 * myVideo.buffered.end(0) / myVideo.duration < 100){
                        if (pourcentageChargement != Math.floor((100 * myVideo.buffered.end(0) / myVideo.duration))){
                            $("#pourcentageChargement").empty().append(Math.floor((100 * myVideo.buffered.end(0) / myVideo.duration)) + "%");
                            pourcentageChargement = Math.floor((100 * myVideo.buffered.end(0) / myVideo.duration));
                            ondeChargement(compteur);
                        }
                    }

                    if (Math.floor((100 * myVideo.buffered.end(0) / myVideo.duration)) == 100){
                        $("#pourcentageChargement").empty().append("100%");
                        myVideo.playbackRate = 1;
                        myVideo.pause();
                        myVideo.currentTime = 0;
                        TweenLite.to("#chargement", 1, {autoAlpha: 0, onComplete:function(){
                                compteur = - 2;
                                $("#chargement").remove();
                            }
                        });
                        clearInterval(loading);
                    }
                }, 30);

                setInterval(function () {
                    if (myVideo.duration && dragok && compteur == - 2){
                        if (document.body.msRequestFullscreen){
                            TweenLite.to(myVideo, 0.3, {currentTime:Math.round((myVideo.duration - ($(window).width() / 2 - (finVideo) - x) * myVideo.duration / ( - (finVideo))) * 10) / 10});
                        } else {
                            myVideo.currentTime = Math.round((myVideo.duration - ($(window).width() / 2 - (finVideo) - x) * myVideo.duration / ( - (finVideo))) * 10) / 10;
                        }
                    }
                }, 30);
            });

        </script>
    </body>
</html>
