@extends('admin.layouts.base')

@section('content')
@include('admin.nav-tp')

<div class="row" style="padding:0; margin-left:0px;">


    @if($compte > 0)
    @foreach($tpns as $tpn)

    <h1 class="etapes-titre">STATISTIQUES</h1><br>
    <div class="row" style="margin:0; width:100%; margin-left:auto; margin-right:auto;">
        <div class="ensemble_gerer_voir">

            <h3 class="etapes-soustitre">{{ $tpn->titre_tpns }}</h3>
            <div class="row" style="margin:0; margin-bottom:20px; padding:0; height: 200px;">

                <!-- BLOC SITE -->
                <div class="bloc-img-site-voir">

                    <div class="bloc_ateliers_voir">

                        <div class="circle_img">
                            <img src="{{URL::asset($infos_sites[$tpn->id][$tpn->site_id]->photo)}}" class="ronde">
                        </div>
                        <p class="titraille_exercices" style="text-align: center; margin-top:10px;">{{$infos_sites[$tpn->id][$tpn->site_id]->titre}}</p>


                    </div>

                </div>
                <!-- BLOC STATISTIQUES -->
                <div class="bloc-infos-gerer">
                    <div class="row" style="padding-bottom:10px; padding-top:40px; height:100%;">	
                        <div style="display:inline; float:left; margin-right: 30px; width:20%;">
                            <?php $nbAtelier = $tpn->ateliers()->count() ?>
                            <p class="chiffre-info-gerer">{{$nbAtelier}}</p>
                            <p class="type-info" style="width:100%; text-align: center;">atelier(s)</p>
                        </div>
                        <div style="display:inline; float:left; width:20%;">
                            <p class="chiffre-info-gerer">1K</p>
                            <p class="type-info" style="width:100%; text-align: center;">visites</p>

                        </div>


                        <div style="display:inline; float:left; margin-right: 30px; width:20%;">
                            @if(isset($total_exercice[$tpn->id]))
                            <?php $totExercices = $total_exercice[$tpn->id] ?>

                            <p class="chiffre-info-gerer">{{$totExercices}}</p>
                            @endif
                            <p class="type-info" style="width:100%; text-align: center;">exercice(s)</p>
                        </div>
                        <div style="display:inline; float:left; width:20%;">
                            <?php $classessacompter = is_countable($groupes) ? count($groupes) : 0 ?>
                            <p class="chiffre-info-gerer">{{$classessacompter}}</p>
                            <p class="type-info" style="width:100%; text-align: center;">classes</p>
                        </div>
                    </div>	

                </div>

                <!-- BLOC DATE -->
                <div class="bloc-dates-gerer">
                    <div class="row" style="padding: 0; margin:0; margin-top:20px;">
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



        </div>
    </div>

    <h1 class="etapes-titre">GROUPES INSCRITS ({{$classessacompter}})</h1><br>
    <div class="row" style="margin:0; width:100%; margin-left:auto; margin-right:auto;">
        @if ($classessacompter > 0)

        <div class="row" style="margin:0px;">

            @foreach ($groupes as $groupe)
            <div class="panel-group">
                <div class="panel" id="paneladmin">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <span style="width:300px;display: inline-block;">Groupe {{$groupe->titre}} </span>|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nb d’étudiant : {{$groupe->etudiants()->count()}}
                            <a href="{{ route('groupe.edit', $groupe->id) }}"><img src="{{URL::asset('img/crayon.png') }}" style="float:right;margin-left:40px"/></a> <a data-toggle="collapse" href="#collapse{{$groupe->id}}"><img src="{{URL::asset('img/show.png') }}" style="float:right;"/></a></h4>
                    </div>
                    <div id="collapse{{$groupe->id}}" class="panel-collapse collapse">
                        <div class="panel-body">
                            @if($groupe->etudiants()->count() > 0)
                            <table class="etudiant">
                                <tr>

                                    <th>N° D’ETUDIANT</th>
                                    <th>NOM</th>		
                                    <th>PRENOM</th>
                                    <th>CONTACT</th>

                                </tr>

                                @foreach ($groupe->etudiants()->get() as $etudiant)

                                @foreach ($etudiant->user()->get() as $etudiantdetail)
                                <tr><td>{{$etudiantdetail->username}}</td><td>{{$etudiantdetail->nom}}</td><td>{{$etudiantdetail->prenom}}</td><td>{{$etudiantdetail->email}}</td></tr>
                                @endforeach
                                @endforeach
                            </table>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="aucun_element">Vous n'avez assigné aucun groupe!</p>
        @endif
    </div>
    @endforeach

    @else
    <p class="aucun_element">Vous n'avez crée aucun Tp numérique!</p>
    @endif


</div>
<style>

    .fields-gerer
    {
        width:100%;
        border: 1px;
        border-style:solid;
        border-color:#ccc;
        height:370px;
        padding:10px;
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
    .bloc_ateliers_voir
    {
        width:100%; margin-top:5%; padding-bottom:10%;
        margin-bottom:10px;
    }


    .bloc-img-site-voir
    {
        padding: 20px 10px 0 10px;
        border-right: 1px solid #ccc; width:20%; margin-right:20px; display:inline; float:left; height: 100%;
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
        padding: 0 0px 10px 0; width:20%; display:inline; float:left;
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

    .ensemble_gerer_voir
    {

        margin-right:20px;
        width: 100%;
        float:left;
        display:inline;
        clear:none;
        margin-bottom:10px;
        /*height:60%;*/
        min-width: 670px;
        max-height:800px;
        /*
        min-height:800px;
        max-height:800px;*/
        /*max-width: 550px;*/

    }


    @media screen and (min-width: 15em) and (max-width: 90em) {

        /*.bloc_ateliers
        {
                width:100%; margin-top:10%; padding-bottom:20%; text-align:center; margin-bottom:10px;
        }*/

        /*.bloc-img-site
        {
                padding: 20px 10px 0 10px;
                border-right: 1px solid #ccc; width:25%; margin-right:20px; display:inline; float:left;

        }*/

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
            font-size: 13px;

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

        .ensemble_gerer_voir
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
            height:370px;
            max-height:370px;
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
@endsection

@section('style')
.sr-only{position:relative; color: #a94442;white-space: nowrap}
.error td{
border: 1px solid #a94442; 
}
.panel{font-family: 'Lato', sans-serif; font-weight:700px; font-size:16px; }
.panel-heading { color:white;    background-color: #f96332;padding: 20px}
.modal-content{padding:20px}
#etudiants {
counter-reset: rowNumber;
}

#etudiants tr:not(:first-child){
counter-increment: rowNumber;
}

#etudiants tr td:first-child::before {
content: counter(rowNumber);
min-width: 1em;
margin-right: 0.5em;
}
#myModal .table-responsive{max-height:400px;  }
.panel .popover-title{color:#000}
.ui-autocomplete{z-index:2147483647; max-height:150px;overflow:auto}
@endsection

@section('scripts')
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
            //alert(publie);
            //alert(input.id);
            var id = $(input).attr('id');

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


                //alert("cochee");

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
                //alert("décochee");

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

