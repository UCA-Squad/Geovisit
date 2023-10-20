@extends('admin.layouts.base')

@section('filescripts')
{{ Html::script(asset('js/popups_admin.js')) }}
{{ Html::script(asset('js/etapes_admin.js')) }}
{{ Html::script(asset('js/editeur_admin.js')) }}
{{ Html::script(asset('js/uploads.js')) }}
{{ Html::script(asset('js/geovisit_uploader.js')) }}
{{ Html::script(asset('js/bootstrap/bootstrap-confirmation.min.js')) }}
{{ Html::style(asset('css/jquery-ui/jquery-ui.css')) }}
{{ Html::script(asset('html5lightbox/html5lightbox.js')) }}
@endsection

@section('content')

@include('admin.nav-tp')

<?php $chxetapes_etape = Session::get('etapeActive') ?>
<?php $chxsite = Session::get('siteChoisi') ?>
<?php $listeAtelierAmodifier = Session::get('listeAtelierAmodifier') ?>

<div id="overlay_temp" style="display:none"></div>
<br>

<!-- multistep form -->
{{ Form::open(array('route'=>'creertp', 'method'=>'POST', 'id'=>'tpnumform')) }}
<div class="row general" style="padding:0; margin:0;"  id="editable">
    <div id="annonce_brouillon" class="alert alert-info brouillon" style="display:none;"></div>
    
    <!-- progressbar -->
    <ul id="progressbar">
        <li class="active">Sommaire</li>
        <li>Exercices</li>
        <li>Publication</li>
    </ul>    
    {{ Form::hidden('choix_site', $id_session_site, ['id' => 'choix_site']) }}
    {{ Form::hidden('etape_actuelle', $chxetapes_etape, ['id' => 'etape_actuelle']) }}
    
    <!-- fieldsets -->
    <fieldset id="fieldintro">
        <div class="row" style="margin:0;">
            <h1 class="etapes-titre">Etape 01 / Choix du site</h1>

            <table class="admin-table-input-group">
                <td class="td-label">Site</td>
                <td class="td-input">
                    @if($id_session_site == "")
                    <a href="#" id="btn_site" style="color:#ccc; text-decoration: none; display:block;">Cliquez ici pour selectionner un site<img src="{{ URL::asset('css/img/ICONE_PLUS.png') }}" style="float:right;"></a>
                    {{ Form::hidden('id_site', '', ['id' => 'id_site']) }}
                    @elseif($id_session_site != "")
                    <a href="#" id="btn_site" style="{{ ($nom_site == "") ? 'color:#ccc;' : 'color:#000;' }}text-decoration: none;display:block;">{{ $nom_site }}<img src="{{ URL::asset('css/img/ICONE_PLUS.png') }}" style="float:right;"></a>
                    {{ Form::hidden('id_site', $id_session_site, ['id' => 'id_site']) }}
                    @endif
                </td>
                <td style="border-collapse:initial; "> * <span id="erreur_site_tp" class="erreurs_admin">Vous devez selectionner un site pour votre Tp</span></td>
            </table>
        </div>
        </br>
        <div class="row" style="margin:0;">
            <h1 class="etapes-titre">Etape 02 / Titre du TP Numérique</h1>

            <table class="admin-table-input-group">
                <td class="td-label">Titre</td>
                <td class="td-input"><input type="text" class="table-admin-inputtext" name="titre_tp" id="titre_tp" value="{{ $titre_tp }}"></td>
                <td style="border-collapse:initial"> * </td>
            </table>


            <table class="admin-table-input-group">
                <td class="td-label">Description</td>
                <td class="td-input"><input type="text" class="table-admin-inputtext" name="descr_tp" id="descr_tp" value="{{ $descr_tp }}"></td>
                <td style="border-collapse:initial; "> * </td>
            </table><br>

        </div>
        </br>

        <!-- EDITEUR D'INTRODUCTION -->
        <div class="row" style="margin:0;">
            <h1 class="etapes-titre">Etape 03 / Introduction du TP Numérique</h1>
            <div class="row" style="margin:0;">
                <div id="nav_intro">
                    <ul>
                        <li><a href="#" id="titre-sommaire-button" class="liens_intros startli"><div class="liens_intro_titre"></div></a></li>
                        <li><a href="#" id="soustitre-sommaire-button" class="liens_intros ssttrli"><div class="liens_intro_soustitre"></div></a></li>
                        <li><a href="#" id="texte-sommaire-button" class="liens_intros"><div class="liens_intro_texte"></div></a></li>
                        <li><a href="#" id="photo-sommaire-button" class="liens_upload"><div class="liens_intro_photo"></div></a></li>
                        <li><a href="#" id="video-sommaire-button" class="liens_upload"><div class="liens_intro_video"></div></a></li>
                    </ul>
                </div>
            </div>
            <div class="row" style="margin:0px;">
                @if (!empty($intro_tp))
                <script>
                    $(document).ready(function () {
                        var editable = false;
                        $('.input_texte_sommaire').each(function () {
                            $(this).click(function () {
                                var _this = $(this);
                                editionintro(editable, _this, "texte", "");
                                return false;
                            });
                        });
                        $('.input_soustitre_sommaire').each(function () {
                            $(this).click(function () {
                                var _this = $(this);
                                editionintro(editable, _this, "soustitre", "");
                                return false;
                            });
                        });
                        $('.input_titre_sommaire').each(function () {
                            $(this).click(function () {
                                var _this = $(this);
                                editionintro(editable, _this, "titre", "");
                                return false;
                            });
                        });
                        $('.input_images_sommaire').each(function() {
                            $(this).click(function() {
                                var _this = $(this);
                                editionintro(editable, _this, "image", "");
                                return false;
                            });
                        });
                        $('.input_videos_sommaire').each(function() {
                            $(this).click(function() {
                                var _this = $(this);
                                editionintro(editable, _this, "video", "");
                                return false;
                            });
                        });
                    });
                </script>
                @endif
                <div id="container_intro" class="container_intro" style="min-height:300px;" class="ui-sortable">{!! $intro_tp !!}</div>
                <a href="#" id="introuction_voir" ><img src='{{ asset("/css/img/SOMMAIRE_ICONE_VOIR.png") }}'> Voir</a>
            </div>

            {{ Form::hidden('intro_tp', old('intro_tp'), ['id' => 'intro_tp']) }}
            {{ Form::hidden('intro_tp_contenu_admin', old('intro_tp_contenu_admin'), ['id' => 'intro_tp_contenu_admin']) }}

        </div>
        <!-- FIN D'EDITEUR D'INTRODUCTION -->

        <!-- CHOIX DES ATELIERS -->
        </br>
        <div class="row" style="margin:0;">
            <h1 class="etapes-titre">Etape 04 / Les ateliers</h1><br>
            <h3 class="etapes-soustitre">Sélectionner les ateliers</h3>
            <a href="{{ route('showsite', $id_session_site) }}" id="intro_voir" target="_blank" {{ !empty($id_session_site) ? '' : 'style=display:none' }}><img src='{{ asset("/css/img/SOMMAIRE_ICONE_VOIR.png") }}'> Voir Video / Carte</a>
            <div class="row" style="margin:0;">
                <div id="slider_ateliers" class="row" style="height:200px; margin:0; width:100%; padding:100px 0 50px 0;">
                    @include('admin.slider_atelier')
                </div>
            </div>
            <div class="row" style="margin:0;"><span id="erreur_ateliers_tp" class="erreurs_admin">Vous devez selectionner au moins un atelier pour votre Tp</span></div>
            <div class="row" style="margin:0;">
                <h3 class="etapes-soustitre">Titre des ateliers</h3><br>
                <div id="receptacle-ateliers" style="width:100%;">
                    @include('admin.bloc_ateliers')
                </div>
            </div>
        </div>
        <div class="bloc-boutons-submits"><input type="button" name="next" class="next action-button" value="CONTINUER" /></div>
    </fieldset>

    <!-- LES EXERCICES -->
    <fieldset id="fieldexercices">
        <h1 class="etapes-titre">Etape 05 / Les Exercices</h1>
        <div id="receptacle-exercices-placement" class="receptacle-exercices-placement" style="width:100%;">
            @include('admin.ateliers.bloc-atelier')
        </div>
        <div class="row" style="margin:0;"><span id="erreur_exercices_tp" class="erreurs_admin">Vous devez créer au moins un exercice pour votre Tp</span></div>
        <div class="bloc-boutons-submits"><input type="button" id="previous_modif_exercices" name="previous" class="previous action-button" value="PRECEDENT" /><input type="button"  name="next" class="next action-button" value="CONTINUER" /></div>
    </fieldset>
    <!-- FIN DES EXERCICES -->

    <!-- PUBLICATION -->
    <fieldset id="fieldpublication">
        <div class="row" style="margin:0;">
            <h1 class="etapes-titre">Etape 06 / PUBLICATION</h1>
            <h3 class="etapes-soustitre titre_dynamique_publication"></h3>
        </div>
        <div id="bloc-info-publier" class="row" style="height:150px; margin:0;">
            <div id="bloc-site" class="col-lg-2">
                <div class="circle_img">
                    <?php $siteChoisiImage = Session::get('siteChoisiImage') ?>
                    <img src="{{ asset($siteChoisiImage) }}" class="ronde" id="image_site_publication">
                </div>
                <p id="titre_site_publier">{{ $nom_site }}</p>
            </div>

            <div id="bloc-infos" class="col-lg-4" style="padding:auto;">
                <ul style="margin:auto;">
                    <li style="width:25%;">
                        @if(array_key_exists ('id_choisis',$listeAtelierAmodifier))
                        <?php $nbAteliersSel = is_countable($listeAtelierAmodifier['id_choisis']) ? count($listeAtelierAmodifier['id_choisis']) : 0 ?>
                        <p id="nbre_atelier_modifie" class="chiffre-info">{{$nbAteliersSel}}</p>
                        @endif
                        <p class="type-info">ateliers</p>
                    </li>
                    <li style="width:25%;">
                        <?php $totexercices = session()->get('nbexercicesTotal') ?>
                        <p id="nbre_exercice_modifie" class="chiffre-info">{{$totexercices}}</p>
                        <p class="type-info">exercices</p>
                    </li>
                    <li style="width:25%;">
                        <?php $nbgroupesSel = is_countable($groupes_selectionnes) ? count($groupes_selectionnes) : 0 ?>
                        <p id="nbre_groupe_modifie" class="chiffre-info">{{$nbgroupesSel}}</p>
                        <p class="type-info">classes</p>
                    </li>
                </ul>
            </div>
            <div id="bloc-dates" class="col-lg-2">
                Date de création</br>
                {{date('d.m.Y H:i', strtotime($date_creation))}}
            </div>
        </div>

        <div class="row" style="margin:0;">
            <h3 class="etapes-soustitre">Choix du groupe</h3>
            <div align="center">
                <span id="erreur_titre_tp" class="erreurs_admin">Veillez donner un titre à votre Tp<br></span>
                <span id="erreur_description_tp" class="erreurs_admin">Veillez donner une description à votre Tp<br></span>
                <span id="erreur_exercice" class="erreurs_admin">Veillez remplir vos exercices<br></span>
            </div>	
            <table class="admin-table-input-group">
                <td class="td-label">GROUPE</td>
                <td class="td-input">
                    <a href="#" id="btn_groupe_assign" style="color:#ccc; text-decoration: none;">Cliquez ici pour ajouter un groupe<img src="{{ URL::asset('css/img/ICONE_PLUS.png') }}" style="float:right;"></a>
                </td><td style="border-collapse:initial; "> * </td>
            </table><br>

            <div id="receptacle_groupes">
                @if(count($groupes_selectionnes) > 0)	
                @foreach ($groupes_selectionnes as $groupe)
                <div class="panel-group">
                    <div class="panel" id="paneladmin3">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <span style="width:300px;display: inline-block;">Groupe {{$groupe->titre}} </span>|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nb d’étudiant : {{ $groupe->getEtudiants()->count()}}
                                <a data-toggle="collapse" href="#collapse3{{$groupe->id}}">
                                    <img src="{{URL::asset('img/show.png') }}" style="float:right;"/>
                                </a> 
                                <img src="{{URL::asset('img/corbeille.png') }}" style="float:right;margin-right:40px;cursor:pointer" data-toggle="confirmation" data-btn-ok-label="Oui" data-btn-cancel-label="Non!" title="Voulez-vous détacher ce groupe?" data-href="{{$groupe->id}}"/>
                            </h4>
                        </div>
                        <div id="collapse3{{$groupe->id}}" class="panel-collapse collapse {{ (session('affich')==$groupe->id) ? ' in' : ''}}">
                            <div class="panel-body">
                                @if($groupe->getEtudiants()->count() > 0)
                                <table class="etudiant"> <tr>
                                        <th>N° D’ETUDIANT</th>
                                        <th>NOM</th>		
                                        <th>PRENOM</th>
                                        <th>CONTACT</th>
                                    </tr>
                                    @foreach ($groupe->getEtudiants()->get() as $etudiant)
                                    @foreach ($etudiant->user()->get() as $etudiantdetail)
                                    <tr>
                                        <td>{{$etudiantdetail->username}}</td>
                                        <td>{{$etudiantdetail->nom}}</td>
                                        <td>{{$etudiantdetail->prenom}}</td>
                                        <td>{{$etudiantdetail->email}}</td>
                                    </tr>
                                    @endforeach
                                    @endforeach
                                </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <p class="aucun_element"> Aucun Groupe(s) ajouté(s).</p>
                @endif
            </div>
            <div class="row" style="margin:0;">
                <span id="erreur_publication_groupes_tp" class="erreurs_admin">Vous devez assigner au moins un groupe à votre Tp</span>
            </div>
        </div>
        <div class="bloc-boutons-submits"><input type="button" name="previous" class="previous action-button" value="PRECEDENT" />
            {{ Form::hidden('id_brouillon', $insereId, ['id' => 'id_brouillon']) }}
            <input type="button" name="publier_maintenant" id="publier_maintenant" class="submit action-button" value="PUBLIER MAINTENANT" /></div>
        <div class="bloc-boutons-submits">
            <input type="button" name="publier_plustard" id="publier_plustard" class="submit action-button" style="background:none; color:red;" value="PUBLIER PLUS TARD" />
        </div>
    </fieldset>		
