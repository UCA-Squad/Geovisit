<div class="row" style="margin:0; padding:0; top:0;">
	<div id="fonctions">
	@if(Session::has('tpssrub'))
		<?php $chxssrubrique = Session::get('tpssrub'); ?>
		<ul id="menu_fonctions">
			<li>
				@if($chxssrubrique  == 'nouveau')
					<a href="{{route('nouveautp') }}" class="menufonction-visited">Nouveau</a>
				@else
					<a href="{{route('nouveautp') }}">Nouveau</a>
				@endif
			</li>
			<li>
				@if($chxssrubrique  == 'gerer')
					<a href="{{route('gerertp') }}" class="menufonction-visited">Gerer</a>
				@else
					<a href="{{route('gerertp') }}">Gerer</a>
				@endif
			</li>
		</ul>
	@endif	
	</div>
</div>