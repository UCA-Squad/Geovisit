	<div id="overlay_click">
		<div id="overlay_contenu">
			 <div id="oc_titre"></div>
			 <div id="oc_soustitre">Site <span id="soustitre_site"></span></div>
			 <div id="oc_texte"><br/></div>
			 <div id="oc_exercices"><br/></div>
			 <div id="oc_bouton"><br/>
				<svg id="oc_boutonsvg" width="400" height="120">
					<rect id="oc_boutonforme" x="25%" y="25%" rx="30" ry="30" width="200" height="60" style="fill:none;stroke:white;stroke-width:1;fill-opacity:0.3;stroke-opacity:1"/>
				</svg>		
				<div id="oc_boutonlabel">CONTINUER</div>
			</div>
		</div>
		<div id="overlay_croix">
			<svg width="50" height="50">
					<path stroke="#ffffff"  d="M20 20 L30 30"/>
					<path stroke="#ffffff"  d="M20 30 L30 20"/>
			</svg>	
		</div>
	</div>
</body>
<script>
	$("#oc_boutonforme").mouseover(function() {
		$("#oc_boutonforme").css({fill: "grey"});
	});
	$("#oc_boutonforme").mouseleave(function() {
		$("#oc_boutonforme").css({fill: "none"});
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
		background-color: transparent;
	}
	#overlay_click{
		position: absolute;
		top: 50%;
		left: 50%;
		width: 500px;
		pointer-events: none;
		
		transform: translate(-225px, -50%);
	}
	#overlay_contenu{
		float: left;
		width: 90%;
		font-family: 'Lato', sans-serif;
		pointer-events: all;
		}
	#overlay_croix{
		float: left;
		width: 10%;
		text-align: right;
		color: white;
		}
	.oc_titre{
		font-size: 40px;
		font-weight: 700;
		color: #fa7346;
		text-align: right;
		pointer-events: none;
		margin-bottom: 20px;
	}
	.oc_soustitre{
		font-size: 15px;
		font-weight: 300;
		color: #ffffff;
		text-align: right;
		pointer-events: none;
		margin-bottom: 20px;
	}
		#oc_titre{
		font-size: 40px;
		font-weight: 700;
		color: #fa7346;
		text-align: right;
		pointer-events: none;
		margin-bottom: 20px;
	}
	#oc_soustitre{
		font-size: 15px;
		font-weight: 300;
		color: #ffffff;
		text-align: right;
		pointer-events: none;
		margin-bottom: 20px;
	}
	#soustitre_site{
		 font-weight: 700;
		 pointer-events: none;
	}
	.oc_texte{
		font-size: 20px;
		font-weight: 300;
		font-style: italic;
		color: #ffffff;
		text-align: right;
		pointer-events: none;
		margin-bottom: 20px;
	}
		#oc_texte{
		font-size: 20px;
		font-weight: 300;
		font-style: italic;
		color: #ffffff;
		text-align: right;
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