</div>
{{ Form::close() }}

{{ Form::open(array('route'=>'creertp', 'method'=>'POST', 'id'=>'tpnumform2')) }}
{{ Form::hidden('id_brouillon2', $insereId, ['id' => 'id_brouillon2']) }}
{{ Form::hidden('etat', $etat, ['id' => 'etat']) }}
{{ Form::close() }}

<!-- POPUPS -->

<!-- SITES -->
<div id="popup_sites_chx" class="dialog_operations">
    <a href="#" id="close_sites" class="fermerpopup" style="font-family: 'Lato', sans-serif;font-weight: 300;color:white;font-size:30px;float:right;padding:20px;">FERMER X</a>
    <div id="contenus_popup_sites_chx" class="contenu-cacher">
        <div id="choix_sites" class="content_popup_admin">
            <h1 class="etapes-titre">Etape 01 / Choix du site</h1>
            <br><br>
            <div class="row" style="text-align:center; width:100%; margin-top:40px;">
                <div id="slideshow" style="text-align:center;margin: auto;">
                    @foreach($sites as $site)
                    <fieldset id="site_{{ $site->id }}" class="fields-site-popup" style="width:90%; margin-right:auto; margin-left:auto;">
                        <div class="row">
                            @if($sites->first() == $site)
                            <div class="col-lg-3"></div>
                            @else
                            <a href="#" id="fleche_gauche_site_{{ $site->id }}" class="fleche_gauche_site col-lg-3">
                                <div class="fleche_gauche_site_img"></div>
                            </a>
                            @endif	
                            <div class="col-lg-6">
                                <div class="col-lg-4">
                                    <div class="circle_img_popup">
                                        <img src="{{ asset($site->photo) }}" class="ronde">
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <h1 class="srtitre">{{ $site->titre }}</h1>
                                    <p class="presentation">Ceci est un emplacement de texte pour une petite presentation présentant le contenue du parcours sur 3 lignes Max</p>
                                    <a href="{{route('voirsite', $site->id)}}" id="intro_voir_site" style="color:#f96332; float:right;">Voir le site ></a>
                                </div>
                            </div>
                            @if($sites->last() == $site)
                            <div class="col-lg-3"></div>
                            @else
                            <a href="#" id="fleche_droite_site_{{ $site->id }}" class="fleche_droite_site col-lg-3"><div class="fleche_droite_site_img" style="float:right;"></div></a>
                            @endif
                        </div>
                        <div class="row">
                            <div class="bloc-boutons-submits"><a href="#" id="submit_chx_site_{{ $site->id }}" class="submit action-button valid-choix-site">Valider</a></div>
                        </div>
                    </fieldset>
                    @endforeach	
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIN SITES -->

