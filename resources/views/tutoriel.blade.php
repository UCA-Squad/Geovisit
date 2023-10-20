	<div id="overlay_click">
		<div id="overlay_contenu">
			 <div id="oc_titre">NAVIGUER</div>
			 <div id="container_mouse">
				<div id="bloc_mouse">
					<img id="tuto_flecheg" src="../img/tuto_flecheg.png" />
					<img id="tuto_mouse" src="../img/tuto_mouse.png" />
					<img id="tuto_fleched" src="../img/tuto_fleched.png" />
				</div>
			</div>
			 <div id="oc_texte">Glisser latéralement pour commencer l’expédition</div>
			 <div id="oc_bouton"><br/>
				<svg id="oc_boutonsvg" width="400" height="120">
					<rect id="oc_boutonforme" x="25%" y="25%" rx="30" ry="30" width="200" height="60" style="fill:none;stroke:white;stroke-width:1;fill-opacity:0.3;stroke-opacity:1"/>
				</svg>		
				<div id="oc_boutonlabel">CONTINUER</div>
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
	var singleton = true;
	$("#oc_boutonforme").mouseover(function() {
		$("#oc_boutonforme").css({fill: "grey"});
	});
	$("#oc_boutonforme").mouseleave(function() {
		$("#oc_boutonforme").css({fill: "none"});
	});
	
	$("#oc_boutonforme").click(function(){
		if(singleton){
			tl_tuto1.stop();
			$("#oc_titre").empty().append("ATELIER");
			$("#bloc_mouse").empty().append("<img id=\"tuto_circle\" src=\"../img/tuto_circle.png\" /><img id=\"tuto_souris\" src=\"../img/tuto_souris.png\" />");
			$("#oc_texte").empty().append("Cliquer sur un point d’intérêt pour rentrer dans un atelier")
			$("#oc_boutonlabel").empty().append("FERMER");
			tl_tuto2.to($("#tuto_souris"), 0.75,  {y: "-50px", ease:Linear.easeNone})
					.to($("#tuto_circle"), 0.75, {scale: 1.3, ease:Linear.easeNone}, "-=0.75")
					.to($("#tuto_circle"), 0.75, {scale: 1, ease:Linear.easeNone}, "+=0.5")
					.to($("#tuto_souris"), 0.75,  {y: "0px", ease:Linear.easeNone}, "-=0.75");
			tl_tuto2.play();
			singleton = false;
		} else {
			$("#oc_boutonforme").attr("id","prout");
		}
	});
	
	var tl_tuto1 = new TimelineMax({repeat:-1, repeatDelay:1});
	tl_tuto1.to($("#tuto_mouse"), 0.75,  {x: "50px", ease:Linear.easeNone})
			.to($("#tuto_mouse"), 1.5,  {x: "-50px", ease:Linear.easeNone})
			.to($("#tuto_mouse"), 0.85,  {x: "10px", ease:Linear.easeNone})
			.to($("#tuto_mouse"), 0.35,  {x: "0px", ease:Linear.easeNone});
	  
	var tl_tuto2 = new TimelineMax({repeat:-1, repeatDelay:1});
	tl_tuto2.stop();
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
		background-color: black;
	}
	#overlay_click{
		position: absolute;
		top: 50%;
		left: 50%;
		width: 1000px;
		pointer-events: none;
		
		transform: translate(-50%, -50%);
	}
	#overlay_contenu{
		font-family: 'Lato', sans-serif;
		pointer-events: all;
	}
	#oc_titre{
		font-size: 40px;
		font-weight: 700;
		color: #ffffff;
		text-align: center;
		pointer-events: none;
	}
	#container_mouse{
		position: relative;
		height: 400px;
	}
	#bloc_mouse{
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
	}
	#tuto_flecheg{
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-224px, -50%);
	}
	#tuto_fleched{
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(147px, -50%);
	}
	#tuto_souris{
		position: absolute;
		top: 50%;
		left: 50%;
		transform: translate(-50%, 0%);
	}
	#oc_texte{
		font-size: 21px;
		font-weight: 300;
		color: #ffffff;
		text-align: center;
		pointer-events: none;
	}
	#oc_bouton{
		position: relative;
		text-align: center;
		pointer-events: none;
	}
	#oc_boutonlabel{
		position: absolute;
		top: 50%;
		left: 50%;
		font-size: 15px;
		font-weight: bold;
		color: #ffffff;
		pointer-events: none;
		
		transform: translate(-50%, -0%);
	}
	#oc_boutonforme{
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
	}
	#croix{
		position: relative;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
	}
</style>
