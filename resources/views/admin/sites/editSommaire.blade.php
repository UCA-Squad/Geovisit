<?php
/*
 * 
 * 
 * Observatoire de Physique du Globe de Clermont-Ferrand
 * Campus Universitaire des Cezeaux
 * 4 Avenue Blaise Pascal
 * TSA 60026 - CS 60026
 * 63178 AUBIERE CEDEX FRANCE
 * 
 * Author: Yannick Guehenneux
 *         y.guehenneux [at] opgc.fr
 * 
 */
?>

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
{{ Html::script(asset('js/bootstrap/bootstrap-confirmation.min.js')) }}
@endsection

@section('content')
@include('admin.nav-site')
<!-- multistep form -->

<div class="row general" style="padding:0; margin:0;">

    {{ Form::open(array('route'=>['admin::site::summary::update', 'id_site' => $site->id], 'method'=>'POST', 'id'=>'sitenumform', 'files' => true)) }}

    <!-- fieldsets -->
    <fieldset id="fieldsiteintro">
        <div class="row" style="margin:0;">
            <h1 class="etapes-titre">Etape 01 / Modifier le Nom du site</h1>
            <table class="admin-table-input-group">
                <td class="td-label">Site</td>
                <td class="td-input {{ $errors->has('nom_site') ? 'has-error' : '' }}">
                    {{ Form::text('nom_site', (!is_null(old('nom_site')) ? old('nom_site') : $site->titre), ['placeholder' => 'Saisir le nom du site', 'class' => 'table-admin-inputtext']) }}
                </td>
                <td style="border-collapse:initial; "> * </td>
            </table>
            <small class="error-msg">{{ $errors->first('nom_site', ':message') }}</small>            
        </div>
        <br><br>

        <div class="row" style="margin: 0;">
            <h1 class="etapes-titre">Etape 02 / Modifier la 'Photo du Site'</h1>
            <table class="admin-table-input-group">
                <td class="td-label">Photo</td>
                <td class="td-input {{ $errors->has('photo_site') ? 'has-error' : '' }}">
                    <label class="custom-file-upload">
                        {{ Form::file('photo_site', ['accept' => '.png, .jpg', 'class' => 'input-file']) }}
                        <span>{{ $site->photo }}</span><img src="{{URL::asset('css/img/ICONE_PLUS.png') }}" style="float:right;">
                    </label>
                </td>
                <td style="border-collapse:initial"> * </td>
            </table>
            <small class="error-msg">{{ $errors->first('photo_site', ':message') }}</small>
            <a href="{{ URL::asset($site->photo) }}" target="_blank">voir l&apos;image actuellement utilis&eacute;e</a>
        </div>
        <br><br>

        <!-- EDITEUR D'INTRODUCTION -->
        <div class="row" style="margin:0;">
            <h1 class="etapes-titre">Etape 03 / Modifier la 'Vidéo Sommaire'</h1>
            <table class="admin-table-input-group">
                <td class="td-label">Vid&eacute;o</td>
                <td class="td-input {{ $errors->has('video_sommaire') ? 'has-error' : '' }}">
                    <label class="custom-file-upload">
                        {{ Form::file('video_sommaire', ['accept' => '.mp4', 'class' => 'input-file']) }}
                        <span>{{ $site->video }}</span><img src="{{URL::asset('css/img/ICONE_PLUS.png') }}" style="float:right;">
                    </label>
                </td><td style="border-collapse:initial"> * </td>
            </table>
            <small class="error-msg">{{ $errors->first('video_sommaire', ':message') }}</small>
            <a href="{{ URL::asset($site->video) }}" target='_blank'>voir la vid&eacute;o actuellement utilis&eacute;e</a>
        </div>
        <!-- FIN D'EDITEUR D'INTRODUCTION -->

        <!-- CHOIX DES ATELIERS -->
        <br><br>

        <div class="row" style="margin:0;">
            <h1 class="etapes-titre">Etape 04 / Modifier la 'Carte'</h1>
            <br>
            <h3 class="etapes-soustitre">Choisissez le type de carte</h3>
            <div id='radio-carte-set'>
                {{ Form::radio('type-carte', 'fixe', !is_null(old('type_carte')) ? (old('type_carte') === 'fixe' ? true : false) : (!$site->sig_map ? true :  false), ['class' => 'radio-carte', 'id' => 'radio-carte-fixe']) }}
                {{ Form::label('radio-carte-fixe', 'fixe', []) }}
                {{ Form::radio('type-carte', 'dynamic', !is_null(old('type_carte')) ? (old('type_carte') === 'fixe' ? false : true) : (!$site->sig_map ? false :  true), ['class' => 'radio-carte', 'id' => 'radio-carte-dynamic']) }}
                {{ Form::label('radio-carte-dynamic', 'dynamique', []) }}
            </div>
            <br>
            <div id='carte-fixe-content' style="display: {{!is_null(old('type_carte')) ? (old('type_carte') === 'fixe' ? 'block' : 'none') : (!$site->sig_map ? 'block' :  'none')}};">
                <div class="row" style="margin: 0">
                    <h3 class="etapes-soustitre">Etape 04-A / Modifier le fichier image de la 'Carte'</h3>
                    <table class="admin-table-input-group">
                        <td class="td-label">Carte</td>
                        <td class="td-input {{ $errors->has('carte_sommaire') ? 'has-error' : ''}}">
                            <label class="custom-file-upload">
                                {{ Form::file('carte_sommaire', ['accept' => '.png, .jpg', 'class' => 'input-file']) }}
                                <span>{{ $site->img_mini_map }}</span><img src="{{URL::asset('css/img/ICONE_PLUS.png') }}" style="float:right;">
                            </label>
                        </td>
                        <td style="border-collapse:initial"> * </td>
                    </table>
                    <small class="error-msg">{{ $errors->first('carte_sommaire', ':message') }}</small>
                    <a href="{{ URL::asset($site->img_mini_map) }}" target='_blank'>voir l&apos;image actuellement utilis&eacute;e</a>
                    <br><br>
                    <h3 class="etapes-soustitre">Etape 04-B / Modifier le 'Sentier'</h3>
                    <table class="admin-table-input-group">
                        <td class="td-label">Sentier</td>
                        <td class="td-input {{ $errors->has('sentier_sommaire') ? 'has-error' : '' }}">
                            <label class="custom-file-upload">
                                {{ Form::file('sentier_sommaire', ['accept' => '.png, .jpg', 'class' => 'input-file']) }}
                                <span>{{ $site->img_sentier }}</span><img src="{{URL::asset('css/img/ICONE_PLUS.png') }}" style="float:right;">
                            </label>
                        </td>
                        <td style="border-collapse:initial"> * </td>
                    </table>
                    <small class="error-msg">{{ $errors->first('sentier_sommaire', ':message') }}</small>
                    <a href="{{ URL::asset($site->img_sentier) }}" target='_blank'>voir l&apos;image actuellement utilis&eacute;e</a>
                </div>                
            </div>
            <div id='carte-interactive-content' style="display: {{!is_null(old('type_carte')) ? (old('type_carte') === 'fixe' ? 'none' : 'block') : (!$site->sig_map ? 'none' :  'block')}};">
                <div class="row" style="margin: 0;">
                    <h3 class="etapes-soustitre">D&eacute;finissez les limites de la 'Carte'</h3>
                    <table class="admin-table-input-group">
                        <tr>
                            <td class="td-label">Latitude minimum</td>
                            <td class="td-input {{ $errors->has('map-latmin') ? 'has-error' : '' }}">
                                {{ Form::input('number', 'map-latmin', !is_null(old('map-latmin')) ? old('map-latmin') : ($site->sig_map ? $site->latmin : null), ['id' => 'site-map-latmin', 'step' => '0.00001', 'class' => 'input-number', 'lang' => 'en', 'min' => '-90.0', 'max' => '90.0', 'placeholder' => '0.00000']) }} 
                            </td>
                            <td style="border-collapse: initial;"> * </td>
                        </tr>
                        <tr>
                            <td class="td-label">Latitude maximum</td>
                            <td class="td-input {{ $errors->has('map-latmax') ? 'has-error' : '' }}">
                                {{ Form::input('number', 'map-latmax', !is_null(old('map-latmax')) ? old('map-latmax') : ($site->sig_map ? $site->latmax : null), ['id' => 'site-map-latmax', 'step' => '0.00001', 'class' => 'input-number', 'lang' => 'en', 'min' => '-90.0', 'max' => '90.0', 'placeholder' => '0.00000']) }} 
                            </td>
                            <td style="border-collapse: initial;"> * </td>
                        </tr>
                        <tr>
                            <td class="td-label">Longitude minimum</td>
                            <td class="td-input {{ $errors->has('map-lonmin') ? 'has-error' : '' }}">
                                {{ Form::input('number', 'map-lonmin', !is_null(old('map-lonmin')) ? old('map-lonmax') : ($site->sig_map ? $site->lonmin : null), ['id' => 'site-map-lonmin', 'step' => '0.00001', 'class' => 'input-number', 'lang' => 'en', 'min' => '-180.0', 'max' => '180.0', 'placeholder' => '0.00000']) }}
                            </td>
                            <td style="border-collapse: initial;"> * </td>
                        </tr>
                        <tr>
                            <td class="td-label">Longitude maximum</td>
                            <td class="td-input {{ $errors->has('map-lonmax') ? 'has-error' : '' }}">
                                {{ Form::input('number', 'map-lonmax', !is_null(old('map-lonmax')) ? old('map-lonmax') : ($site->sig_map ? $site->lonmax : null), ['id' => 'site-map-lonmax', 'step' => '0.00001', 'class' => 'input-number', 'lang' => 'en', 'min' => '-180.0', 'max' => '180.0', 'placeholder' => '0.00000']) }} 
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
            <h1 class="etapes-titre">Etape 05 / Modifier des sons d'ambiance</h1>
            {{ Form::hidden('number-sounds', count(json_decode($site->sound, TRUE)) - 1, ['id' => 'number-sounds']) }}
            <br>            
            <br>
            <div id="sound-selector-container">
                @foreach (json_decode($site->sound, TRUE) as $key => $snd)
                <table class="admin-table-input-group audio-{{$key}}">
                    <td class="td-label">Audio</td>
                    <?php
                    $audioError = '';
                    foreach ($errors->getMessages() as $k => $error) {
                        if (preg_match('/audio-files\.\d+$/', (string) $k)) {
                            $audioError = $k;
                        }
                    }
                    ?>
                    <td class="td-input {{ $errors->has($audioError) ? 'has-error' : '' }}">
                        <label class="custom-file-upload">
                            {{ Form::file('old-audio-files-' . $key, ['accept' => '.mp3', 'class' => 'input-file']) }}
                            <span>{{ $snd["sound"][0] }}</span><img src="{{URL::asset('css/img/ICONE_PLUS.png') }}" style="float:right;">
                        </label>
                    </td>
                    <td style="border-collapse:initial"> *&nbsp;
                        <img src="{{ URL::asset('img/corbeille2.png') }}" style="cursor: pointer;" 
                             data-toggle="confirmation" data-btn-ok-label="Oui" data-btn-cancel-label="Non!"
                             title="voulez-vous supprimer ce son ? ATTENTION: cela entraine la perte de toute autre modification en cours"
                             data-href="{{ route('admin::site::summary::delete::sound', ['id_site' => $site->id, 'id_sound' => $key]) }}"
                             />
                    </td>                
                </table>
                <a href="{{ URL::asset($snd['sound'][0]) }}" target="_blank">&Eacute;couter le son utilis&eacute;</a>
                <small class="error-msg">{{ $errors->first($audioError, ':message') }}</small>                
                <div class="audio-slider slider-{{ $key }} audio-{{ $key }}"></div>
                {{ Form::hidden('old-audio-out-min-' . $key, $snd['range'][0], ['class' => 'audio-out-min audio-'. $key]) }}
                {{ Form::hidden('old-audio-in-min-' . $key, $snd['range'][1], ['class' => 'audio-in-min audio-' . $key]) }}
                {{ Form::hidden('old-audio-in-max-' .$key, $snd['range'][2], ['class' => 'audio-in-max audio-' . $key]) }}
                {{ Form::hidden('old-audio-out-max-' . $key, $snd['range'][3], ['class' => 'audio-out-max audio-' . $key]) }}

                <script>createSlider({{ $key }}, {{ json_encode($snd['range']) }});</script>                
                @endforeach
                <a href="#sound" name="sound" class="add-sound-link" onclick="addNewSound();">Cliquez-ici pour ajouter un autre son d&apos;ambiance</a>
            </div>
        </div>

        <div class="bloc-boutons-submits">
            <input type="submit" name="continuer" class="submit action-button" value="MODIFIER" />
        </div>
    </fieldset>

    {{ Form::close() }}
    {{ Form::open(['method' => 'post', 'id' => 'delete', 'style' => 'display: none;']) }}
    {{ Form::hidden('_method', 'DELETE') }}
    {{ Form::close() }}    

    <!-- Modal -->
    @if ($alert)
    <script>
        $(document).ready(function () {
            $('#myModal').modal();
        });
    </script>   
    @endif
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            onclick="javascript:window.location = '{{ route('admin::site::summary::edit', $site->id) }}'">
                        <span aria-hidden="true">&times;</span>
                    </button>   
                    <h1 class="etapes-titre">MODIFICATION DE LA VIDEO SOMMAIRE</h1>
                </div>
                <div class="modal-body">
                    La vidéo sommaire du site {{ $site->titre }} vient d&apos;&ecirc;tre modifi&eacute;e. Vous devriez v&eacute;rifier que les diff&eacute;rents ateliers sont encore valides.
                    <br>
                    <div class="row" align="center" style="margin-top: 40px;">
                        <a href="{{ route('admin::site::atelier::index', $site->id) }}" class="liens_gerer action-button">VERIFIER/MODIFIER ATELIER(S)</a>  
                    </div>
                </div>
                <div class="modal-footer" align="center">                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FIN SITES -->

@endsection

@section('scripts')
<script>
    $(document).ready(function() {        
        $('[data-toggle=confirmation]').confirmation({
            onConfirm: function() {
                $.ajax({
                    method: 'post',
                    url: $(this).attr('data-href'),
                    data: $('#delete').serialize(),
                    dataType: 'json'
                }).done(function(data) {
                    $(location).attr('href', "{{ route('admin::site::summary::edit', $site->id) }}");
                }).fail(function(data) {
                    $(location).attr('href', "{{ route('admin::site::summary::edit', $site->id) }}");
                });
            }
        });
    });
</script>
@endsection