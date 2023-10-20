@section('filescripts')
{{ Html::script(asset('js/popups_admin.js')) }}
{{ Html::script(asset('js/etapes_admin.js')) }}
{{ Html::script(asset('js/editeur_admin.js')) }}
{{ Html::script(asset('js/qcm_admin.js')) }}
{{ Html::script(asset('js/uploads.js')) }}
{{ Html::script(asset('js/geovisit_uploader.js')) }}
@endsection

<div id="fleche_gauche" style="width:10%; height:100%; display:inline; float:left; padding: auto;top:95px">
    <a href="#" id="flecheg" style="display:block"></a>
</div>
<div id="bloc_ateliers_content" style="max-width:70%; height:200px; display:inline; overflow:hidden;">
    {{ Form::open(array('route' => 'choisirsite', 'id' => 'form_checkboxes')) }}
    <?php $nb = 1 ?>
    <div style="max-width:70%; overflow:hidden" id="scroll" >
        <table>
            <tr>
                @if(Session::has('listeAtelierAmodifier'))
                <?php $ateliers_a_changer = Session::get('listeAtelierAmodifier') ?>

                @foreach($ateliers_a_changer['ids'] as $ids)
                <td style="border:none">
                    <input type="hidden" name="id_atelier_choisi" value="{{ $ids }}">
                    <div class="bloc_ateliers">
                        <p class="titraille_exercices" style="text-align: center;">Atelier {{ $nb }}</p>
                        <input type="hidden" name="atelier_nom[{{ $ids }}]" value="Atelier {{ $nb }}">
                        <input type="hidden" name="destination" value="receptacle">
                        <div class="circle_img">
                            <img src="{{ asset($ateliers_a_changer['images'][$ids]) }}" class="ronde">
                        </div>

                        @if(array_key_exists ('id_choisis',$ateliers_a_changer) && in_array($ids, $ateliers_a_changer['id_choisis']))
                        <p><input type="checkbox" id="checkbox-{{ $ids }}" name="selection_atelier[]" value="{{ $ids }}" class="checkbox-admin" style="width:100%;" onclick="OptionsSelected(this);" checked><label for="checkbox-{{ $ids }}" class="checkbox-admin-label">Selectionner</label></p>
                        @else
                        <p><input type="checkbox" id="checkbox-{{ $ids }}" name="selection_atelier[]" value="{{ $ids }}" class="checkbox-admin" style="width:100%;" onclick="OptionsSelected(this);"><label for="checkbox-{{ $ids }}" class="checkbox-admin-label">Selectionner</label></p>
                        @endif

                    </div>
                    <?php $nb++ ?>
                </td>
                @endforeach
                @else
                @foreach($ateliers as $index=>$atelier)
                <td style="border:none">
                    <input type="hidden" name="id_atelier_choisi" value="{{ $atelier->id }}">
                    <div class="bloc_ateliers">
                        <p class="titraille_exercices" style="text-align: center;">Atelier {{ $nb }}</p>
                        <input type="hidden" name="atelier_nom[{{ $atelier->id }}]" value="Atelier {{ $nb }}">
                        <input type="hidden" name="destination" value="receptacle">
                        <div class="circle_img">
                            <img src="{{asset($atelier->image)}}" class="ronde">
                        </div>
                        <p><input type="checkbox" id="checkbox-{{ $atelier->id }}" name="selection_atelier[]" value="{{ $atelier->id }}" class="checkbox-admin" style="width:100%;"  onclick="OptionsSelected(this);"><label for="checkbox-{{ $atelier->id }}" class="checkbox-admin-label">Selectionner</label></p>
                    </div>
                    <?php $nb++ ?>
                </td>
                @endforeach
                @endif
            </tr>
        </table>
    </div>
    {{  Form::close() }}

</div>
<div id="fleche_droite" style="width:10%; height:100%; display:inline;float:right;top: -110px; ">
    <a href="#" id="fleched" style="display:block"></a>
</div>
<script>//ajout scroll
    $(document).ready(function ()
    {
        $("#flecheg").on('click', function (e) {
            e.preventDefault();
            $('#scroll').animate({
                scrollLeft: '-=120'
            }, "fast");
        });
        $("#fleched").on('click', function (e) {
            e.preventDefault();
            $('#scroll').animate({
                scrollLeft: '+=120'
            }, "fast");
        });

        $(".checkbox-admin").on('click', function (e) {
            $('body').scrollLeft(0);
            setTimeout(function () {
                $(".titre_atelier").each(function () {
                    var num = this.id.split("_");
                });
            }, 2000);
        });
    });
</script>