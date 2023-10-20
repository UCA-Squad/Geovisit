<div id="overlay_click">
	<div id="scrollbarrette">
		<div id="scrollbarrinette"></div>
	</div>
	<div id="overlay_contenu">
		 <div id="oc_titre"></div>
		 <div id="oc_soustitre"></div>
		 <div id="oc_texte"></div>
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
<div id="overlay_site">
	<div id="site">
		<div id="nom_site"></div>
		<div id="responsable_site">Enseignant <span id="nom_responsable_site"></span></div>
	</div>
</div>
<script>
	var scroll_value = 0;
	var start_scroll_click = 0;
	var start_scroll_content = 0;
	
	TweenLite.to($("#overlay_site"), 0.5, {autoAlpha: 1, delay: 0.5});
	
	$("#overlay_click").on('wheel', function(e) {

		var delta = e.originalEvent.deltaY;
		
		if(delta > 0 && scroll_value < ($("#overlay_contenu").height()-$("#overlay_click").height())){
			scroll_value = scroll_value + delta;
			if(scroll_value > ($("#overlay_contenu").height()-$("#overlay_click").height())) scroll_value = ($("#overlay_contenu").height()-$("#overlay_click").height());
		}
		if(delta < 0 && scroll_value > 0){
			scroll_value = scroll_value + delta;
			if(scroll_value < 0) scroll_value = 0;
		}
		TweenLite.to($("#overlay_contenu"), 0.3, {top: -scroll_value + "px"});		
		TweenLite.to($("#scrollbarrinette"), 0.3, {top: ((($("#scrollbarrette").height() - $("#scrollbarrinette").height())*scroll_value)/($("#overlay_contenu").height()-$("#overlay_click").height())) + "px"});	
	});
	
	function introMouseDown(e){
		allowdrag = true;
		document.getElementById("overlay_click").onmousemove = introMove; 
		start_scroll_click = e.pageY;
		start_scroll_content = -parseFloat($("#overlay_contenu").css("top").substr(0, $("#overlay_contenu").css("top").length-2));
	}

	function introMouseUp(){
		allowdrag = false;
		document.getElementById("overlay_click").onmousemove = null;
	}
	
	var allowdrag = false;
	document.getElementById("overlay_click").onmousedown = introMouseDown;
	document.getElementById("overlay_click").onmouseup = introMouseUp;	
			
	function introMove(e){
		if(allowdrag && $("#scrollbarrette").css("opacity") > 0){
			var delta = e.pageY;
			var top_contenu = $("#overlay_contenu").css("top").substr(0, $("#overlay_contenu").css("top").length-2);
			var contentSlide = top_contenu -(delta - start_scroll_click);
			
			if(-contentSlide > 0 && -contentSlide < ($("#overlay_contenu").height()-$("#overlay_click").height())){
				TweenLite.to($("#overlay_contenu"), 0.3, {top: contentSlide + "px"});	
				TweenLite.to($("#scrollbarrinette"), 0.3, {top: (($("#scrollbarrette").height()-$("#scrollbarrinette").height())*-contentSlide)/($("#overlay_contenu").height()-$("#overlay_click").height()) + "px"});
			}
			
			if(-contentSlide <= 0){
				TweenLite.to($("#overlay_contenu"), 0.3, {top: "0px"});
				TweenLite.to($("#scrollbarrinette"), 0.3, {top: "0px"});
			}
			
			if(-contentSlide >= ($("#overlay_contenu").height()-$("#overlay_click").height())){
				TweenLite.to($("#overlay_contenu"), 0.3, {top: -($("#overlay_contenu").height()-$("#overlay_click").height()) + "px"});
				TweenLite.to($("#scrollbarrinette"), 0.3, {top: ($("#scrollbarrette").height()-$("#scrollbarrinette").height()) + "px"});
			}
				
		}
	}
</script>
<style>
	body, html{
		-webkit-touch-callout: none;
		-webkit-user-select: none;
		-khtml-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;    
		background-color: transparent;
	}
	#overlay_click{
		position: absolute;
		top: 200px;
		bottom: 100px;
		left: 50%;
		width: 800px;		
		overflow-Y: hidden;
		pointer-events: all;
		
		transform: translate(-50%, 0%);
	}
	#scrollbarrette{
		 position: absolute;
		 top: 90px;
		 bottom: 20px;
		 right: 0;
		 width: 2px;
	}
	#scrollbarrinette{
		position: relative;
		top: 0;
		background-color: #fa7346;
		height: 100px;
		width: 2px;
	}
	#overlay_contenu{
		position: relative;
		font-family: 'Lato', sans-serif;
		pointer-events: all;
		text-align: center;	
		width: 780px;
		top: 0px;
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
	#overlay_site{
		position: absolute;
		bottom: 0;
		left: 0;
		opacity: 0;
		width: 400px;
		height: 200px;
		color: white;
		font-family: 'Lato', sans-serif; 
		text-align: center;
		pointer-events: none;
	}
	#site{
		position: relative;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
	}
	#nom_site{
		font-size: 40px;
		font-weight: 700;
	}
	#responsable_site{
		font-size: 15px;
		font-weight: 300;
	}
	#nom_responsable_site{
		font-weight: 700;
	}
	#oc_titre{
		font-size: 40px;
		font-weight: 700;
		color: #fa7346;
		pointer-events: none;
	}
	#oc_soustitre{
		font-size: 15px;
		font-weight: 700;
		color: #ffffff;
		pointer-events: none;
	}
	#soustitre_site{
		 font-weight: 700;
		 pointer-events: none;
	}
/*	#oc_texte{
		font-size: 20px;
		font-weight: 300;
		color: #ffffff;
		text-align: left;
		pointer-events: none;
	}*/
	.oc_titre{
		font-size: 40px;
		font-weight: 700;
		color: #fa7346;
		pointer-events: none;
		margin-bottom: 20px;
	}
	.oc_soustitre{
		font-size: 15px;
		font-weight: 700;
		color: #ffffff;
		pointer-events: none;
		margin-bottom: 20px;
	}
	.soustitre_site{
		 font-weight: 700;
		 pointer-events: none;
	}
	.oc_texte{
		font-size: 20px;
		font-weight: 300;
		color: #ffffff;
		text-align: left;
		pointer-events: none;
		margin-bottom: 20px;
	}
	#oc_exercices{
		font-size: 30px;
		font-weight: 300;
		color: #ffffff;
		text-align: center;
		pointer-events: all;
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
</style>
