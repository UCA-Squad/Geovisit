@extends('layouts.intro')

@section('content')
<img id="splash_choix" src="{{ URL::asset('img/splash.png') }}">
<div class="administration" align="center">
    @if($permission)
        <a href="{{ url('/admin') }}" style="margin: auto"><div id="icon_admin"></div><div class="libelle">Administration</div></a>
    @endif
</div>   
<div class="deconnexion">
    <a href="{{ url('/logout') }}"><div id="icon_logout"></div><div class="libelle">Deconnexion</div></a>
</div>
<div id="overlay_click">
    <div id="bloc_nom">
        <div id="bonjour">Bonjour {{ Auth::user()->prenom }} </div>
        <div id="barre">
            <svg width="700" height="10">
                <path stroke="white" stroke-opacity="1" stroke-width="1px" d="M30 5 L670 5"/>
            </svg>
        </div>
        <div id="tpn">Mes Travaux Pratiques Numériques</div>
    </div>
    <div id="bloc_contenu">
        <div id="img_txt">
            <div class="fleches">
                <svg id="fleche_gauche" ondragstart="return false;" ondrop="return false;" width="100" height="200">
                    <path stroke="#ffffff"  d="M90 10 L10 100"/>
                    <path stroke="#ffffff"  d="M10 100 L90 190"/>
                </svg>
            </div>
            <div id="bloc_img">
                <img id="img_site" src="" />
            </div>
            <div id="bloc_texte">
                <div id="description">						
                    <div id="numero_tpn"></div>
                    <div id="nom_tpn"></div>
                    <div id="prof">Enseignant <span id="nom_prof"></span></div>
                    <div id="texte"></div>
                    <div id="ateliers"></div>
                </div>
            </div>
            <div class="fleches">
                <svg id="fleche_droite" ondragstart="return false;" ondrop="return false;" width="100" height="200">						
                    <path stroke="#ffffff"  d="M10 10 L90 100"/> 
                    <path stroke="#ffffff"  d="M90 100 L10 190"/>
                </svg>
            </div>
        </div>
    </div>
    <div id="bloc_progress">
    </div>
    <input type="hidden" name="idtpn" value="" id="idtpn"/>
    <div id="bloc_bouton">
        <svg id="bouton_svg_choix" width="450" height="120">
            <rect id="bouton_forme_choix" x="25" y="25%" rx="30" ry="30" width="400" height="60" style="fill:#f96331;stroke:none;stroke-width:1;fill-opacity:1;stroke-opacity:1"/>
        </svg>		
        <div id="bouton_label_choix">CONTINUER</div>
    </div>
</div>
@endsection

@section('scripts')
	<script>
		var content = [];
		var contentID = 0;
                
			function paramContent(id, numTpn, nomSite, nomProf, texteDesc, nbAteliers, nbAteliersVisites, img,titreTpn){
		//Créer un objet
		var o = new Object();
		o.id = id;
		o.numTpn = numTpn;
		o.nomSite = nomSite.toUpperCase();
		o.nomProf = nomProf;
		o.texteDesc = texteDesc;
		o.nbAteliers = nbAteliers;
		o.nbAteliersVisites = nbAteliersVisites;
		o.img = img;
		o.titreTpn = titreTpn;
		return o;
	}
	var i = 0;
	
	var atelierrealise = 0;
	</script>
	@if($nbtpns > 0)
		@foreach($tpns as $tpn)
			@foreach($tpn->ateliers as $atelier)
			@if(App\Models\Exercice::where('atelier_tpn_id', $atelier->pivot->id)->count() == Auth::user()->exercices()->where('atelier_tpn_id', $atelier->pivot->id)->count())
				<script>
					atelierrealise++;
				</script>
			@endif
			@endforeach
<script>
				//Substituant BDD - pt.2 (lien entre la base et le script)
				stat = {{ App\Models\Exercice::where('atelier_tpn_id', $tpn->id)->count() }};
						content[i] = paramContent("{{$tpn->id}}", i + 1, "{!!$tpn->site->titre!!}", "{!!$tpn->professeur->user->prenom!!} {!!$tpn->professeur->user->nom!!}", "{!!$tpn->description_tpn!!}", "{{$tpn->ateliers()->count()}}", atelierrealise, "{{URL::asset($tpn->site->photo)}}", "{!!$tpn->titre_tpns!!}");


		i++;
		//Tri nécessaire pour dessiner la courbe


	atelierrealise = 0;

			</script>
		@endforeach

		<script>
	content.sort(function(a, b) {
			return a.numTpn - b.numTpn;
		});
		</script>

	@endif
