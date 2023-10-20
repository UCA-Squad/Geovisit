<?php $nb = 0 ?>

@if(Session::has('listeAtelierAmodifier'))
<?php $ateliers_a_changer = Session::get('listeAtelierAmodifier') ?>
@foreach($ateliers_a_changer['ateliers_cree_infos'] as $atelier)
<div class="row" style="padding:0; margin-bottom:20px; margin-left:10px;">
    <div class="groupe-atelier-inputs" style="width:100%; float:left; padding-top:auto; padding-bottom:auto;">
        <div class="bloc_ateliers">
            <div class="circle_img">
                <img src="{{ asset($ateliers_a_changer['images'][$atelier->atelier_id]) }}" class="ronde">
            </div>
            <p class="titraille_exercices" style="text-align: center;"><script>document.write($("input[name='atelier_nom[{{ $atelier->atelier_id }}]']").val());</script></p>
        </div>
        <div class="bloc_inputs" style="padding: 10px 0px 0 0;">
            <table class="admin-table-input-group">
                <tr>
                    <td class="td-label">Titre Atelier</td>
                    <td class="td-input">
                        {{ Form::text('titre_ateliers[' . $atelier->atelier_id . ']', $atelier->titre_atelier, ['id' => 'titre_ateliers_' . $atelier->atelier_id, 'class' => 'table-admin-inputtext titre_atelier']) }}
                    </td>
                    <td style="border-collapse:initial; "> * </td>
                </tr>
            </table>

            <table class="admin-table-input-group">
                <tr>
                    <td class="td-label">Description Atelier</td>
                    <td class="td-input">
                        {{ Form::text('description_ateliers[' . $atelier->atelier_id . ']', $atelier->description_atelier, ['class' => 'table-admin-inputtext', 'maxlength' => 140]) }}
                    </td>
                    <td style="border-collapse:initial; "> * </td>
                </tr>
            </table>
        </div>	
    </div><br><br>
</div>

<?php $nb++ ?>

@endforeach

@else

@foreach($ateliers as $atelier)
<div class="row" style="padding:0; margin-bottom:20px; margin-left:10px;">
    <div class="groupe-atelier-inputs" style="width:100%; float:left; padding-top:auto; padding-bottom:auto;">
        <div class="bloc_ateliers">
            <div class="circle_img">
                <img src="{{ asset($atelier->image) }}" class="ronde">
            </div>
            <p class="titraille_exercices" style="text-align: center;">{{ $atelier_noms[$atelier->id] }}</p>
        </div>
        <div class="bloc_inputs" style="padding: 10px 0px 0 0;">
            <table class="admin-table-input-group">
                <td class="td-label">Titre Atelier</td>
                @if (Session::has('gardeAteliersInputs'))
                <?php $ateliers_inputs = Session::get('gardeAteliersInputs') ?>
                @if(isset($ateliers_inputs['titre'][$atelier->id]))
                <td class="td-input">
                    {{ Form::text('titres_ateliers[' . $atelier->id . ']', $ateliers_inputs['titre'][$atelier->id], ['id' => 'titres_ateliers_' . $atelier->id, 'class' => 'table-admin-inputtext titre_atelier']) }}
                </td>
                <td style="border-collapse:initial; "> * </td>
                @else
                <td class="td-input">
                    {{ Form::text('titres_ateliers[' . $atelier->id . ']', '', ['id' => 'titres_ateliers_' . $atelier->id, 'class' => 'table-admin-inputtext titre_atelier']) }}
                </td>
                <td style="border-collapse:initial; "> * </td>
                @endif
                @else
                <td class="td-input">
                    {{ Form::text('titres_ateliers[' . $atelier->id . ']', $titres_ateliers[$atelier->id], ['id' => 'titres_ateliers_' . $atelier->id, 'class' => 'table-admin-inputtext titre_atelier']) }}
                </td>
                <td style="border-collapse:initial; "> * </td>
                @endif
            </table>
            {{ Form::hidden('titres_ateliers_' . $atelier->id, $titres_ateliers, ['id' => 'titres_ateliers_' . $atelier->id]) }}
            <table class="admin-table-input-group">
                <td class="td-label">Description Atelier</td>
                @if (Session::has('gardeAteliersInputs'))
                <?php $ateliers_inputs = Session::get('gardeAteliersInputs') ?>
                @if(isset($ateliers_inputs['description'][$atelier->id]))
                <td class="td-input">
                    {{ Form::text('description_ateliers[' . $atelier->id . ']', $ateliers_inputs['description'][$atelier->id], ['id' => 'description_ateliers_' . $atelier->id, 'class' => 'table-admin-inputtext', 'maxlength' => 140]) }}
                </td>
                <td style="border-collapse:initial; "> * </td>
                @else
                <td class="td-input">
                    {{ Form::text('description_ateliers[' . $atelier->id . ']', '', ['id' => 'description_ateliers_' . $atelier->id, 'class' => 'table-admin-inputtext', 'maxlength' => 140]) }}
                </td>
                <td style="border-collapse:initial; "> * </td>
                @endif
                @else
                <td class="td-input">
                    {{ Form::text('description_ateliers[' . $atelier->id . ']', $description_ateliers[$atelier->id], ['id' => 'description_ateliers_' . $atelier->id, 'class' => 'table-admin-inputtext', 'maxlength' => 140]) }}
                </td>
                <td style="border-collapse:initial; "> * </td> 
                @endif
            </table>
            {{ Form::hidden('description_ateliers_' . $atelier->id, $description_ateliers, ['id' => 'description_ateliers_' . $atelier->id]) }}				
        </div>
    </div><br><br>
