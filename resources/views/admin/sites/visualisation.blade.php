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

@section('content')

@include('admin.nav-site')

@if (Session::get('sitessrub') === 'nouveau')
<!-- progressbar -->
<ul id="progressbar_sites">
    <li>Sommaire</li>
    <li>Ateliers</li>
    <li class="active">Visualisation</li>
</ul>
@endif

<div class="row">
    <div class="ensemble_gerer">
        <div class="foreground_fields foreground_publie">
            <div class="fields-gerer">
                <h3 class="etapes-soustitre">{{ $site->titre }}</h3>
                <br><br>
                <div class="row">
                    <div class="bloc-img-site">
                        <div class="circle_img">
                            <img src="{{ URL::asset($site->photo) }}" class="ronde">
                        </div>
                    </div>
                    <div class="bloc-infos-gerer">
                        <div class="row">
                            <p class="chiffre-info-gerer">{{ $site->nb_ateliers }}</p>
                            <p class="type-info">atelier(s)</p>
                        </div>
                    </div>
                    <div class="bloc-last-gerer">
                        <div class="row">
                            <p class="chiffre-info-gerer">{{ $site->nb_tpns }}</p>
                            <p class="type-info">travaux pratiques numériques</p>
                        </div>
                    </div>
                </div>
                <br>
                <div class="bloc-gerer-btns row">
                    <div style="float: right">
                        <a href="{{ route('showsite', $site->id) }}" class="liens_gerer action-button">VERIFIER LE SITE</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection