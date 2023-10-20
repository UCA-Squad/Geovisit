@extends('admin.layouts.base')

@section('content')

@include('admin.nav-site')

@foreach($infos_sites as $site)
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
                        {{ Form::open(['route' => ['admin::site::delete', $site->id], 'method' => 'delete', 'onsubmit' => 'return confirm("Confirmer la suppression ?")']) }}
                            <a href="{{ route('admin::site::summary::edit', $site->id) }}" class="liens_gerer action-button">MODIFIER SOMMAIRE</a>
                            <a href="{{ route('admin::site::atelier::index', $site->id) }}" class="liens_gerer action-button">MODIFIER ATELIER(S)</a>                        
                            {{ Form::submit('SUPPRIMER', ['class' => 'liens_gerer action-button submit-delete']) }}
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach


@endsection