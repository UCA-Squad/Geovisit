<?php $nb = 1 ?>
@if(Session::has('enmodification'))
@if(Session::has('listeAtelierAmodifier'))
<?php $listeAtelierAmodifier = Session::get('listeAtelierAmodifier') ?>
@if(array_key_exists ('id_choisis',$listeAtelierAmodifier))
@foreach($listeAtelierAmodifier['id_choisis'] as $atelier)
<div class="fields">
    <h1 class="titraille_exercices">Atelier {{$nb}} 
        <span id="titre_atelier_{{$atelier}}"></span>
        {{ Form::hidden('id_atelier_tpn_' . $atelier, $listeAtelierAmodifier['id_tpn'][$atelier], ['id' => 'id_atelier_tpn_' . $atelier]) }}
    </h1>
    <h3 class="etapes-soustitre">Choisir et placer les icones d'exercices</h3>
    <div class="row" style="margin:0;">
        <div id="nav_exercices" class="nav_exercices">
            <ul>
                <li><a href="#" id="texte-exercice-button-{{ $atelier }} " class="exercice-buttons startli" onclick='placer_exercices(this.id, "{{ $atelier }}", "Atelier {{ $nb }}");return false;'><div class="liens_intro_texte"></div></a></li>
                <li><a href="#" id="photo-exercice-button-{{ $atelier }}" class="exercice-buttons" onclick='placer_exercices(this.id, "{{ $atelier }}", "Atelier {{ $nb }}");return false;'><div class="liens_intro_photo"></div></a></li>
                <li><a href="#" id="video-exercice-button-{{ $atelier }}" class="exercice-buttons" onclick='placer_exercices(this.id, "{{ $atelier }}", "Atelier {{ $nb }}");return false;'><div class="liens_intro_video"></div></a></li>
                <li><a href="#" id="qcm-exercice-button-{{ $atelier }}" class="exercice-buttons" onclick='placer_exercices(this.id, "{{ $atelier }}", "Atelier {{ $nb }}");return false;'><div class="liens_intro_qcm"></div></a></li>
            </ul>
        </div>
    </div>
    <div class="row" style="margin:0;">
        {{ Form::hidden('vmin_atelier_' . $atelier, $listeAtelierAmodifier['vmin'][$atelier], ['id' => 'vmin_atelier_' . $atelier]) }}
        {{ Form::hidden('hmin_atelier_' . $atelier, $listeAtelierAmodifier['hmin'][$atelier], ['id' => 'hmin_atelier_' . $atelier]) }}
        {{ Form::hidden('vmax_atelier_' . $atelier, $listeAtelierAmodifier['vmax'][$atelier], ['id' => 'vmax_atelier_' . $atelier]) }}
        {{ Form::hidden('hmax_atelier_' . $atelier, $listeAtelierAmodifier['hmax'][$atelier], ['id' => 'hmax_atelier_' . $atelier]) }}
        <div id="container_placement_exercice_{{ $atelier }}" class="container_placement_exercice" style='margin: 10px 0 10px 0; height:200px; background-image: url("{{ asset($listeAtelierAmodifier['deplie_choisis'][$atelier]) }}");  background-repeat: no-repeat;' class="ui-sortable">
             <img src="{{ asset($listeAtelierAmodifier['deplie_choisis'][$atelier]) }}" style="display:none;max-width:100%"/>
        </div>
        <a href="{{ url('/demo/'.$atelier.'/0') }}" id="intro_voir_placementexercice_{{ $atelier }}" class="intro_voir_placementexercice" target="_blank"><img src='{{ asset("/css/img/SOMMAIRE_ICONE_VOIR.png") }}'> Voir</a>
    </div>
    </br>
    <h3 class="etapes-soustitre">Construction des exercices</h3>
    <div id="receptacle-exercices_{{$atelier}}" class="receptacle-exercices" style="width:100%;">
        @include('admin.ateliers.bloc-liste-exercice')
    </div>
    <!-- EN ATTENTE AJAX -->
</div>
<?php $nb++ ?>
@endforeach
@endif
@endif

@else
@foreach($ateliers as $atelier)