<!-- POPUP CHOIX GROUPES -->
<div id="popup_groupes_chx" class="dialog_operations">
    <div id="contenus_popup_groupes_chx" class="contenu-cacher">
        <div id="choix_groupes" class="content_popup_admin_groupes">
            <a href="#" id="close_sites" class="fermerpopup"  style="font-family: 'Lato', sans-serif;font-weight: 300;color:grey;font-size:20px; float:right; padding:10px; ">&times;</a>
            <h3>CHOISISSEZ LES GROUPES POUR CE TP</h3>
            <div class="row" style="width:100%; margin-top:10px;max-height:480px; overflow:auto">
                <div id="bloc_table_chx" style=";margin: auto;">
                    <div id="barre-groupe-publier" class="btn-group" width="100%">
                        @if(count($groupes) > 0)	
                        @foreach ($groupes as $groupe)
                        <div class="panel-group">
                            <div class="panel" id="paneladmin">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <span style="width:300px;display: inline-block;">Groupe {{$groupe->titre}} </span>|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nb d’étudiant : {{$groupe->getEtudiants()->count()}}
                                        {{ Form::checkbox('chx_groupe[]', 
                                                    $groupe->id, 
                                                    Session::has('enmodification') ? (count($groupes_selectionnes) > 0 ? (in_array($groupe->id, array_column($groupes_selectionnes->toArray(), 'id')) ? true : false) : false) : false, ['style' => 'float: right;margin-left: 20px;']) }}
                                        <a data-toggle="collapse" href="#collapse{{$groupe->id}}"><img src="{{URL::asset('img/show.png') }}" style="float:right;"/></a> </h4>
                                </div>
                                <div id="collapse{{$groupe->id}}" class="panel-collapse collapse {{ (session('affich')==$groupe->id) ? ' in' : ''}}">
                                    <div class="panel-body">
                                        @if($groupe->getEtudiants()->count() > 0)
                                        <table class="etudiant"> 
                                            <tr>
                                                <th>N° D’ETUDIANT</th>
                                                <th>NOM</th>		
                                                <th>PRENOM</th>
                                                <th>CONTACT</th>
                                            </tr>
                                            @foreach ($groupe->getEtudiants()->get() as $etudiant)
                                            @foreach ($etudiant->user()->get() as $etudiantdetail)
                                            <tr>
                                                <td>{{$etudiantdetail->username}}</td>
                                                <td>{{$etudiantdetail->nom}}</td>
                                                <td>{{$etudiantdetail->prenom}}</td>
                                                <td>{{$etudiantdetail->email}}</td>
                                            </tr>
                                            @endforeach
                                            @endforeach
                                        </table>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @else
                        Vous n'avez aucun groupe!
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="bloc-boutons-submits"><a href="#" id="submit_chx_groupe" class="submit action-button">Valider</a></div>
            </div>
        </div>
    </div>
