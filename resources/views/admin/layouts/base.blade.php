<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name='csrf-token' content="{{ csrf_token() }}">

        {{ Html::style(asset('css/google/google-fonts.css')) }}
        {{ Html::style(asset('css/admin/admin.css')) }}
        {{ Html::style(asset('css/admin/popups.css')) }}
        {{ Html::style(asset('css/bootstrap/bootstrap.css')) }}
        {{ Html::style(asset('css/jquery-ui/jquery-ui.css')) }}
        {{ Html::style(asset('js/DataTables/datatables.css')) }}

        {{ Html::script(asset('js/jquery/jquery.min.js')) }}

        {{ Html::script(asset('js/bootstrap/bootstrap.min.js')) }}        

        {{ Html::script(asset('js/jquery/jquery-ui.js')) }} 
        {{ Html::script(asset('js/jquery/jquery.easing.min.js')) }}

        {{ Html::script(asset('js/TweenMax.min.js')) }}
        {{ Html::script(asset('js/Draggable.min.js')) }}
        {{ Html::script(asset('js/CSSPlugin.min.js')) }}
        {{ Html::script(asset('js/dropzone.js')) }}
        {{ Html::script(asset('js/vivus.min.js')) }}
        {{ Html::script(asset('js/DataTables/datatables.min.js')) }}

        @yield('filescripts')

        <title>Geovisit - Administration</title>

        <script>
            var host = "{{URL::to('/')}}";
            var hst = "{{URL::to('/img/img_editeur')}}";
            var upload = "{{route('uploader')}}";
        </script>
    </head>
    <body style="overflow-x: hidden;">
        <div id="popup_sites" class="dialog_operations" style="display:none;">
            <a href="#" id="fermerpopup" style="font-family: 'Lato', sans-serif;
               font-weight: 300;
               color:white;
               font-size:30px; float:right; padding:20px;">FERMER X</a>
        </div>

        <div class="wrapper">
            <div class="rows">
                <div class="gch">
                    <div id="logo_admin"></div>
                    <div id="log_infos">
                        Bonjour,</br>
                        <span class="nom_user" style="font-size:26px; text-transform: uppercase;">{{ Auth::user()->nom }}<br>{{ Auth::user()->prenom }}</span>
                        </br></br>
                    </div>
                    <div class="deconnexion">
                        <a href="{{ url('/logout') }}" title="deconnexion"><div id="icon_logout"></div><div class="libelle">Deconnexion</div></a>
                    </div>
                    <hr class="hr_log_infos">
                    <div id="nav_admin">
                        <ul style="list-style: none;">
                            @if(Session::has('rubrique'))
                            <?php $chxrubrique = Session::get('rubrique'); ?>
                            <li>
                                @if($chxrubrique  == 'profil')
                                <a href="{{ route('profil') }}" class="admin_menu_links-visited" style=" text-decoration:none; color:white;" title="profil">
                                @else
                                <a href="{{ route('profil') }}" class="admin_menu_links" style=" text-decoration:none; color:white;" title="profil">
                                @endif
                                    <div class="icon_profil"></div>
                                    <span class="lien">PROFIL</span>
                                </a>
                            </li>
                            @if(Auth::user()->is_admin == 1)   
                            <li>
                                @if($chxrubrique  == 'professeur')
                                <a href="{{ route('professeur') }}" class="admin_menu_links-visited" style=" text-decoration:none; color:white;" title="enseignants">
                                @else
                                <a href="{{ route('professeur') }}" class="admin_menu_links" style=" text-decoration:none; color:white;" title="enseignants">
                                @endif
                                    <div class="icon_professeur"></div>
                                    <span class="lien">ENSEIGNANTS</span>
                                </a>
                            </li>
                            <li>
                                @if($chxrubrique == 'etudiants')
                                <a href="{{ route('admin::etudiants::index') }}" class="admin_menu_links-visited" style="text-decoration: none;color: white;" title="etudiants">
                                @else
                                <a href="{{ route('admin::etudiants::index') }}" class="admin_menu_links" style="text-decoration: none;color: white;" title="etudiants">
                                @endif
                                    <div class="icon_etudiant"></div><span class="lien">ETUDIANTS</span>
                                </a>
                            </li>
                            @endif
                            <li>
                                @if($chxrubrique == 'groupes')
                                <a href="{{ route('groupes') }}" class="admin_menu_links-visited" style=" text-decoration:none; color:white;" title="groupes">
                                @else
                                <a href="{{ route('groupes') }}" class="admin_menu_links" style=" text-decoration:none; color:white;" title="groupes">
                                @endif
                                    <div class="icon_groupes"></div><span class="lien">GROUPES</span>
                                </a>
                            </li>
                            <li>
                                @if($chxrubrique == 'gestion' || $chxrubrique == 'tp')
                                    @if(Session::has('tpssrub'))
                                        @if(Session::get('tpssrub') == 'nouveau' || Session::get('tpssrub') == 'gerer')
                                            <a href="{{ route('gerertp') }}" class="admin_menu_links-visited" style=" text-decoration:none; color:white;" title="tp numériques">
                                        @endif
                                    @endif
                                @else
                                    <a href="{{ route('gerertp') }}" class="admin_menu_links" style=" text-decoration:none; color:white;" title="tp numériques">
                                @endif	
                                <div class="icon_tp"></div><span class="lien">TP NUMERIQUES</span></a>
                            </li>
                            @if(Auth::user()->is_admin == 1)  
                            <li>
                                @if($chxrubrique == 'gestionsite' || $chxrubrique == 'site')
                                    <a href="{{ route('admin::site::edit') }}" class="admin_menu_links-visited" style=" text-decoration:none; color:white;" title="sites">
                                @else
                                    <a href="{{ route('admin::site::edit') }}" class="admin_menu_links" style=" text-decoration:none; color:white;" title="sites">
                                @endif
                                <div class="icon_site"></div><span class="lien">SITES</span></a>
                            </li>
                            @endif
                            <li><a href="{{ route('fichiers') }}" class="admin_menu_links" style="text-decoration:none; color:white;" title="fichiers"><div class="icon_fichiers"></div><span class="lien">FICHIERS</span></a></li>
                        </ul>
                        @endif
                        <hr>
                    </div>
                    <div class="front"><a href="{{ url('/choix') }}" title="selection tpn"><div id="icon_sortie"></div><div class="libelle">SELECTION TPN</div></a></div>
                </div>
                <div class="drt">

                    @yield('content')
                    @if($chxrubrique == 'tp' || $chxrubrique  == 'profil')
                    @include('admin.popups')
                    @include('admin.ateliers.popups_exercices')
                    @endif	


                </div>
            </div>
        </div>
        <style>
            .wrapper {
                /* display:table;*/
                width:100%;
                /*height:auto;*/
            }
            .rows {
                /* display:table-row;*/
            }
            .gch {
                width:30%;
                height:100%;
                min-width:300px;
                max-width:300px;
                position:relative;
                /* display:table-cell;*/
                padding:0; 
                margin-right:25px; background:#f96332;
                position:fixed;
                float:left;
                display:inline;
                left: 0;
                top: 0;
                bottom: 0;

            }

            .drt {

                width:80%;
                min-width:60%;
                padding-left:10px;
                padding-right:30px;
                margin-top:0;
                padding-top:0;
                /*display:table-cell;*/
                /* vertical-align:top;*/
                /* overflow-x:hidden;*/
                /*overflow-y:hidden;*/
                float:left;
                /*margin-bottom: -101%;
                 padding-bottom: 101%;*/
                left:320px;
                position:relative;
                display:inline;
            }
            #logo_admin
            {
                background-image: url("{{ asset('/css/img/logo_blanc.png') }}");
                background-repeat: no-repeat;
                height:100px; width:176px;
                margin-left:auto; margin-right:auto;
                margin-top:20px;
                background-size: contain;
            }

            .nom_user
            {
                font-size:16px; text-transform: uppercase;
            }

            @media screen and (min-width: 15em) and (max-width: 90em) {

                .gch {
                    width:20%;
                    height:100%;
                    min-width:55px;
                    max-width:55px;
                    position:relative;
                    padding:0; 
                    margin-right:25px; background:#f96332;
                    position:fixed;
                    float:left;
                    display:inline;
                    left: 0;
                    top: 0;
                    bottom: 0;

                }


                .lien, .libelle, .nom_user
                {
                    display:none;
                }

                .drt {

                    width:95%;
                    min-width:90%;
                    padding-left:10px;
                    padding-right:10px;
                    margin-top:0;
                    padding-top:0;
                    float:left;
                    left:65px;
                }

                #logo_admin
                {
                    background-image: url("{{{ asset('/css/img/logo_blanc_reduit.png') }}}");
                    background-repeat: no-repeat;
                    width:50px;
                    height:70px;
                    margin-left:auto; margin-right:auto;
                    margin-top:10px;

                }


                a.admin_menu_links
                {
                    font-family: 'Lato', sans-serif; 
                    padding: 5px 10px;
                    width:100%;
                    float:left;
                }
                a.admin_menu_links-visited, a.admin_menu_links:hover
                {
                    background:#e05c31;
                    border-left:3px solid #79321B;
                    font-family: 'Lato', sans-serif; 
                    width:100%;
                    float:left;
                    padding: 5px 10px;
                    padding-left:7px;


                }

                .icon_groupes
                {
                    width:45px;
                    height:45px;
                    background-image: url("{{ asset('/css/img/barre_icones_reduit_moins.png')}}");
                    background-repeat:no-repeat;
                    float:left;
                    background-position: 0 35%; 
                }
                .icon_tp
                {
                    width:45px;
                    height:45px;
                    background-image: url("{{ asset('/css/img/barre_icones_reduit_moins.png')}}");
                    background-repeat:no-repeat;
                    float:left;
                    background-position: 0 68%; 
                }

                .icon_fichiers
                {
                    width:45px;
                    height:45px;
                    background-image: url("{{ asset('/css/img/barre_icones_reduit_moins.png')}}");
                    background-repeat:no-repeat;
                    float:left;
                    background-position: 0 104%; 
                }

                .icon_profil
                {

                    width:45px;
                    height:45px;
                    background-image: url("{{ asset('/css/img/barre_icones_reduit_moins.png')}}");
                    background-repeat:no-repeat;
                    background-position: 0 0%;
                    float:left;

                }
                .icon_professeur
                {

                    width:45px;
                    height:45px;
                    background-image: url("{{ asset('/css/img/ICON_PROF_REDUIT.png')}}");
                    background-repeat:no-repeat;
                    background-position: 0 0%;
                    float:left;

                }
                .icon_etudiant {
                    width: 45px;
                    height: 45px;
                    background-image: url("{{ asset('/css/img/ICON_STUDENT_REDUIT.png') }}");
                    background-repeat: no-repeat;
                    background-position: 0 0%;
                    float: left;
                }
                .deconnexion #icon_logout
                {
                    width:40px;
                    height:46px;
                    background-image: url("{{ asset('/css/img/logout_reduit.png')}}");
                    background-repeat:no-repeat;
                    border:none;
                    display: inline-block;
                    margin-top:20px;

                }

                .deconnexion
                {
                    padding: 5px 12px;
                }

                #log_infos
                {
                    display:none;
                }

                .front #icon_sortie
                {
                    width:40px;
                    height:46px;
                    background-image: url("{{ asset('/css/img/sortie_reduit.png')}}");
                    background-repeat:no-repeat;
                    border:none;
                    display: inline-block;

                }
                .front{ margin-top: 150px; margin-left:15px}
            }

            @media screen and (min-width: 15em) and (max-width: 90em) {
                html { overflow-x: hidden;}
            }


            @yield('style')

        </style>
        @yield('styles')
        @yield('scripts')
    </body>
</html>