<script>	
	$("#bouton_forme_choix").mouseover(function() {
		$("#bouton_forme_choix").css({fill: "#fa6b3b"});
	});
	$("#bouton_forme_choix").mouseleave(function() {
		$("#bouton_forme_choix").css({fill: "#f96331"});
	});
	$("#bouton_forme_choix").mousedown(function() {
		$("#bouton_forme_choix").css({fill: "#f96331"});
	});
	$("#bouton_forme_choix").click(function() {
	var idtp = $("#idtpn").val();
		window.location = '{{url('/final')}}/'+idtp;
	});
	

	
	function compareNombres(a, b) {
		return a - b;
	}


	
	
	$("#fleche_gauche").click(function(){
		$("#cercle"+contentID).css({"fill-opacity": "0"});
		
		contentID = contentID-1;
		
		if(contentID<0){
			contentID = content.length-1;
		}
		
		$("#cercle"+contentID).css({"fill-opacity": "1"});
		
		$("#numero_tpn").empty().append( content[contentID].titreTpn);
		$("#nom_tpn").empty().append("<br/>" + content[contentID].nomSite);
		$("#nom_prof").empty().append(content[contentID].nomProf);
		$("#texte").empty().append("<br/>" + content[contentID].texteDesc);
		$("#ateliers").empty().append("<br/>" + "ATELIERS RÉALISÉS " + content[contentID].nbAteliersVisites + "/" + content[contentID].nbAteliers);
		$("#img_site").attr("src", content[contentID].img);
		$("#idtpn").val(content[contentID].id);
	});
	
	$("#fleche_droite").click(function(){
		$("#cercle"+contentID).css({"fill-opacity": "0"});
		
		contentID = contentID+1;
		
		if(contentID>content.length-1){
			contentID = 0;
		}
		
		$("#cercle"+contentID).css({"fill-opacity": "1"});
		
		$("#numero_tpn").empty().append( content[contentID].titreTpn);
		$("#nom_tpn").empty().append("<br/>" + content[contentID].nomSite);
		$("#nom_prof").empty().append(content[contentID].nomProf);
		$("#texte").empty().append("<br/>" + content[contentID].texteDesc);
		$("#ateliers").empty().append("<br/>" + "ATELIERS RÉALISÉS " + content[contentID].nbAteliersVisites + "/" + content[contentID].nbAteliers);
		$("#img_site").attr("src", content[contentID].img);
		$("#idtpn").val(content[contentID].id);

	});
	
	if(content.length > 0){
		$("#numero_tpn").append( content[0].titreTpn);
		$("#nom_tpn").append("<br/>" + content[0].nomSite);
		$("#nom_prof").append(content[0].nomProf);
		$("#texte").append("<br/>" + content[0].texteDesc);
		$("#ateliers").append("<br/>" + "ATELIERS RÉALISÉS " + content[0].nbAteliersVisites + "/" + content[0].nbAteliers);
		$("#img_site").attr("src", content[0].img);
		$("#idtpn").val(content[0].id);
		for(i = 0; i < content.length; i++){
			if(i==0){
				$("#bloc_progress").append("<svg height=\"50\" width=\"50\"><circle cx=\"25\" cy=\"25\" r=\"8\" stroke=\"white\" stroke-width=\"1\" fill=\"none\" /><circle id=\"cercle" + i + "\" cx=\"25\" cy=\"25\" r=\"6\" stroke=\"none\" fill=\"white\" fill-opacity=\"1\" /></svg>");
			}
			else{
				$("#bloc_progress").append("<svg height=\"50\" width=\"50\"><circle cx=\"25\" cy=\"25\" r=\"8\" stroke=\"white\" stroke-width=\"1\" fill=\"none\" /><circle id=\"cercle" + i + "\" cx=\"25\" cy=\"25\" r=\"6\" stroke=\"none\" fill=\"white\" fill-opacity=\"0\" /></svg>");
			}
		}
	} else {
			$("#idtpn").val(0);

		$("#prof").hide();
		$(".fleches").hide();
		$("#img_site").hide();
		$("#bouton_label_choix").empty().append("RETOUR");
		$(document.body).append("<div id=\"temp\">Aucun TPN disponible</div>");
		$("#temp").css({"position": "absolute", "top": "50%", "left": "50%", "text-align": "center", "font-family": "'Lato', sans-serif", "color": "white", "font-size": "20px", "font-weight": "300", "pointer-events": "none", "transform": "translate(-50%, -50%)"});
	}