<div class="fields">
    <h1 class="titraille_exercices">{{ $atelier_noms[$atelier->id]}} 
        <span id="titre_atelier_{{ $atelier->id }}"></span>
        {{ Form::hidden('id_atelier_tpn_' . $atelier->id, '', ['id' => 'id_atelier_tpn_' . $atelier->id]) }}
    </h1>
    <h3 class="etapes-soustitre">Choisir et placer les icones d'exercices</h3>
    <div class="row" style="margin:0;">
        <div id="nav_exercices" class="nav_exercices">
            <ul>
                <li><a href="#" id="texte-exercice-button-{{ $atelier->id }}" class="exercice-buttons startli" onclick='placer_exercices(this.id, "{{ $atelier->id }}", "{{ $atelier_noms[$atelier->id] }}");return false;'><div class="liens_intro_texte"></div></a></li>
                <li><a href="#" id="photo-exercice-button-{{ $atelier->id }}" class="exercice-buttons" onclick='placer_exercices(this.id, "{{ $atelier->id }}", "{{ $atelier_noms[$atelier->id] }}");return false;'><div class="liens_intro_photo"></div></a></li>
                <li><a href="#" id="video-exercice-button-{{ $atelier->id }}" class="exercice-buttons" onclick='placer_exercices(this.id, "{{ $atelier->id }}", "{{ $atelier_noms[$atelier->id] }}");return false;'><div class="liens_intro_video"></div></a></li>
                <li><a href="#" id="qcm-exercice-button-{{ $atelier->id }}" class="exercice-buttons" onclick='placer_exercices(this.id, "{{ $atelier->id }}", "{{ $atelier_noms[$atelier->id] }}");return false;'><div class="liens_intro_qcm"></div></a></li>
            </ul>
        </div>
    </div>
    <div class="row" style="margin:0;">
        <div id="container_placement_exercice_{{ $atelier->id }}" class="container_placement_exercice" style=' margin: 10px 0 10px 0; height:200px; background-image: url("{{  asset($atelier->image_deplie) }}"); background-repeat: no-repeat;' class="ui-sortable">
            <img src="{{ asset($atelier->image_deplie) }}" style="z-index:-100;max-width:100%;display:none"/>
        </div>
        <a href="{{ url('/demo/'.$atelier->id.'/0') }}" id="intro_voir_placementexercice_{{ $atelier->id }}" class="intro_voir_placementexercice" target="_blank"><img src='{{ asset("/css/img/SOMMAIRE_ICONE_VOIR.png") }}'> Voir</a>
    </div>
    </br>
    <h3 class="etapes-soustitre">Construction des exercices</h3>
    <div id="receptacle-exercices_{{ $atelier->id }}" class="receptacle-exercices" style="width:100%;">
        <!-- EN ATTENTE AJAX -->
        <p p class="aucun_element">Aucun Exercice(s) crée(s).</p>
    </div>
</div>
@endforeach

@endif

<script>
    $(document).ready(function () {
        $('.container_placement_exercice img').each(function () {
            var maxWidth = $('.drt').width() - 40; // Max width for the image
            var maxHeight = 400;    // Max height for the image
            var ratio = 0;  // Used for aspect ratio

            var parent = $(this).parent();
            var moi = this;
            setTimeout(function () {

                var width = moi.width;    // Current image width
                var height = moi.height;  // Current image height

                // Check if the current width is larger than the max
                if (width > maxWidth) {
                    ratio = maxWidth / width;   // get ratio for scaling image

                    $(this).css("width", maxWidth); // Set new width
                    $(this).css("height", height * ratio);  // Scale height based on ratio

                    parent.css("width", maxWidth + 'px');
                    parent.css("height", height * ratio + 'px');
                    parent.css("background-size", maxWidth + 'px ' + height * ratio + 'px');

                    height = height * ratio;    // Reset height to match scaled image
                    width = width * ratio;    // Reset width to match scaled image
                } else {
                    parent.css("width", width); // Set new width
                    parent.css("height", height);  // Scale height based on ratio
                }
            }, 5000);
        });
    });
</script>