@extends('admin.layouts.base')

@section('filescripts')

{{ Html::style(asset('css/admin/site.css')) }}
{{ Html::style(asset('css/leaflet/leaflet.css')) }}
{{ Html::style(asset('css/leaflet/leaflet.draw.css')) }}

{{ Html::script(asset('js/etapes_admin_sites.js')) }}
{{ Html::script(asset('js/leaflet/leaflet.js')) }}
{{ Html::script(asset('js/leaflet/leaflet.draw.js')) }}
{{ Html::script(asset('js/admin/site.js')) }}
{{ Html::script(asset('js/admin/map.js')) }}
@endsection

@section('content')

@include('admin.nav-site')
<?php $chxetapes_etape = Session::get('etapeActiveSite') ?>

<?php $chxsite = Session::get('siteChoisi') ?>
<br>


<!-- multistep form -->
<div class="row general" style="padding:0; margin:0;">

    <div id="annonce_brouillon" class="alert alert-info brouillon" style="display:none;"></div>

    {{ Form::open(array('route'=>'admin::site::create', 'method'=>'POST', 'id'=>'sitenumform', 'files' => true)) }}
    {{ Form::hidden('etat_brouillon', $etat_actuel, ['id' => 'etape_brouillon']) }}
    {{ Form::hidden('etat_site', $etat, ['id' => 'etat_site']) }}
    {{ Form::hidden('id_brouillon', $insereId, ['id' => 'id_brouillon']) }}
    {{ Form::hidden('choix_site', $id_session_site, ['id' => 'choix_site']) }}
    {{ Form::hidden('etape_actuelle_site', $chxetapes_etape, ['id' => 'etape_actuelle_site']) }}

    <!-- progressbar -->
    <ul id="progressbar_sites">
        <li class="active">Sommaire</li>
        <li>Ateliers</li>
        <li>Visualisation</li>
    </ul>

    <!-- fieldsets -->
    <fieldset id="fieldsiteintro">
        <div class="row" style="margin:0;">
            <h1 class="etapes-titre">Etape 01 / Nom du site</h1>
            <table class="admin-table-input-group">
                <td class="td-label">Site</td>
                <td class="td-input {{ $errors->has('nom_site') ? 'has-error' : '' }}">
                    {{ Form::text('nom_site', $nom_site, ['placeholder' => 'Saisir le nom du site', 'class' => 'table-admin-inputtext']) }}
                </td>
                <td style="border-collapse:initial; "> * </td>
            </table>
            <small class="error-msg">{{ $errors->first('nom_site', ':message') }}</small>            
        </div>
        <br><br>

        <div class="row" style="margin:0;">
            <h1 class="etapes-titre">Etape 02 / Nom du dossier 'TAG'</h1>
            <table class="admin-table-input-group">
                <td class="td-label">TAG</td>
                <td class="td-input {{ $errors->has('tag_site') ? 'has-error' : '' }}">
                    {{ Form::text('tag_site', $tag_site, ['placeholder' => 'Saisir le nom du tag', 'class' => 'table-admin-inputtext']) }}
                </td>
                <td style="border-collapse:initial"> * </td>
            </table>
            <small class="error-msg">{{ $errors->first('tag_site', ':message') }}</small>
            <span class="erreurs_admin" style="display:block; text-transform: uppercase;">Attention le TAG ne pourra plus être modifié ultèrieurement</span>
            <br>
        </div>
        </br><br>

        <div class="row" style="margin: 0;">
            <h1 class="etapes-titre">Etape 03 / Ajouter la 'Photo du Site'</h1>
            <table class="admin-table-input-group">
                <td class="td-label">Photo</td>
                <td class="td-input {{ $errors->has('photo_site') ? 'has-error' : '' }}">
                    <label class="custom-file-upload">
                        {{ Form::file('photo_site', ['accept' => '.png, .jpg', 'class' => 'input-file']) }}
                        <span>Cliquez ici pour ajouter la photo du site</span><img src="{{URL::asset('css/img/ICONE_PLUS.png') }}" style="float:right;">
                    </label>
                </td>
                <td style="border-collapse:initial"> * </td>
            </table>
            <small class="error-msg">{{ $errors->first('photo_site', ':message') }}</small>
        </div>
        <br><br>

        <!-- EDITEUR D'INTRODUCTION -->
        <div class="row" style="margin:0;">
            <h1 class="etapes-titre">Etape 04 / Ajouter la 'Vidéo Sommaire'</h1>
            <table class="admin-table-input-group">
                <td class="td-label">Vid&eacute;o</td>
                <td class="td-input {{ $errors->has('video_sommaire') ? 'has-error' : '' }}">
                    <label class="custom-file-upload">
                        {{ Form::file('video_sommaire', ['accept' => '.mp4', 'class' => 'input-file']) }}
                        <span>Cliquez ici pour ajouter la video sommaire</span><img src="{{URL::asset('css/img/ICONE_PLUS.png') }}" style="float:right;">
                    </label>
                </td><td style="border-collapse:initial"> * </td>
            </table>
            <small class="error-msg">{{ $errors->first('video_sommaire', ':message') }}</small>
        </div>
        <!-- FIN D'EDITEUR D'INTRODUCTION -->

        <!-- CHOIX DES ATELIERS -->
        <br><br>
        
        <div class="row" style="margin:0;">
            <h1 class="etapes-titre">Etape 05 / Ajouter la 'Carte'</h1>
            <br>
            <h3 class="etapes-soustitre">Choisissez le type de carte</h3>
            <div id='radio-carte-set'>
                {{ Form::radio('type-carte', 'fixe', true, ['class' => 'radio-carte', 'id' => 'radio-carte-fixe']) }}
                {{ Form::label('radio-carte-fixe', 'fixe', []) }}
                {{ Form::radio('type-carte', 'dynamic', false, ['class' => 'radio-carte', 'id' => 'radio-carte-dynamic']) }}
                {{ Form::label('radio-carte-dynamic', 'dynamique', []) }}
            </div>
            <br>
            <div id='carte-fixe-content' style="display: {{old('type-carte') ? (old('type-carte') === 'fixe' ? 'block' : 'none') : 'block'}};">
                <div class="row" style="margin: 0">
                    <h3 class="etapes-soustitre">Etape 05-A / Ajouter le fichier image de la 'Carte'</h3>
                    <table class="admin-table-input-group">
                        <td class="td-label">Carte</td>
                        <td class="td-input {{ $errors->has('carte_sommaire') ? 'has-error' : ''}}">
                            <label class="custom-file-upload">
                                {{ Form::file('carte_sommaire', ['accept' => '.png, .jpg', 'class' => 'input-file']) }}
                                <span>Cliquez ici pour ajouter la carte</span><img src="{{URL::asset('css/img/ICONE_PLUS.png') }}" style="float:right;">
                            </label>
                        </td>
                        <td style="border-collapse:initial"> * </td>
                    </table>
                    <small class="error-msg">{{ $errors->first('carte_sommaire', ':message') }}</small>
                    <br><br>
                    <h3 class="etapes-soustitre">Etape 05-B / Ajouter le 'Sentier'</h3>
                    <table class="admin-table-input-group">
                        <td class="td-label">Sentier</td>
                        <td class="td-input {{ $errors->has('sentier_sommaire') ? 'has-error' : '' }}">
                            <label class="custom-file-upload">
                                {{ Form::file('sentier_sommaire', ['accept' => '.png, .jpg', 'class' => 'input-file']) }}
                                <span>Cliquez ici pour ajouter la carte</span><img src="{{URL::asset('css/img/ICONE_PLUS.png') }}" style="float:right;">
                            </label>
                        </td>
                        <td style="border-collapse:initial"> * </td>
                    </table>
                    <small class="error-msg">{{ $errors->first('sentier_sommaire', ':message') }}</small>
                </div>                
            </div>
            <div id='carte-interactive-content' style="display: {{old('type-carte') ? (old('type-carte') === 'dynamic' ? 'block' : 'none') : 'none'}};">
                <div class="row" style="margin: 0;">
                    <h3 class="etapes-soustitre">D&eacute;finissez les limites de la 'Carte'</h3>
                    <table class="admin-table-input-group">
                        <tr>
                            <td class="td-label">Latitude minimum</td>
                            <td class="td-input {{ $errors->has('map-latmin') ? 'has-error' : '' }}">
                                {{ Form::input('number', 'map-latmin', null, ['id' => 'site-map-latmin', 'step' => '0.00001', 'class' => 'input-number', 'lang' => 'en', 'min' => '-90.0', 'max' => '90.0', 'placeholder' => '0.00000']) }} 
                            </td>
                            <td style="border-collapse: initial;"> * </td>
                        </tr>
                        <tr>
                            <td class="td-label">Latitude maximum</td>
                            <td class="td-input {{ $errors->has('map-latmax') ? 'has-error' : '' }}">
                                {{ Form::input('number', 'map-latmax', null, ['id' => 'site-map-latmax', 'step' => '0.00001', 'class' => 'input-number', 'lang' => 'en', 'min' => '-90.0', 'max' => '90.0', 'placeholder' => '0.00000']) }} 
                            </td>
                            <td style="border-collapse: initial;"> * </td>
                        </tr>
                        <tr>
                            <td class="td-label">Longitude minimum</td>
                            <td class="td-input {{ $errors->has('map-lonmin') ? 'has-error' : '' }}">
                                {{ Form::input('number', 'map-lonmin', null, ['id' => 'site-map-lonmin', 'step' => '0.00001', 'class' => 'input-number', 'lang' => 'en', 'min' => '-180.0', 'max' => '180.0', 'placeholder' => '0.00000']) }}
                            </td>
                            <td style="border-collapse: initial;"> * </td>
                        </tr>
                        <tr>
                            <td class="td-label">Longitude maximum</td>
                            <td class="td-input {{ $errors->has('map-lonmax') ? 'has-error' : '' }}">
                                {{ Form::input('number', 'map-lonmax', null, ['id' => 'site-map-lonmax', 'step' => '0.00001', 'class' => 'input-number', 'lang' => 'en', 'min' => '-180.0', 'max' => '180.0', 'placeholder' => '0.00000']) }} 
                            </td>
                            <td style="border-collapse: initial;"> * </td>
                        </tr>
                    </table>
                    <small class="error-msg">{!! $errors->first('map-latmin', ':message<br>') !!}</small>
                    <small class="error-msg">{!! $errors->first('map-latmax', ':message<br>') !!}</small>
                    <small class="error-msg">{!! $errors->first('map-lonmin', ':message<br>') !!}</small>
                    <small class="error-msg">{!! $errors->first('map-lonmax', ':message<br>') !!}</small>
                    <span id="site-popup-map-link">@include('svg.mapIcon', ['id' => 'mapIcon', 'width' => 30, 'height' => 30]) Dessiner une région sur la carte</span>
                    <div id='site-popup-map'></div>
                </div>
            </div>
        </div>
        <br><br>

        <div class="row" style="margin: 0;">
            <h1 class="etapes-titre">Etape 06 / Ajouter des sons d'ambiance</h1>
            {{ Form::hidden('number-sounds', 0, ['id' => 'number-sounds']) }}
            <br>            
            <br>
            <div id="sound-selector-container">
                <table class="admin-table-input-group audio-0">
                    <td class="td-label">Audio</td>
                    <?php
                    $audioError = '';
                    foreach ($errors->getMessages() as $key => $error) {
                        if (preg_match('/audio-files\.\d+$/', (string) $key)) {
                            $audioError = $key;
                        }
                    }
                    ?>
                    <td class="td-input {{ $errors->has($audioError) ? 'has-error' : '' }}">
                        <label class="custom-file-upload">
                            {{ Form::file('audio-files[0]', ['accept' => '.mp3', 'class' => 'input-file']) }}
                            <span>Cliquez ici pour ajouter un fichier audio</span><img src="{{URL::asset('css/img/ICONE_PLUS.png') }}" style="float:right;">
                        </label>
                    </td>
                    <td style="border-collapse:initial"> *&nbsp;<a href="#sound" class="audio-delete audio-0"><img src='../../img/corbeille2.png'></a></td>                
                </table>
                <small class="error-msg">{{ $errors->first($audioError, ':message') }}</small>
                <div class="audio-slider slider-0 audio-0"></div>
                {{ Form::hidden('audio-out-min[0]', '', ['class' => 'audio-out-min audio-0']) }}
                {{ Form::hidden('audio-in-min[0]', '', ['class' => 'audio-in-min audio-0']) }}
                {{ Form::hidden('audio-in-max[0]', '', ['class' => 'audio-in-max audio-0']) }}
                {{ Form::hidden('audio-out-max[0]', '', ['class' => 'audio-out-max audio-0']) }}
                <a href="#sound" name="sound" class="add-sound-link" onclick="addNewSound();">Cliquez-ici pour ajouter un autre son d&apos;ambiance</a>
            </div>
        </div>

        <div class="bloc-boutons-submits">
            <input type="submit" name="continuer" class="submit action-button" value="CONTINUER" />
        </div>
    </fieldset>

    <!-- FIN DE PUBLICATION -->
    {{ Form::close() }}
</div>

<!-- FIN SITES -->




@endsection