@if ($site->sig_map === 0)
<div id="overlay_carte">
    <div id="contenu_carte">
        <img id="carte" />
        <img id="sentier" />
    </div>
    <img id="grille" src="{{ URL::asset('img/grille.png') }}" />

    <img id="boussole" src="{{ URL::asset('img/boussole.png') }}" />
    <div id="afficher">
        <div id="afficher_titre">AFFICHER / CACHER</div>
        <div id="afficher_grille">
            <div class="afficher_legende">Grille</div>
            <div class="glissiere">
                <svg class="glissiere_svg" width="50" height="30">
                <rect class="glissiere_forme" x="5" y="25%" rx="8" ry="8" width="40" height="15" style="fill:#1d1d1d;stroke:none;stroke-width:1;fill-opacity:0.5;stroke-opacity:1"/>
                </svg>	
                <svg class="bouton_svg" id="bouton_svg_grille" height="30" width="50">
                <circle class="bouton_forme" cx="36" cy="15" r="9" fill="white" fill-opacity="1" />
                </svg>
            </div>
        </div>
        <div id="afficher_boussole">
            <div class="afficher_legende">Boussole</div>
            <div class="glissiere">
                <svg class="glissiere_svg" width="50" height="30">
                <rect class="glissiere_forme" x="5" y="25%" rx="8" ry="8" width="40" height="15" style="fill:#1d1d1d;stroke:none;stroke-width:1;fill-opacity:0.5;stroke-opacity:1"/>
                </svg>	
                <svg class="bouton_svg" id="bouton_svg_boussole" height="30" width="50">
                <circle class="bouton_forme" cx="36" cy="15" r="9" fill="white" fill-opacity="1" />
                </svg>
            </div>
        </div>
        <div id="afficher_sentier">
            <div class="afficher_legende">Sentier</div>
            <div class="glissiere">
                <svg class="glissiere_svg" width="50" height="30">
                <rect class="glissiere_forme" x="5" y="25%" rx="8" ry="8" width="40" height="15" style="fill:#1d1d1d;stroke:none;stroke-width:1;fill-opacity:0.5;stroke-opacity:1"/>
                </svg>	
                <svg class="bouton_svg" id="bouton_svg_sentier" height="30" width="50">
                <circle class="bouton_forme" cx="36" cy="15" r="9" fill="white" fill-opacity="1" />
                </svg>
            </div>
        </div>
    </div>
</div>
<div id="overlay_croix">
    <div id="croix">
        <span id="croix_label">FERMER</span>
        <svg id="croix_forme" width="20" height="20">
        <path stroke="#ffffff"  d="M10 10 L20 20"/>
        <path stroke="#ffffff"  d="M10 20 L20 10"/>
        </svg>
    </div>
</div>
<script>
    var grille = true;
    var boussole = true;
    var sentier = true;
    $("#afficher_grille").click(function () {
        if (grille) {
            TweenLite.to($("#bouton_svg_grille"), 0.3, {x: "-100%", autoAlpha: 0.5});
            grille = false;
            TweenLite.to($("#grille"), 0.3, {autoAlpha: 0});
        } else {
            TweenLite.to($("#bouton_svg_grille"), 0.3, {x: "-50%", autoAlpha: 1});
            grille = true;
            TweenLite.to($("#grille"), 0.3, {autoAlpha: 1});
        }
    });
    $("#afficher_boussole").click(function () {
        if (boussole) {
            TweenLite.to($("#bouton_svg_boussole"), 0.3, {x: "-100%", autoAlpha: 0.5});
            boussole = false;
            TweenLite.to($("#boussole"), 0.3, {autoAlpha: 0});
        } else {
            TweenLite.to($("#bouton_svg_boussole"), 0.3, {x: "-50%", autoAlpha: 1});
            boussole = true;
            TweenLite.to($("#boussole"), 0.3, {autoAlpha: 1});
        }
    });
    $("#afficher_sentier").click(function () {
        if (sentier) {
            TweenLite.to($("#bouton_svg_sentier"), 0.3, {x: "-100%", autoAlpha: 0.5});
            sentier = false;
            TweenLite.to($("#sentier"), 0.3, {autoAlpha: 0});
        } else {
            TweenLite.to($("#bouton_svg_sentier"), 0.3, {x: "-50%", autoAlpha: 1});
            sentier = true;
            TweenLite.to($("#sentier"), 0.3, {autoAlpha: 1});
        }
    });
