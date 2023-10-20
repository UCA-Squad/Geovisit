<div class="row" style="margin:0; padding:0; top:0;">
    <div id="fonctions">
        @if(Session::has('sitessrub'))
        <?php $chxssrubrique = Session::get('sitessrub') ?>
        <ul id="menu_fonctions">
            <li>
                @if($chxssrubrique  == 'nouveau')
                <a href="{{route('admin::site::new') }}" class="menufonction-visited">Nouveau</a>
                @else
                <a href="{{route('admin::site::new') }}">Nouveau</a>
                @endif
            </li>
            <li>
                @if($chxssrubrique  == 'gerer')
                <a href="{{route('admin::site::edit') }}" class="menufonction-visited">Gerer</a>
                @else
                <a href="{{route('admin::site::edit') }}">Gerer</a>
                @endif
            </li>
        </ul>
        @endif	
    </div>
</div>