</div>
<?php $nb++ ?>

@endforeach
@endif

<script>
    var exercice_a_change = false;
    var elments_changes = [];
    var ateliers = {};
    var details_atelier = {};

    var indice = "";
    var tosubmit = {};
    var myTimer;
    $(document).ready(function () {
        $(".titre_atelier").on('change', function () {
            var num = this.id.split("_");
            $("#fieldexercices .titraille_exercices #titre_atelier_" + num[num.length - 1]).html(this.value);
        });

        //détecter le changement pour enregistrer broullion
        function brouillonexercice() {
            if (exercice_a_change) {
                tosubmit['_token'] = $('input[name=_token]').val();
                tosubmit['selection_atelier'] = ateliers;
                var id_brouillon = $("#id_brouillon").val();
                $.ajax({
                    url: host + '/admin/tpnumerique/brouillon/' + id_brouillon + '/selection_atelier+numero_exercice',
                    type: "post",
                    data: tosubmit,
                    dataType: "json",
                    success: function (data) {
                        elments_changes = [];
                        ateliers = {};
                        details_atelier = {};
                        tosubmit = {};
                        exercice_a_change = false;
                        for (var key in data.id_exercices) {
                            $('#' + key).val(data.id_exercices[key]);
                        }
                    },
                    error: function (XMLHttpRequest) {
                        exercice_a_change = false;
                    }
                });
            }
        }

        $(".next").on('click', function () {
            if ($("#etape_actuelle").val() === "fieldintro") {
                clearInterval(myTimer);
                delay = 300000;
                myTimer = setInterval(brouillonexercice, delay);
            }
            if ($("#etape_actuelle").val() === "fieldexercices") {
                clearInterval(myTimer);
                myTimer = setTimeout(brouillonexercice, 100);
            }
        });

        $(".previous").click(function () {
            if ($("#etape_actuelle").val() === "fieldexercices") {
                clearInterval(myTimer);
                myTimer = setTimeout(brouillonexercice, 100);
            }
            if ($("#etape_actuelle").val() === "fieldpublication") {
                clearInterval(myTimer);
                delay = 300000;
                myTimer = setInterval(brouillonexercice, delay);
            }
        });
    });
</script>