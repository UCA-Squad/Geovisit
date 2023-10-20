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
{{ Html::style(asset('css/admin/admin.css')) }}
{{ Html::script(asset('js/admin/qcm.js')) }}
{{ Html::script(asset('js/geovisit_uploader.js')) }}
{{ Html::script(asset('js/uploads.js')) }}
@endsection

@section('content')
<div class="row" style="margin: 0px;padding: 0px;top: 0px;">
    <ul id="menu_fonctions">
        <li>
            <a class="menufonction-visited" href="#">Editeur de QCM</a>
        </li>
    </ul>
</div>

@if (is_null($qcm))
{{ Form::open(array('route' => ['admin::qcm::new::post', $id_exercice], 'method' => 'post', 'id' => 'form-qcm')) }}
<script>
    getIdExercice();
</script>
@else
{{ Form::open(array('route' => ['admin::qcm::edit::post', $id_exercice, $qcm['id']], 'method' => 'post')) }}
@endif

<div class="row general" style="padding:0; margin:0;">
    <h1 class="etapes-titre">Titre du QCM</h1>
    <table class="admin-table-input-group">
        <td class="td-label">Titre</td>
        <td class="td-input {{ $errors->has('titre-qcm') ? 'has-error' : '' }}">
            {{ Form::text('titre-qcm', is_null($qcm) ? '' : $qcm['titre'], ['placeholder' => 'Saisir titre du QCM', 'class' => 'table-admin-inputtext']) }}
        </td>
        <td style="border-collapse: initial;"> * </td>
    </table>
    <small class='error-msg'>{{ $errors->first('titre-qcm', ':message') }}</small>
    <br><br>
    <h1 class="etapes-titre">Description du QCM</h1>
    <div class="row" style="padding-left:10px;">
        <div class="nav_exercices" style="padding-left: 10px;">
            <ul>
                <li>
                    <a href="#" id="titre-qcm-description-button" class="liens_intro_exercice startli">
                        <div class="liens_intro_titre"></div>
                    </a>
                </li>
                <li>
                    <a href="#" id="soustitre-qcm-description-button" class="liens_intro_exercice ssttrli">
                        <div class="liens_intro_soustitre"></div>
                    </a>
                </li>
                <li>
                    <a href="#" id="texte-qcm-description-button" class="liens_intro_exercice">
                        <div class="liens_intro_texte"></div>
                    </a>
                </li>
                <li>
                    <a href="#" id="photo-qcm-description-button" class="liens_upload photo">
                        <div class="liens_intro_photo"></div>
                    </a>
                </li>
                <li>
                    <a href="#" id="video-qcm-description-button" class="liens_upload video">
                        <div class="liens_intro_video"></div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="row" style="margin: 0px;">
        <div id="container-qcm-description" class="container_intro ui-sortable" style="min-height: 300px;">
            @if(!is_null($qcm))
            {!! $qcm['description_admin'] !!}
            @endif
        </div>
        {{ Form::hidden('qcm-description', is_null($qcm) ? '' : $qcm['description'], ['id' => 'qcm-description']) }}
        {{ Form::hidden('qcm-description-admin', is_null($qcm) ? '' : $qcm['description_admin'], ['id' => 'qcm-description-admin']) }}
    </div>
    <br><br>
    <center>
        {{ Form::submit('CONTINUER', ['class' => 'submit-qcm']) }}
    </center>
</div>
{{ Form::close() }}
@endsection