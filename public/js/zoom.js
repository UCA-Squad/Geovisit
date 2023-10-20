var niveauZoom = 18;
var tailleZoom = 560;
var cranZoom = (-tailleZoom)/(- niveauZoom);
			
var krpano; 
var fov;
var delta;
		
var rayonCercle = 2*Math.PI*38;
$("#cercleFait").attr({"stroke-dasharray": (rayonCercle*2/3) + " " + (rayonCercle*1/3)});
$("#cerclePasFait").attr({"stroke-dasharray": 0 + " " + (rayonCercle*2/3) + " " + (rayonCercle*1/3)});
						
setInterval(function(){
	if(document.getElementById("krpanoSWFObject")){
		fov = document.getElementById("krpanoSWFObject").get("view.fov");
		fovmin = document.getElementById("krpanoSWFObject").get("view.fovmin");
		fovmax = document.getElementById("krpanoSWFObject").get("view.fovmax");
		ecartfov = fovmax - fovmin;
		$("#ligneZoom").css({"top":(-520*(fovmin-fov)-ecartfov*560)/ecartfov+"px"});
		$("#zoomNbExercices").css({"top":(-520*(fovmin-fov)-ecartfov*560)/ecartfov+"px"});	
	}
}, 30);