</script>
@endsection
<style>
body, html{
	-webkit-touch-callout: none;
	-webkit-user-select: none;
	-khtml-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
	background-color: transparent;
	background-image: url("img/flou.jpg");
	overflow: hidden;
}
#splash_choix{
	position: absolute;
	width: 100px;
	top: 0;
	left: 0;
	pointer-events: none;
}
#overlay_click{
	position: fixed;
	top: 50%;
	left: 50%;
	width: 1200px;
	font-family: 'Lato', sans-serif;
	pointer-events: none;

	transform: translate(-50%, -50%);
}

@media (max-height: 800px) {
	#overlay_click{
		top: 56%;
	}
	#numero_tpn {
		font-size:12px!important;
	}
	#nom_tpn {
		font-size:30px!important;
	}
	#prof {
		font-size:14px!important;
	}
	#texte {
		font-size:14px!important;
	}
	#ateliers {
		font-size:19px!important;
	}
}

@media (max-width: 900px) {
	#img_site {
		width: 80px!important;
		height: 80px!important;
	}

	#bloc_img {
		width: 0!important;
		margin-right: 0!important;
	}

	#img_txt {
		left: 63%!important;
		width: 750px!important;
	}

	#bloc_texte {
		width: 300px!important;
	}

	.fleches {
		width: 50px!important;
	}

	#numero_tpn {
		font-size:10px!important;
	}
	#nom_tpn {
		font-size:20px!important;
	}
	#prof {
		font-size:12px!important;
	}
	#texte {
		font-size:12px!important;
	}
	#ateliers {
		font-size:14px!important;
	}
}
#bloc_nom{
	width: 100%;
	text-align: center;
	font-family: 'Lato', sans-serif;
	color: white;
}
#bonjour{
	font-size: 22.47pt;
	font-weight: 400;
	color: white;
}
#barre{
	text-align: center;
}
#tpn{
	font-size: 10pt;
	font-weight: 300;
}
#bloc_contenu{
	position: relative;
	width: 100%;
	height: 360px;
}
#img_txt{
	position: relative;
	left: 50%;
	width: 1100px;
	height: 100%;
		
	transform: translate(-50%, 0%);
}
.fleches{
	float: left;
	width: 250px;
	height: 100%;
	text-align: center;
	pointer-events: none;
        cursor: pointer;
}
#fleche_gauche, #fleche_droite{
	position: relative;
	top: 50%;
	pointer-events: all;
	disabled: true;
	
	transform: translate(0%, -50%);
}
#bloc_img{
	float: left;
	width: 180px;
	height: 100%;
	margin-right: 40px;
}
#img_site{
	position: relative;
	width: 180px;
	height: 180px;
	border-radius: 90px;
	-webkit-border-radius: 90px;
	-moz-border-radius: 90px;
	top: 50%;
		
	transform: translate(0%, -50%);
}
#bloc_texte{
	float: left;
	width: 380px;
	height: 100%;
}
#description{
	position: relative;
	top: 50%;
	
	transform: translate(0%, -50%);
}
#numero_tpn{
	font-size: 15px;
	font-weight: 700;
	color: #fa7346;
	text-align: right;
}
#nom_tpn{
	font-size: 40px;
	font-weight: 700;
	color: white;
	text-align: right;
}
#prof{
	font-size:15px;
	font-weight: 300;
	color: #ffffff;
	text-align: right;
}
#nom_prof{
	 font-weight: 700;
}
#texte{
	font-size: 20px;
	font-weight: 300;
	font-style: italic;
	color: #ffffff;
	text-align: right;
}
#ateliers{
	font-size: 30px;
	font-weight: 300;
	color: #ffffff;
	text-align: right;
}
#bloc_progress{
	position: relative;
	text-align: center;
}
#bloc_bouton{
	position: relative;
	text-align: center;
}
#bouton_label_choix{
	position: absolute;
	top: 50%;
	left: 50%;
	font-size: 15px;
	font-weight: 700;
	color: #ffffff;
	
	transform: translate(-50%, -50%);
}
#bouton_forme_choix{
	pointer-events: all;
}
.deconnexion{float: right; list-style: none; margin-right:10px; }
.deconnexion li {display : inline;}
.deconnexion a{color:white;text-decoration: none ;font-size: 15px;}
</style>
