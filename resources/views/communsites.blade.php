<?php
if ($id != 0) {
    $tpn = App\Models\Tpn::find(App\Models\Atelier_tpn::find($id)->tpn_id);
}
?>
{{ Html::script(asset('js/howler/howler.js')) }}
{{ Html::script(asset('js/TweenMax.min.js')) }}
<div id="zoomOverlay">
    <div id="zoomBloc">
        <div id="zoomHaut">MAX</div>
        <div id="zoomBar">
            <svg id="ligneZoom" width="80" height="1200">
            <path stroke="#ffffff"  stroke-width="2" d="M40 0 L40 562"/>
            <path stroke="#fa7346"  stroke-width="2" d="M40 638 L40 1200"/>
            <circle id="cerclePasFait" cx="40" cy="600" r="38"fill="none" stroke="#ffffff" stroke-width="2" />
            <circle id="cercleFait" cx="40" cy="600" r="38"fill="none" stroke="#fa7346" stroke-width="2" />
            </svg>
            <div id="zoomNbExercices">@if($id !=0)
                <span id="realise">{{Auth::user()->exercices()->whereAtelier_tpn_id($id)->count()}} </span> / {{App\Models\Atelier_tpn::find($id)->exercices()->count()}}
                @endif
                <br/>EXERCICES</div>
        </div>
        <div id="zoomBas">MIN</div>
    </div>
    <div id="zoomEndroit">
        <div id="zoomEndroitBloc">
            <div id="zoomNomAtelier">@if($id !=0)
                {{App\Models\Atelier_tpn::find($id)->titre_atelier}}
                @endif
            </div>
            <div id="zoomSite">Site <span id="zoomNomSite">{{$atelier->site->titre}}</span></div>
        </div>
    </div>
</div>

<script>
    var niveauZoom = 18;
    var tailleZoom = 560;
    var cranZoom = ( - tailleZoom) / ( - niveauZoom);
    var krpano;
    var fov;
    var delta;
    var rayonCercle = 2 * Math.PI * 38;
    setInterval(function(){
    if (document.getElementById("krpanoSWFObject")){
    fov = document.getElementById("krpanoSWFObject").get("view.fov");
    fovmin = document.getElementById("krpanoSWFObject").get("view.fovmin");
    fovmax = document.getElementById("krpanoSWFObject").get("view.fovmax");
    ecartfov = fovmax - fovmin;
    $("#ligneZoom").css({"top":( - 520 * (fovmin - fov) - ecartfov * 560) / ecartfov + "px"});
    $("#zoomNbExercices").css({"top":( - 520 * (fovmin - fov) - ecartfov * 560) / ecartfov + "px"});
//    console.log(fov, fovmin, ecartfov);
    }
    }, 30);
    var exos = [];
    function paramExos(id, x, y, type, contenu, fait){
//Créer un objet
    var o = new Object();
    o.id = id; //id en base
    o.x = x; //abscisse de l'exercice
    o.y = y; //ordonnée de l'exercice
    o.type = type; //type de l'exercice
    o.contenu = contenu; //contenu
    o.fait = fait;
    return o;
    }
