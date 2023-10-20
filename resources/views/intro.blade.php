@extends('layouts.intro')
@section('header')
{{ Html::script(asset('js/howler/howler.js')) }}
	<script>
	var snd_wind = new Howl({urls:['snd/wind.mp3'], loop:true, volume:1.0});
	var snd_intro = new Howl({urls:['snd/intro.mp3'], sprite:{intro:[0, 39500], loop:[39500, 171000]}});
	snd_intro.onend = (function () {snd_intro.play('loop'); snd_intro.loop = true;});
	snd_wind.play();
	snd_intro.play('intro');

	 </script>
@endsection
@section('content')
	<!--Éléments de HUD : logo et bouton-->
	<div id="overlay">
		<!--Logo GéoVisit-->
		<img id="splash" src="img/splash.png"></img>
		<!--Bouton Continuer-->
		<div id="bouton"><br/>
			<svg id="bouton_svg" width="400" height="120">
				<rect id="bouton_rect" x="25%" y="25%" rx="30" ry="30" width="200" height="60" style="fill:#f96331;stroke:none;stroke-width:1;fill-opacity:1;stroke-opacity:1"/>
			</svg>
			<div id="bouton_label">ENTRER</div>
		</div>
	</div>
	<!--Vidéo du background-->
	<video id="v1" autobuffer preload loop muted class="video-js">
		<source src="https://opencast.dsi.uca.fr/static/mh_default_org/engage-player/54c8e722-cdf5-4b33-8fa1-5b5ba83c4bdd/64290b12-33b4-46a5-b129-4f2773425cf4/60d76425-ba66-42aa-8368-2822abc335d7.mp4" type="video/mp4">
	</video>
	<!--Canvas pour flouter la vidéo à la transition-->
	<canvas id="canvas"></canvas>
@endsection
@section('scripts')
 <script>
	var myVideo = document.getElementById("v1");
	var splash = $("#splash");
	var bouton = $("#bouton");
	var tl = new TimelineLite();
	var tl2 = new TimelineLite();

	$(document).ready(function(){
		myVideo.play();
		tl.to(splash, 1, {autoAlpha: 1}, 2);
		tl.to(bouton, 1, {autoAlpha: 1});
		
	});
	$("#bouton_rect").mouseover(function() {
		$("#bouton_rect").css({fill: "#fa6b3b"});
	});
	$("#bouton_rect").mouseleave(function() {
		$("#bouton_rect").css({fill: "#f96331"});
	});
	$("#bouton_rect").mousedown(function() {
		$("#bouton_rect").css({fill: "#f96331"});
	});
	var v = document.getElementById('v1');
	var c = document.getElementById('canvas');
	var ctx = c.getContext('2d');
	var back = document.createElement('canvas');
	var backcontext = back.getContext('2d');

	var cw,ch;
	
	document.getElementById("bouton_rect").addEventListener('click', function(){
		$("#bouton_rect").css({"pointer-events": "none"});
		snd_wind.fadeOut(0.5, 3000);
		tl2.to("#bouton", 1, {autoAlpha: 0});
		tl2.to("#splash", 1, {autoAlpha: 0});
		cw = v.clientWidth;
		ch = v.clientHeight;
		c.width = cw;
		c.height = ch;
		back.width = cw;
		back.height = ch;
		//draw(v,ctx,backcontext,cw,ch);
		tl2.to(myVideo, 1, {autoAlpha: 0}, "-=0.5");
		integralBlurCanvasRGB("canvas", 0, 0, cw, ch, 100, 1);
		$(document.body).append("<div id=\"overlay_temp\"></div>");
		$("#overlay_temp").css({"position": "absolute", "opacity": "0", "width": "100%", "height": "100%", "top": "0", "left": "0"});
		$("#overlay_temp").load("{{ url('/login') }}");
		tl2.to("#overlay_temp", 0.5, {autoAlpha: 1, onComplete: function(){myVideo.pause();}}, "-=0.5");
	},false);

	//A supprimer si pas utilisé => en commentaire pour enlever la video d'intro du git
	/*function draw(v,c,bc,w,h) {
		if(v.paused || v.ended) return false;
		// First, draw it into the backing canvas
		bc.drawImage(v,0,0,w,h);
		// Grab the pixel data from the backing canvas
		var idata = bc.getImageData(0,0,w,h);
		var data = idata.data;
		// Loop through the pixels, turning them grayscale
		for(var i = 0; i < data.length; i+=4) {
			var r = data[i];
			var g = data[i+1];
			var b = data[i+2];
			//noir et blanc
			var brightness = (r+g+b)/3;
			data[i] = r+62;
			data[i+1] = g+25;
			data[i+2] = b+12;
		}
		idata.data = data;
		// Draw the pixels onto the visible canvas
		c.putImageData(idata,0,0);
	
		// Start over!
		//setTimeout(function(){ draw(v,c,bc,w,h); }, 0);
	}*/

 </script>  
@endsection        
