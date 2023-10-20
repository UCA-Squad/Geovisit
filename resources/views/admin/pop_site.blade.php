<div id="overlay_click">
	<div id="bloc_nom">
		<div id="bonjour">Bonjour {{ Auth::user()->nom }}</div>
		<div id="barre">
			<svg width="700" height="10">
				<path stroke="white" stroke-opacity="1" stroke-width:"1px" d="M30 5 L670 5"/>
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
	<div id="bloc_bouton">
		<svg id="bouton_svg_choix" width="450" height="120">
			<rect id="bouton_forme_choix" x="25" y="25%" rx="30" ry="30" width="400" height="60" style="fill:#f96331;stroke:none;stroke-width:1;fill-opacity:1;stroke-opacity:1"/>
		</svg>		
		<div id="bouton_label_choix">CONTINUER</div>
	</div>
</div>