<?php
if ($id != 0) {
    if (App\Models\Atelier_tpn::find($id)->exercices()->count() > 0) {
        $exercices = [];

        $exercices = App\Models\Atelier_tpn::find($id)->exercices;

        $j = 0;
        foreach ($exercices as $exercice) {
            if (App\Models\Exercice_user::whereExercice_id($exercice->id)->whereUser_id(Auth::user()->userable_id)->count() > 0) {
                ?>
                    exos[{{$j}}] = paramExos("{{$exercice->id}}", "{{$exercice->x}}", "{{$exercice->y}}", "{{$exercice->type}}", "<?php echo addslashes(str_replace(['\n', '\r', CHR(10), CHR(13), PHP_EOL], "", (string) $exercice->contenu)) ?>", true); <?php
            } else {
                ?>

                    exos[{{$j}}] = paramExos("{{$exercice->id}}", "{{$exercice->x}}", "{{$exercice->y}}", "{{$exercice->type}}", "<?php echo addslashes(str_replace(['\n', '\r', CHR(10), CHR(13), PHP_EOL], "", (string) $exercice->contenu)) ?>", false);
            <?php
            } $j++;
        }
        ?>
            //}
            function creerExos(){
            var nbexos = exos.length;
            var nbexosfait = 0;
            for (i = 0; i < exos.length; i++){
            var imgExo = "";
            if (exos[i].type == "video") {
            imgExo = "iconeVideo";
            }
            else if (exos[i].type == "texte") {
            imgExo = "iconeArticle";
            }
            else if (exos[i].type == "photo") {
            imgExo = "iconePhoto";
            }
            if (exos[i].fait == true)
                    nbexosfait++;
            else
                    imgExo = imgExo + "_none";
            imgExo = imgExo + ".png";
            imgExo = "{{URL::asset('img')}}/" + imgExo;
            //Ajouter un point sur le 360	
            document.getElementById("krpanoSWFObject").call("addhotspot(spotpoint" + exos[i].id + ")");
            //Définir l’image du point
            document.getElementById("krpanoSWFObject").set("hotspot[spotpoint" + exos[i].id + "].url", imgExo);
            //Définir l’abscisse du point				
            document.getElementById("krpanoSWFObject").set("hotspot[spotpoint" + exos[i].id + "].ath", exos[i].x);
            //Définir l’ordonnée du point				
            document.getElementById("krpanoSWFObject").set("hotspot[spotpoint" + exos[i].id + "].atv", exos[i].y);
            //Rendre le point visible (caché à la création)						
            document.getElementById("krpanoSWFObject").set("hotspot[spotpoint" + exos[i].id + "].visible", true);
            document.getElementById("krpanoSWFObject").set("hotspot[spotpoint" + exos[i].id + "].onclick", "looktohotspot(); js(chargerExo(" + i + ")));");
            }

            $("#cercleFait").attr({"stroke-dasharray": (rayonCercle * nbexosfait / nbexos) + " " + (rayonCercle * (nbexos - nbexosfait) / nbexos)});
            $("#cerclePasFait").attr({"stroke-dasharray": 0 + " " + (rayonCercle * nbexosfait / nbexos) + " " + (rayonCercle * (nbexos - nbexosfait) / nbexos)});
            }


            setTimeout(creerExos, 3000);
            function chargerExo(k){
            /*trackerAnim.reset();
             trackerAnim.stop();
             tl.reverse();*/
            if ($("#overlay_temp").length == 0) {

            $('body').append('<div id="overlay_temp" class="overlay"></div>');
            $("#overlay_temp").click(function(e){$("#overlay_temp").remove();
            TweenLite.to($("#container"), 1, {autoAlpha: 1});
            TweenLite.to($("#endroit"), 0, {autoAlpha: 0.5}); });
            //	console.log($("#overlay_temp").length);
            //code
            }
            $("#overlay_temp").css({"z-index": "500000008"});
            $("#overlay_temp").empty();
            $("#overlay_temp").load("{{url('/exercice')}}", function(){
            //console.log(exos[k].contenu);
            $("#oc_texte").append(exos[k].contenu); //intro du tpn
            if ($("#overlay_click").height() > $("#overlay_contenu").height()){
            $("#scrollbarrette").css({"opacity":"0"});
            }
            $("#nom_site").append("{!!$atelier->site->titre!!}".toUpperCase()); //site du TPN
            $("#nom_responsable_site").append("{!!$tpn->professeur->user->prenom!!} {!!$tpn->professeur->user->nom!!}"); //nom enseignant
            $("#overlay_temp").css("opacity", 0.85);
            TweenLite.to($("#overlay_temp"), 0.5, {autoAlpha: 0.85});
            });
            //code
            TweenLite.to($("#container"), 0, {autoAlpha: 0});
            TweenLite.to($("#endroit"), 0.5, {autoAlpha: 0});
            //code



            //afficher l'overlay sur l'icône actif
            if ($("#icon_active")) $("#icon_active").remove();
            //	console.log('ok');





            $.ajax({
            url: "{{url('/exercice_user')}}",
                    type: 'POST',
                    data: {'_token':'{{csrf_token()}}', 'exercice':exos[k].id},
                    error: function (error) {
                    console.log(error);
                    },
                    success: function(result) {
                    var nb = $("#realise").html();
                    nb++;
                    $("#realise").empty();
                    $("#realise").html(nb);
                    exos[k].fait = true;
                    if (exos[k].type == "video") {
                    imgExo = "../img/iconeVideo.png";
                    }
                    else if (exos[k].type == "texte") {
                    imgExo = "../img/iconeArticle.png";
                    }
                    else if (exos[k].type == "photo") {
                    imgExo = "../img/iconePhoto.png";
                    }
                    document.getElementById("krpanoSWFObject").set("hotspot[spotpoint" + exos[k].id + "].url", imgExo);
                    $("#overlay_realise").empty();
                    $("#overlay_realise").html(nb);
                    for (var i = 0; i < interets.length; i++) {
                    if (interets[i].id === {{App\Models\Atelier_tpn::find($id)->atelier_id}}) {
                    interets[i].nbExercicesFaits = nb;
                    return nb;
                    }
                    }
                    $("#cercleFait").attr({"stroke-dasharray": (rayonCercle * nb / exos.length) + " " + (rayonCercle * (exos.length - nb) / exos.length)});
                    $("#cerclePasFait").attr({"stroke-dasharray": 0 + " " + (rayonCercle * nb / exos.length) + " " + (rayonCercle * (exos.length - nb) / exos.length)});
                    //interets[$("#id_atelier").val()].nbExercicesFaits = nb;
                    }
            });
            }
    <?php }
} ?>
    // Inside 360			
    snd_360 = new Howl({urls:['{{$url}}/snd.mp3'], loop:true, volume:0.3})
            snd_360.play();
    snd_soundscape.fadeOut(0.0, snd_fadeLength);
    snd_wind.fadeOut(0.0, snd_fadeLength);
    snd_kalimba.fadeOut(0.0, snd_fadeLength);
    snd_insitu = true;
</script>
<style>
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #000;
        filter:alpha(opacity=50);
        -moz-opacity:0.5;
        -khtml-opacity: 0.5;
        opacity: 0.85;
        z-index: 10000;
    }
</style>