</div>
<!-- FIN GROUPES -->

<script>
    $(document).ready(function () {
        $("#introuction_voir").click(function () {
            $("html").css('overflow-y', 'hidden');
            $("#overlay_temp").addClass('overlay');
            $("#overlay_temp").load("{{url('/intro')}}", chargerIntro);
            $("#overlay_temp").show();
            $("#overlay_temp").click(function (e) {
                $("#overlay_temp").removeClass('overlay');
                $("#overlay_temp").hide();
                $("#overlay_temp").empty();
                $("html").css('overflow-y', 'auto');
            });
        });
        
        //détecter le changement pour enregistrer broullion
        var a_change = false;
        var elments_changes = [];
        $('#id_site, #titre_tp, #descr_tp, #intro_tp, #intro_tp_contenu_admin').on('change', function () {
            var change = this.name;
            if (elments_changes.indexOf(this.name) === -1) {
                elments_changes.push(this.name);
            }
            a_change = true;
        });
        function brouillon() {
            if (a_change && $('input[name=id_site]').val() !== "") {
                var tosubmit = {};
                tosubmit['_token'] = $('input[name=_token]').val();
                elments_changes.forEach(function (element) {
                    tosubmit[element] = $('input[name=' + element + ']').val();
                });
                var id_brouillon = $("#id_brouillon").val();
                $.ajax({
                    url: host + '/admin/tpnumerique/brouillon/' + id_brouillon + '/' + elments_changes.join("+"),
                    type: "post",
                    data: tosubmit,
                    dataType: "json",
                    success: function (data) {
                        elments_changes = [];
                        a_change = false;
                    },
                    error: function (XMLHttpRequest) {
                    }
                });
            }
        }
        
        //exécuter l'enregistrement brouillon toutes les 5 minutes
//        var myTimer = setInterval(brouillon, 300000);
//        
        //reset de temps d'execution on clique sur continuer
        $(".next").on('click', function () {
            if ($("#etape_actuelle").val() === "fieldintro") {
                clearInterval(myTimer);
                myTimer = setTimeout(brouillon, 1500);;
            }
        });
        
        function chargerIntro() {
            $("#overlay_contenu").html(prepareIntro($("#container_intro").html(), "intro")); 
            if ($("#overlay_click").height() > $("#overlay_contenu").height()) {
                $("#scrollbarrette").css({"opacity": "0"});
            }
            $("#nom_site").append("{!!$nom_site!!}".toUpperCase()); //site du TPN
            $("#nom_responsable_site").append("{!!Auth::user()->prenom!!} {!!Auth::user()->nom!!}");
        }
        
        $("#editable").on("paste", function (evnt) {
            evnt.preventDefault();
            var plain_text = (evnt.originalEvent || evnt).clipboardData.getData('text/plain');
            if (typeof plain_text !== 'undefined') {
                document.execCommand('insertText', false, plain_text);
            }
        });
        
        $('[data-toggle=confirmation]').confirmation({onConfirm: function () {
                $("input[name='chx_groupe[]'][value=" + $(this).attr('data-href') + "]").prop('checked', false);
                $('#submit_chx_groupe').click();
            }});
        $("#submit_chx_groupe").click(function () {
            
            var groupes_tp = $("input[name='chx_groupe[]']:checked").map(
                    function () {
                        return this.value;
                    }).get();
                    
            $.ajax({
                method: "POST",
                url: host + '/admin/tpnumerique/choixgroupes',
                data: {'choix': groupes_tp, '_token': $('input[name=_token]').val()},
                dataType: "json"}
            ).done(function (response) {
                var resultat = response.maquettes;
                $("#popup_groupes_chx").removeClass('active').addClass('dialog_operations');
                $("#contenus_popup_groupes_chx").removeClass('active').addClass('contenu-cacher');
                $("#receptacle_groupes").html('');
                $("#receptacle_groupes").html(resultat);
                $('#nbre_groupe').html(response.nbre);
                $('[data-toggle=confirmation]').confirmation({onConfirm: function () {
                        $("input[name='chx_groupe[]'][value=" + $(this).attr('data-href') + "]").prop('checked', false);
                        $('#submit_chx_groupe').click();
                    }});
            });
        });
        $("#btn_groupe_assign").click(function () {
            $("#popup_groupes_chx").removeClass('dialog_operations').addClass('active');
            $("#contenus_popup_groupes_chx").removeClass('contenu-cacher').addClass('active');            
        });
    });
</script>

<style>
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #000;
        filter:alpha(opacity=50);
        -moz-opacity:0.5;
        -khtml-opacity: 0.5;
        opacity: 0.85;
        z-index: 10000;
    }
    #popup_groupes_chx.active {
        z-index:3000; width:100%; height:100%; position: fixed; top: 0; left: 0; background-color: rgba(0,0,0,0.25);
        display: block;
    }


    #contenus_popup_groupes_chx{
        display:none;
    }

    #contenus_popup_groupes_chx.active   {
        display:block;
    }

    #popup_groupes_chx {
        font-family: 'Lato', sans-serif;
        color:grey;
    }

    #popup_groupes_chx .submit {
        height: 45px;
        width: 300px;
        background: #f96332;
        font-weight: bold;
        color: white;
        border: 1px;
        cursor: pointer;
        padding: 10px 5px;
        margin: 20px auto;
        border-radius: 50px;
        font-family: 'Lato', sans-serif;
        display: block;
        font-size: 16px;
    }

    #popup_groupes_chx h3 {
        margin-bottom:20px;
    }
    
    #popup_groupes_chx p  {
        font-weight: 300;
        text-align: center;
    }

    .bloc-boutons-submits {
        padding-top: 0;
        padding-right:auto; 
        padding-left:auto; 
        width:100%; 
        text-align:center;
    }

    .content_popup_admin_groupes  {
        width:1000px;
        height:670px;
        margin:auto;
        padding:30px;
        margin-top: 200px;
        background:white;
    }
    .panel{font-family: 'Lato', sans-serif; font-weight:700px; font-size:16px; }
    .panel-heading { color:white;    background-color: #f96332;padding: 20px}
    .panel-body{max-height:500px; overflow:auto;}
    .panel-group{width: 900px;}
    .panel .popover-title{color:#000}
</style>

@endsection