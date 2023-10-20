<?php
/*
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
{{ Html::style(asset('css/admin/video-player.css')) }}
{{ Html::style(asset('css/leaflet/leaflet.css')) }}
{{ Html::style(asset('css/leaflet/leaflet.draw.css')) }}
<style>
    .control div.btnPlay {
        background: url({{ asset('/img/control.png') }}) no-repeat 0 0;
    }

    .control div.paused {
        background: url({{ asset('/img/control.png') }}) no-repeat 0 -30px;
    }

    .control div.btnStop {
        background: url({{ asset('/img/control.png') }}) no-repeat 0 -60px;
    }

</style>

{{ Html::script(asset('js/leaflet/leaflet.js')) }}
{{ Html::script(asset('js/leaflet/leaflet.draw.js')) }}
{{ Html::script(asset('js/admin/site.js')) }}
{{ Html::script(asset('js/admin/map.js')) }}
{{ Html::script(asset('js/admin/video-player.js')) }}
@endsection

@section('content')

@include('admin.nav-site')

@if (Session::get('sitessrub') === 'nouveau')
<!-- progressbar -->
<ul id="progressbar_sites">
    <li>Sommaire</li>
    <li class="active">Ateliers</li>
    <li>Visualisation</li>
</ul>
@endif


<div class="fields">

    <div id='forms' class="double_col row">
        <div class="col-lg-10">
            <h1 class="etapes-titre">CHOISIR UN ATELIER</h1>
            {{ Form::open(array('route' => ['admin::site::atelier::select', $site->id], 'method' => 'post')) }}
            <table class="admin-table-input-group">
                <td class="td-label">ATELIER</td>
                <td class="td-input {{ $errors->has('atelier-selected') ? 'has-error' : '' }}">
                    {{ Form::select('atelier-selected', $selectAteliers, is_null($atelier) ? 'new' : $atelier->id, ['id' => 'select-atelier']) }}
                </td>
                <td style="border-collapse: initial;"> * </td>
            </table>    
            <small class="error-msg">{{ $errors->first('atelier-selected', ':message') }}</small>
            {{ Form::close() }}
            <br><br>


            @if (is_null($atelier))
            {{ Form::open(array('route' => ['admin::site::atelier::new', $site->id], 'method' => 'post', 'files' => true)) }}
            @else
            {{ Form::open(array('route' => ['admin::site::atelier::update', $site->id, $atelier->id], 'method' => 'post', 'files' => true)) }}
            {{ Form::hidden('atelier_id', $atelier->id) }}
            @endif

            {{ Form::hidden('site_id', $site->id) }}
            <h3 class="etapes-soustitre">POSITION TEMPORELLE DANS LE SOMMAIRE</h3>
            <table class="admin-table-input-group">
                <td class="td-label">SECONDES</td>
                <td class="td-input {{ $errors->has('timestamp') ? 'has-error' : '' }}">
                    {{ Form::input('number', 'timestamp', is_null($atelier) ? '' : $atelier->timeline, ['class' => 'input-number', 'lang' => 'en', 'step' => 'any', 'min' => '0', 'id' => 'atelier-timestamp']) }}
                </td>
                <td style="border-collapse: initial;"> * </td>
            </table>
            <small class="error-msg">{{ $errors->first('timestamp', ':message') }}</small>
            <span class='video-popup-link popup-link'>@include('svg.videoIcon', ['width' => 30, 'height' => 30]) Remplir les champs en cliquant sur la vid&eacute;o</span>
            <br><br>
            <h3 class="etapes-soustitre">POSITION SPATIALE DANS LE SOMMAIRE</h3>
            <div class="double_col row">
                <div class="col-lg-6">
                    <table class="admin-table-input-group">
                        <td class="td-label">X</td>
                        <td class="td-input {{ $errors->has('x_sommaire') ? 'has-error' : '' }}">
                            {{ Form::input('number', 'x_sommaire', is_null($atelier) ? '' : $atelier->x_sommaire, ['class' => 'input-number', 'lang' => 'en', 'step' => 'any', 'min' => '0', 'max' => '100', 'id' => 'atelier-x-video']) }}
                        </td>
                        <td style="border-collapse: initial;"> * </td>
                    </table>
                    <small class="error-msg">{{ $errors->first('x_sommaire', ':message') }}</small>
                </div>
                <div class="col-lg-6">
                    <table class="admin-table-input-group">
                        <td class="td-label">Y</td>
                        <td class="td-input {{ $errors->has('y_sommaire') ? 'has-error' : '' }}">
                            {{ Form::input('number', 'y_sommaire', is_null($atelier) ? '' : $atelier->y_sommaire, ['class' => 'input-number', 'lang' => 'en', 'step' => 'any', 'min' => '0', 'max' => '100', 'id' => 'atelier-y-video']) }}
                        </td>
                        <td style="border-collapse: initial;"> * </td>
                    </table>
                    <small class="error-msg">{{ $errors->first('y_sommaire', ':message') }}</small>
                </div>
            </div>
            <span class='video-popup-link popup-link'>@include('svg.videoIcon', ['width' => 30, 'height' => 30]) Remplir les champs en cliquant sur la vid&eacute;o</span>
            <br><br>
            <h3 class="etapes-soustitre">POSITION SUR LA CARTE</h3>
            {{ Form::hidden('sig_map', $site->sig_map, ['id' => 'sig_map']) }}
            @if ($site->sig_map)
            {{ Form::hidden('map_latmin', $site->latmin, ['id' => 'map_latmin']) }}
            {{ Form::hidden('map_latmax', $site->latmax, ['id' => 'map_latmax']) }}
            {{ Form::hidden('map_lonmin', $site->lonmin, ['id' => 'map_lonmin']) }}
            {{ Form::hidden('map_lonmax', $site->lonmax, ['id' => 'map_lonmax']) }}
            @endif
            <div class="double_col row">
                <div class="col-lg-6">
                    <table class="admin-table-input-group">
                        @if (!$site->sig_map)
                        <td class="td-label">X</td>
                        <td class="td-input {{ $errors->has('x_carte') ? 'has-error' : '' }}">
                            {{ Form::input('number', 'x_carte', is_null($atelier) ? '' : $atelier->x_carte, ['class' => 'input-number', 'lang' => 'en', 'step' => 'any', 'min' => '0', 'id' => 'atelier-x-carte']) }}
                        </td>
                        @else
                        <td class="td-label">Longitude</td>
                        <td class="td-input {{ $errors->has('x_carte') ? 'has-error' : '' }}">
                            {{ Form::input('number', 'x_carte', is_null($atelier) ? '' : $atelier->x_carte, ['id' => 'x_carte', 'class' => 'input-number', 'lang' => 'en', 'step' => 'any', 'min' => '-180.0', 'max' => '180.0']) }}
                        </td>
                        @endif
                        <td style="border-collapse: initial;"> * </td>
                    </table>
                    <small class="error-msg">{{ $errors->first('x_carte', ':message') }}</small>            
                </div>
                <div class="col-lg-6">
                    <table class="admin-table-input-group">
                        @if (!$site->sig_map)
                        <td class="td-label">Y</td>
                        <td class="td-input {{ $errors->has('y_carte') ? 'has-error' : '' }}">
                            {{ Form::input('number', 'y_carte', is_null($atelier) ? '' : $atelier->y_carte, ['class' => 'input-number', 'lang' => 'en', 'step' => 'any', 'min' => '0', 'id' => 'atelier-y-carte']) }}
                        </td>
                        @else
                        <td class="td-label">Latitude</td>
                        <td class="td-input {{ $errors->has('y_carte') ? 'has-error' : '' }}">
                            {{ Form::input('number', 'y_carte', is_null($atelier) ? '' : $atelier->y_carte, ['id' => 'y_carte', 'class' => 'input-number', 'lang' => 'en', 'step' => 'any', 'min' => '-90.0', 'max' => '90.0']) }}
                        </td>
                        @endif
                        <td style="border-collapse: initial;"> * </td>
                    </table>
                    <small class="error-msg">{{ $errors->first('y_carte', ':message') }}</small>
                </div>        
            </div>
            <span class="carte-popup-link popup-link">@include('svg.mapIcon', ['id' => 'mapIcon', 'width' => 30, 'height' => 30]) Remplir les champs en cliquant sur la carte</span>
            <br><br>
            <h3 class="etapes-soustitre">VIGNETTE SUR LE SOMMAIRE</h3>
            <table class="admin-table-input-group">
                <td class="td-label">Vignette</td>
                <td class="td-input {{ $errors->has('image') ? 'has-error' : '' }}">
                    <label class="custom-file-upload">
                        {{ Form::file('image', ['accept' => '.png, .jpg', 'class' => 'input-file']) }}
                        <span>Cliquez ici pour ajouter la photo de l'atelier</span><img src="{{URL::asset('css/img/ICONE_PLUS.png') }}" style="float:right;">
                    </label>
                </td>
                <td style="border-collapse: initial;"> * </td>
            </table>
            <small class="error-msg">{{ $errors->first('image', ':message') }}</small>
            @if (!is_null($atelier))
            <a href="{{ URL::asset($atelier->image) }}" target="_blank">voir l'image actuellement utilisée</a>
            @endif
            <br><br>
            <table class="admin-table-input-group">
                <td class="td-label">Rayon</td>
                <td class="td-input {{ $errors->has('rayon') ? 'has-error' : '' }}">
                    {{ Form::input('number', 'rayon', is_null($atelier) ? 40 : $atelier->rayon, ['class' => 'input-number', 'lang' => 'en', 'step' => 'any', 'min' => '1']) }}
                </td>
                <td style="border-collapse: initial;"> * </td>
            </table>
            <small class="error-msg">{{ $errors->first('rayon', ':message') }}</small>
            <br><br>
            <h3 class="etapes-soustitre">AMBIANCE SONORE</h3>
            <table class="admin-table-input-group">
                <td class="td-label">Audio</td>
                <td class="td-input {{ $errors->has('audio') ? 'has-error' : '' }}">
                    <label class="custom-file-upload">
                        {{ Form::file('audio', ['accept' => '.mp3', 'class' => 'input-file']) }}
                        <span>Cliquez ici pour ajouter le fichier son de l'atelier</span><img src="{{URL::asset('css/img/ICONE_PLUS.png') }}" style="float:right;">
                    </label>
                </td>
                <td style="border-collapse: initial;"> * </td>
            </table>
            <small class="error-msg">{{ $errors->first('audio', ':message') }}</small>
            @if (!is_null($atelier))
            <a href="{{ URL::asset($atelier->audio) }}" target="_blank">écouter le son actuellement utilisé</a>
            @endif
            <br><br>
            <h3 class="etapes-soustitre">IMAGE EQUIRECTANGULAIRE DU 360</h3>
            <table class="admin-table-input-group">
                <td class="td-label">Fichier jpg</td>
                <td class="td-input {{ $errors->has('lien_360') ? 'has-error' : '' }}">
                    <label class="custom-file-upload">
                        {{ Form::file('lien_360', ['accept' => '.jpg', 'class' => 'input-file']) }}
                        <span>Cliquez ici pour ajouter le fichier jpg du 360 deplié de l'atelier</span><img src="{{URL::asset('css/img/ICONE_PLUS.png') }}" style="float:right;">
                    </label>
                </td>
                <td style="border-collapse: initial;"> * </td>
            </table>
            <small class="error-msg">{{ $errors->first('lien_360', ':message') }}</small>
            <span class="comz">Veuillez utiliser une image de haute r&eacute;solution</span><br>
            @if (!is_null($atelier))
            <a href="{{ URL::asset(is_null($atelier) ? '' : $atelier->image_deplie) }}" target="_blank">voir le 360 actuellement utilisé</a>
            @endif
            <br><br>
            <h3 class="etapes-soustitre">ANGLE DE VUE HORIZONTAL</h3>
            <div class="pannellum-slider slider-haov"></div>            
            <table class="admin-table-input-group">
                <td class="td-label">haov</td>
                <td class="td-input {{$errors->has('haov') ? 'has-error' : ''}}">
                    {{ Form::input('number', 'haov', is_null($atelier) ? 360 : $atelier->haov, ['class' => 'input-number', 'lang' => 'en', 'step' => '0.001', 'min' => '0', 'max' => '360', 'id' => 'haov-input']) }} 
                </td>
                <td style="border-collapse: initial;"> * </td>
            </table>
            <small class="error-msg">{{ $errors->first('haov', ':message') }}</small>
            <span class='comz'>param&egrave;tre &agrave; ne modifier que si le 360 est incomplet horizontalement</span>
            <br><br>
            <h3 class="etapes-soustitre">ANGLE DE VUE VERTICAL</h3>
            <div class="pannellum-slider slider-vaov"></div>
            <table class="admin-table-input-group">
                <td class="td-label">vaov</td>
                <td class="td-input {{$errors->has('vaov') ? 'has-error' : ''}}">
                    {{ Form::input('number', 'vaov', is_null($atelier) ? 180 : $atelier->vaov, ['class' => 'input-number', 'lang' => 'en', 'step' => '0.001', 'min' => '0', 'max' => '180', 'id' => 'vaov-input']) }} 
                </td>
                <td style="border-collapse: initial;"> * </td>
            </table>
            <small class="error-msg">{{ $errors->first('vaov', ':message') }}</small>
            <span class="comz">param&egrave;tre &agrave; ne modifier que si le 360 est incomplet verticalement</span>
            <br><br>
            <h3 class="etapes-soustitre">DECALAGE VERTICAL INITIAL</h3>
            <div class="pannellum-slider slider-voffset"></div>
            <table class="admin-table-input-group">
                <td class="td-label">voffset</td>
                <td class="td-input {{$errors->has('voffset') ? 'has-error' : ''}}">
                    {{ Form::input('number', 'voffset', is_null($atelier) ? 0 : $atelier->vOffset, ['class' => 'input-number', 'lang' => 'en', 'step' => '0.001', 'min' => '-90', 'max' => '90', 'id' => 'voffset-input']) }} 
                </td>
                <td style="border-collapse: initial;"> * </td>
            </table>
            <small class="error-msg">{{ $errors->first('voffset', ':message') }}</small>
            <span class="comz">param&egrave;tre &agrave; ne modifier que si le 360 est incomplet verticalement ou si la ligne d'horizon apparait d&eacute;form&eacute;e</span>     
            <br><br>
            {{ Form::submit(is_null($atelier) ? 'CREER UN ATELIER' : 'MODIFIER L\'ATELIER', ['class' => 'liens_gerer action-button', 'value' => 'modifer', 'name' => 'valider']) }}
            {{ Form::submit(is_null($atelier) ? 'CREER UN ATELIER ET VISUALISER LE 360' : 'MODIFIER L\'ATELIER ET VISUALISER LE 360', ['class' => 'liens_gerer action-button-large', 'value' => 'modifier_voir', 'name' => 'valider_voir']) }}
            {{ Form::close() }}
        </div>
        @if (!is_null($atelier))
        {{ Form::open(['route' => ['admin::site::atelier::delete', $site->id, $atelier->id], 'method' => 'delete', 'onsubmit' => 'return confirm("Confirmer la suppression ?")', 'class' => 'col-sm-1', 'style' => 'margin-top: 20px;']) }}
        {{ Form::submit('SUPPRIMER L\'ATELIER', ['class' => 'liens_gerer action-button', 'value' => 'supprimer', 'name' => 'valider']) }}
        {{ Form::close() }}
        @endif
    </div>

    <div id='atelier-popup-video'>
        @include('video_player')
    </div>
    <div id='atlier-popup-carte' class="{{ $site->sig_map ? 'interactive' : 'fixe' }}">
        @if (!$site->sig_map)
        <div style="position: relative">
            <img id='carte-img' src='{{ asset($site->img_mini_map) }}' autofocus>
            <img id='point-carte' src="{{ asset('img/point-selected.png') }}" style="position: absolute;
                 top: {{ is_null($atelier) ? 0 : $atelier->y_carte }}%;left: {{ is_null($atelier) ? 0 : $atelier->x_carte }}%;
                 transform: translate(-50%, -50%);{{ is_null($atelier) ? 'display: none;' : '' }}">
        </div>
        @else
        <div id="map-atelier" style='width: 100%; height: 100%;'></div>
        @endif
    </div>
</div>
<a href="{{ route('admin::site::visu', $site->id) }}" class='submit-link'>PASSER A LA VISUALISATION DU SITE</a>

@endsection