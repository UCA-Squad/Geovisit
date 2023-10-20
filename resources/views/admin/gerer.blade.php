@extends('admin.layouts.base')

@section('content')
@include('admin.nav-tp')

<div class="row" style="padding:0; margin-left:auto; margin-right:auto;">

    <h1 class="etapes-titre">MES TRAVAUX PRATIQUES NUMERIQUES ({{ $compte }})</h1><br>
    <div class="row" style="margin:0; width:100%; margin-left:auto; margin-right:auto;">
        @if($compte > 0)
        @foreach($tpns as $tpn)
        <div class="ensemble_gerer">
            @if($tpn->publie == "1")
            <div class="foreground_fields foreground_publie">
                @elseif($tpn->publie == "0")
                <div class="foreground_fields foreground_depublie">
                    @elseif($tpn->publie == "2")
                    <div class="foreground_fields foreground_depublie">
                        @endif
                        <div class="fields-gerer" style="margin-right:20px;">

                            <h3 class="etapes-soustitre">{{ $tpn->titre_tpns }}
                                @if($tpn->publie == "1")
                                <span style="float:right;"><input type="checkbox" id="checkbox-publie-{{$tpn->id}}" name="etat_tpn[{{$tpn->id}}]" value="{{$tpn->publie}}" class="checkbox-admin" onclick="depublierepublier(this, '{{$tpn->publie}}', '{{$tpn->id}}'); return false;" style="width:100%;"><label for="checkbox-publie-{{$tpn->id}}" class="checkbox-admin-label" style="font-size:10px !important;">Publié</label></span>
                                <script>
                                    $(document).ready(function ()
                                    {
                                        $('#checkbox-publie-{{$tpn->id}}').prop('checked', true);
                                    });

                                </script>
                                @elseif($tpn->publie == "0")
                                <span style="float:right;"><input type="checkbox" id="checkbox-publie-{{$tpn->id}}" name="etat_tpn[{{$tpn->id}}]" value="{{$tpn->publie}}" class="checkbox-admin" onclick="depublierepublier(this, '{{$tpn->publie}}', '{{$tpn->id}}'); return false;" style="width:100%;"><label for="checkbox-publie-{{$tpn->id}}" class="checkbox-admin-label">Non Publié</label></span>
                                <script>
                                    $(document).ready(function ()
                                    {
                                        $('#checkbox-publie-{{$tpn->id}}').prop('checked', false);
                                    });

                                </script>
                                @elseif($tpn->publie == "2")
                                <span style="float:right;">Brouillon</span>
                                @endif
                            </h3><br><br>
                            <div class="row" style="margin:0; margin-bottom:20px; padding:0; height:20%;">

                                <!-- BLOC SITE -->
                                <div class="bloc-img-site">

                                    <div class="bloc_ateliers">

                                        <div class="circle_img">
                                            <img src="{{URL::asset($infos_sites[$tpn->id][$tpn->site_id]->photo)}}" class="ronde">
                                        </div>
                                        <p class="titraille_exercices" style="text-align: center; margin-top:10px;">{{$infos_sites[$tpn->id][$tpn->site_id]->titre}}</p>


                                    </div>

                                </div>
                                <!-- BLOC STATISTIQUES -->
                                <div class="bloc-infos-gerer">
                                    <div class="row" style="margin:auto; width:100%; padding:0 50px 0;">
                                        <div style="display:inline; float:left; margin-right: 30px; width:40%;">
                                            <p class="chiffre-info-gerer">{{count($tpn->getAteliersTpn())}}</p>
                                            <p class="type-info" style="width:100%; text-align: center;">atelier(s)</p>
                                        </div>
                                        <div style="display:inline; float:left; width:40%;">
                                            <p class="chiffre-info-gerer">1K</p>
                                            <p class="type-info" style="width:100%; text-align: center;">visites</p>

                                        </div>
                                    </div>
                                    <div class="row" style="margin:auto;width:100%; padding:0 50px 0;">
                                        <div style="display:inline; float:left; margin-right: 30px; width:40%;">
                                            @if(isset($total_exercice[$tpn->id]))

                                            <p class="chiffre-info-gerer">{{count($total_exercice[$tpn->id])}}</p>
                                            @else
                                            <p class="chiffre-info-gerer">0</p>
                                            @endif
                                            <p class="type-info" style="width:100%; text-align: center;">exercice(s)</p>
                                        </div>
                                        <div style="display:inline; float:left; width:40%;">
                                            <p class="chiffre-info-gerer">{{count($tpn->getClasses())}}</p>
                                            <p class="type-info" style="width:100%; text-align: center;">classes</p>
                                        </div>
                                    </div>

                                </div>

                                <!-- BLOC DATE -->
                                <div class="bloc-dates-gerer ro">
                                    <div class="row" style="padding: 0; margin:0;">
                                        <strong>Date de création</strong></br>
                                        {{ date('d.m.Y H:i', strtotime($tpn->created_at)) }}
                                    </div>
                                    <div class="row" style="margin:0; margin-top:30px; padding: 0;">
                                        <strong>Date de dernière modification</strong></br>
                                        <?php
                                        /* $date_parts = explode('-', $tpn->updated_at);
                                          $heures = explode(' ', $tpn->updated_at);
                                          $update = $date_parts[2].'.'.$heures[0].'.'.$date_parts[0];
                                          echo $update; */
                                        ?>
                                        {{ date('d.m.Y H:i', strtotime($tpn->updated_at)) }}
                                    </div>

                                </div>


                            </div>

                            <div class="bloc-gerer-btns row">

                                <div style="text-align:center; width:20%; margin-right:20px; display:inline; float:left;">
                                    <a href="{{ route('voirtp', $tpn->id) }}" class="liens_gerer action-button">VOIR</a>
                                </div>
                                <div style="text-align:center; width:50%; display:inline; float:left; margin-right:20px;">
                                    <a href="{{ route('modifiertp', $tpn->id) }}" class="liens_gerer action-button">MODIFIER</a>
                                </div>
                                <div style="text-align:center; height:100%; width:20%; display:inline; float:right; padding:auto">
                                    <a href="{{ route('supprimertp', $tpn->id) }}" class="liens_gerer action-button">SUPPRIMER</a>
                                </div>


                            </div>
                        </div>

                    </div>
                </div>
                @endforeach
                @else
                Vous n'avez crée aucun Tp numérique!
                @endif

            </div>
        </div>
        <style>

            .fields-gerer
            {
                width:100%;
                border: 1px;
                border-style:solid;
                border-color:#ccc;
                height:360px;
                padding:20px;
                margin-bottom: 0px;
                max-height:370px;
                /*height:70%;*/
            }

            .chiffre-info-gerer
            {
                font-family: 'Lato', sans-serif;
                font-weight: 300;
                color: #f96332;
                font-size: 40px;
                width:100%;
                text-align: center;

            }
            .bloc_ateliers
            {
                width:100%; 
                margin-bottom:10px;
            }


            .bloc-img-site
            {
                padding: 10px 10px 0 10px;
                border-right: 1px solid #ccc; width:20%; margin-right:20px; display:inline; float:left;
            }

            .bloc-infos-gerer
            {
                text-align:center; padding: 0 10px 0 10px; border-right: 1px solid #ccc; width:50%; display:inline; float:left; margin-right:20px;
                margin-bottom:10px;
            }

            .bloc-dates-gerer
            {
                font-family: 'Lato', sans-serif;
                font-weight: 400;
                color:grey;
                font-size: 12px;

                text-transform: uppercase;
                padding: 0 10px 10px 0; width:20%; display:inline; float:left;
                margin-bottom:10px;
            }


            .bloc-gerer-btns
            {
                padding:10px; width:95%;
                height:50px;
                float:left;
                margin-right:auto;
                margin-left:auto;
            }
            .foreground_publie
            {
                background:none;
            }

            .foreground_depublie
            {

                width:100%;
                position:relative;
                left:0;
                top:0;
                z-index: 999;
                background-color: rgba(0,0,0,0.020);


            }

            .foreground_depublie .chiffre-info-gerer
            {
                color:grey;
            }

            .foreground_depublie img
            {
                opacity: 0.5;
                filter: alpha(opacity=50);
            }

            .foreground_depublie .etapes-soustitre
            {
                color:grey;
            }

            .ensemble_gerer
            {

                margin-right:20px;
                width: 48%;
                float:left;
                display:inline;
                clear:none;
                margin-bottom:10px;
                /*height:60%;*/
                min-width: 800px;
                max-height:800px;
                /*
                min-height:800px;
                max-height:800px;*/
                /*max-width: 550px;*/

            }

            html { overflow-x: hidden;}
            @media screen and (min-width: 15em) and (max-width: 90em) {

                /*.bloc_ateliers
                {
                        width:100%; 
                        margin-top:10%; 
                        padding-bottom:20%; 
                        text-align:center;
                        margin-bottom:10px;
                }*/

                /*.bloc-img-site
                {
                        padding: 20px 10px 0 10px;
                        border-right: 1px solid #ccc; width:25%; margin-right:20px; display:inline; float:left;

                }*/
                html { overflow-x: hidden;}
                .bloc-img-site
                {
                    padding: 0px 5px 0 5px;
                    border-right: 1px solid #ccc; width:20%; margin-right:20px; display:inline; float:left;
                }

                .bloc-infos-gerer
                {
                    text-align:center; padding: 0 5px 0 5px; border-right: 1px solid #ccc; width:48%; display:inline; float:left; margin-right:20px;
                    margin-bottom:10px;
                }

                .bloc-dates-gerer
                {
                    font-family: 'Lato', sans-serif;
                    font-weight: 400;
                    color:grey;
                    font-size: 12px;

                    text-transform: uppercase;
                    padding: 0 0px 10px 0; width:15%; display:inline; float:left;
                    margin-bottom:10px;
                }

                .chiffre-info-gerer
                {
                    font-family: 'Lato', sans-serif;
                    font-weight: 300;
                    color: #f96332;
                    font-size: 30px;
                    width:100%;
                    text-align: center;
                    clear:both;
                }

                .ensemble_gerer
                {

                    width:100%;
                    /*min-width: 560px;
                    max-width: 560px;*/
                    clear:both;
                    font-size:0.5em;
                    margin-bottom:10px;
                    /*height:60%;*/

                }
                .block-infos
                {
                    /*font-size:0.1em;*/
                }
                .fields-gerer
                {
                    width:100%;
                    border: 1px;
                    border-style:solid;
                    border-color:#ccc;
                    height:370px;
                    padding:10px;
                    margin-bottom: 10px;
                    height:320px;
                    max-height:320px;
                }

                .bloc-gerer-btns
                {
                    padding:0; width:95%;
                    height:50px;
                    float:left;
                    /*margin-top: 10%;
                    margin-bottom: 5%;*/
                    margin-right:auto;
                    margin-left:auto;
                }
            }

        </style>
        <script>
            /*$(document).ready(function()
             {
             function depublierepublier(input, publie)
             {
             alert(publie);
             }
             });*/
            var depublierepublier = function (input, publie, id_tpn)
            {

                $(document).ready(function ()
                {

                    var id = $(input).attr('id');

                    //alert(id);
                    /*/*if ( $(id).is(':checked') ) { alert('cliqué'); }*/


                    var etat = $(input).val();

                    var cochee = $(input).is(':checked');
                    var _token = $(input).closest('input[name=_token]').val();
                    var selections = $(input).closest('input[name^="selection_atelier"]');
                    var destination = "publication";
                    var valeur_input_titre = "";

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    if (cochee)
                    {

                        $("#" + id).closest('.foreground_fields').removeClass('foreground_depublie').addClass('foreground_publie');
                        $(input).attr(':checked', false);
                        $.ajax({
                            url: host + '/admin/changerpublication',
                            type: "post",
                            data: {'id_modifier': id_tpn, 'etat_publication': publie},
                            dataType: "json",
                            success: function (data) {
                                //alert(data.msg);

                                if (data.msg == "ok")
                                {

                                    location.reload();
                                }



                            }
                        });



                    } else if (!cochee)
                    {

                        $("#" + id).closest('.foreground_fields').removeClass('foreground_publie').addClass('foreground_depublie');
                        $.ajax({
                            url: host + '/admin/changerpublication',
                            type: "post",
                            data: {'id_modifier': id_tpn, 'etat_publication': publie},
                            dataType: "json",
                            success: function (data) {
                                //alert(data.msg);

                                if (data.msg == "ok")
                                {

                                    location.reload();
                                }



                            }
                        });

                    }

                });
            }





        </script>
        @endsection