</script>
<style>
    body, html{
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;    
        overflow: hidden;
        font-family: 'Lato', sans-serif;
        color: white;
        cursor: default;
    }
    #overlay_carte{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: all;
    }
    #overlay_croix{
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 50px;
        color: white;
        font-family: 'Lato', sans-serif; 
        font-weight: 400;
        font-size: 15px;
        text-align: center;
        pointer-events: none;
        cursor: pointer;
    }
    #croix{
        position: relative;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    #grille{
        position: absolute;
        top: 50%;
        left: 50%;
        width: 100%;
        height: 100%;
        transform: translate(-50%, -50%);
        pointer-events: none;
    }
    #boussole{
        position: absolute;
        bottom: 0%;
        right: 0%;
        width: 100%;
        height: 100%;
        pointer-events: none;
    }
    #carte{
        /*position: absolute;
        top: 50%;
        left: 50%;*/
        max-width: 100%;
        max-height: 100%;
        /*	transform: translate(-50%, -50%);*/
        pointer-events: none;
    }
    #sentier{
        position: absolute;
        top: 50%;
        left: 50%;
        max-width: 100%;
        max-height: 100%;
        transform: translate(-50%, -50%);
        pointer-events: none;
    }
    #afficher{
        position: absolute;
        left: 0;
        bottom: 0;
        width: 300px;
        height: 200px;
        margin-left: 75px;
        margin-bottom: 40px;
        pointer-events: none;
    }
    #afficher_titre{
        font-weight: 700;
        font-size: 19px;
        margin-bottom: 30px;
        pointer-events: none;
    }
    #afficher_grille{
        font-weight: 700;
        font-size: 13px;
        margin-bottom: 20px;
        height: 30px;
        pointer-events: all;
    }
    #afficher_boussole{
        font-weight: 700;
        font-size: 13px;
        margin-bottom: 20px;
        height: 30px;
        pointer-events: all;
    }
    #afficher_sentier{
        font-weight: 700;
        font-size: 13px;
        height: 30px;
        pointer-events: all;
    }
    .glissiere{
        position: relative;
        float: right;
        width: 50px;
        height: 30px;
        pointer-events: none;
    }
    .bouton_svg{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        pointer-events: none;
    }
    .glissiere_svg{
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        pointer-events: none;
    }
    .afficher_legende{
        position: absolute;
        transform: translate(0%, 50%);
        pointer-events: none;
    }
    #contenu_carte{
        position: relative;
        max-width: 60%;
        z-index: 50;
        margin: 5% auto;
    }
</style>
@else
{{ Form::hidden('map-latmin', $site->latmin, ['id' => 'map-latmin']) }}
{{ Form::hidden('map-latmax', $site->latmax, ['id' => 'map-latmax']) }}
{{ Form::hidden('map-lonmin', $site->lonmin, ['id' => 'map-lonmin']) }}
{{ Form::hidden('map-lonmax', $site->lonmax, ['id' => 'map-lonmax']) }}
<div id="map-tp" style="width: 70%; height: 80%;position: relative; top: 5%; left: 15%;"></div>
<div id="overlay_croix">
    <div id="croix">
        <span id="croix_label">FERMER</span>
        <svg id="croix_forme" width="20" height="20">
        <path stroke="#ffffff"  d="M10 10 L20 20"/>
        <path stroke="#ffffff"  d="M10 20 L20 10"/>
        </svg>
    </div>
</div>
<style>
    #overlay_croix{
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 50px;
        color: white;
        font-family: 'Lato', sans-serif; 
        font-weight: 400;
        font-size: 15px;
        text-align: center;
        pointer-events: none;
        cursor: pointer;
    }
</style>
@endif