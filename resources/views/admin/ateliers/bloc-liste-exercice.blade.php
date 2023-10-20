@if(Session::has('enmodification'))

@if(Session::has('listeAtelierAmodifier'))

<?php $listeAtelierAmodifier = Session::get('listeAtelierAmodifier') ?>
<?php $numero = 1 ?>
<?php $numero_atelier = 1 ?>
<?php $id =$atelier ?>

@if(array_key_exists ('exercices',$listeAtelierAmodifier))

@foreach($listeAtelierAmodifier['exercices'][$atelier] as $exercices)

<?php $exercice = $exercices->type ?>
<?php $exercice_x = $exercices->x ?>
<?php $exercice_y = $exercices->y ?>

<div id="exercice_{{ $exercice }}_{{ $numero }}" class="fields">

    {{ Form::hidden('numero_exercice[' . $id . '][]', $numero, ['id' => 'numero_exercice_' . $numero]) }}
    {{ Form::hidden('type_exercice[' . $id . '][' . $numero . ']', $exercice, ['id' => 'type_exercice_' . $numero]) }}
    {{ Form::hidden('id_exercice[' . $id . '][]', $exercices->id, ['id' => 'id_exercice_' . $numero . '_' . $id]) }}

    <div class="entete-exercice row">
        <span class="entete-textes" style="width:80%; display:inline;float:left;">
            <h4 class="titraille_exercices_bold">Exercice {{$numero}}</h4>
            <h5 class="titraille_exercices">Atelier {{$numero_atelier}}</h5>
        </span>
        <span class="entete-fermeture" style="width:5%; font-size:16px; float:right; display:inline;">
            <button type="button" class="entete-fermeture-lien" data-toggle="collapse" data-target="#toggle-exercice_{{$numero}}_atelier_{{$id}}" title="Voir l'atelier"> - </button>
        </span>
    </div></br>

    <!-- EXERCICE -->
    <div id="toggle-exercice_{{$numero}}_atelier_{{$id}}" class="collapse in bloc-toggle-exercice row">
        <?php $tableauNbTypeParExercices = $listeAtelierAmodifier['exercices_nb_types'] ?>
        <?php $nbTypeParExercices = $tableauNbTypeParExercices[$id][$exercice] ?>

        {{ Form::hidden('numeros[' . $id . '][' . $exercice . '][]', $exercice . '-' . $nbTypeParExercices . '-' . $numero, ['id' => 'numeros_atelier_' . $id]) }}
        {{ Form::hidden('coord[' . $exercice . '][' . $numero . '][' . $id . ']', '', ['id' => 'coord_' . $exercice . '_' . $numero . '_' . $id]) }}
        {{ Form::hidden('nbreType[' . $id . '][' . $numero . '][' . $exercice . ']', $nbTypeParExercices, ['id' => 'nbreType' . $id . '_' . $numero . '_' . $exercice]) }}

        @if($exercice == "texte" || $exercice == "photo" || $exercice == "video")

        <div class="row" style="padding-left:10px;">
            <div id="nav-intro-exercice-{{$numero}}-atelier-{{$id}}" class="nav_exercices" style="padding-left:10px;">
                <ul>
                    <li>
                        <a href="#" id="button-titres-exercice-{{$exercice}}-{{$numero}}-{{$nbTypeParExercices}}-atelier-{{$id}}" onclick="javascript:clickAjout(this.id);
                            return false;" class="liens_intros_exercice startli"><div class="liens_intro_titre"></div></a>
                    </li>
                    <li>
                        <a href="#" id="button-soustitre-exercice-{{$exercice}}-{{$numero}}-{{$nbTypeParExercices}}-atelier-{{$id}}" onclick="javascript:clickAjout(this.id);
                            return false;" class="liens_intros_exercice ssttrli"><div class="liens_intro_soustitre"></div></a>
                    </li>
                    <li>
                        <a href="#" id="button-texte-exercice-{{$exercice}}-{{$numero}}-{{$nbTypeParExercices}}-atelier-{{$id}}" onclick="javascript:clickAjout(this.id);
                            return false;" class="liens_intros_exercice"><div class="liens_intro_texte"></div></a>
                    </li>
                    <li>
                        <a href="#" id="button-photo-exercice-{{$exercice}}-{{$numero}}-{{$nbTypeParExercices}}-atelier-{{$id}}" class="liens_upload_exercice" onclick="javascript:clickAjout(this.id);
                            return false;"><div class="liens_intro_photo"></div></a>
                    </li>
                    <li>
                        <a href="#" id="button-video-exercice-{{$exercice}}-{{$numero}}-{{$nbTypeParExercices}}-atelier-{{$id}}" class="liens_upload_exercice" onclick="javascript:clickAjout(this.id);
                            return false;"><div class="liens_intro_video"></div></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row" style="margin:0;">
            <div id="container_exercice_{{$numero}}_atelier_{{$id}}" class="container_exercice ui-sortable" style="min-height:300px;">
                {!! $exercices->contenu_admin !!}
            </div>
            {{ Form::hidden('contenu_exercices[' . $exercice . '][' . $nbTypeParExercices . '][' . $numero . '][' . $id . ']', '',
                        ['id' => 'contenu_exercices_' . $exercice . '_' . $nbTypeParExercices . '_' . $numero . '_' . $id, 'class' => 'hidden_array_contenu_exercice']) }}
            <a href='#' id='voir_exercice_{{$numero}}_atelier_{{$id}}' class='voir_exercice' onclick="voirContainer_exercice('#container_exercice_' + {{ $numero }} + '_atelier_' + {{ $id }}, 'exercice');">
                <img src="{{ asset('/css/img/SOMMAIRE_ICONE_VOIR.png') }}"> Voir
            </a>
        </div>

        @elseif($exercice === "qcm")
        <!-- TODO FORM QCM -->
            <a href="{{ route('admin::qcm::edit::get', ['exercice_id' => $exercices->id, 'id' => $exercices->contenu_admin !== "" ? json_decode($exercices->contenu_admin)->qcm_id : "new"]) }}" target="_blank">MODIFIER LE QCM</a>
        @endif

    </div>
</div>
<script>
    ajoutIconExercice('{{ $id }}', '{{ $exercice }}', {{ $nbTypeParExercices }}, {{ $numero }}, {{ $exercice_x }}, {{ $exercice_y }});
</script>

<?php $numero++ ?>
@endforeach

<?php $numero_atelier++ ?>
@endif
@endif
@endif

<div class="clearfix"></div>