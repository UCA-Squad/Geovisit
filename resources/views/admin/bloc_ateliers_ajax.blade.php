<?php $nb = 0 ?>
<div class="row" style="padding:0; margin-bottom:20px; margin-left:10px;">
    <div class="groupe-atelier-inputs" style="width:100%; float:left; padding-top:auto; padding-bottom:auto;">
        <div class="bloc_ateliers">
            <div class="circle_img">
                <img src="{{asset($atelier->image)}}" class="ronde">
            </div>
            <p class="titraille_exercices" style="text-align: center;">{{ $atelier_nom }}</p>
        </div>
        <div class="bloc_inputs" style="padding: 10px 0px 0 0;">
            <table class="admin-table-input-group">
                <td class="td-label">Titre Atelier</td>
                <td class="td-input">
                    {{ Form::text('titre_ateliers[' . $atelier->id . ']', $titre_atelier, ['id' => 'titre_ateliers_' . $atelier->id, 'class' => 'table-admin-inputtext titre_atelier']) }}
                </td>
                <td style="border-collapse:initial; "> * </td>
            </table>
            <input type="hidden" id="titre_ateliers_{{ $atelier->id }}" name="titre_ateliers_{{ $atelier->id }}" value="{{$titre_atelier}}">
            <table class="admin-table-input-group">
                <td class="td-label">Description Atelier</td>
                <td class="td-input">
                    {{ Form::text('description_ateliers[' . $atelier->id . ']', $description_atelier, ['id' => 'description_ateliers_' . $atelier->id, 'class' => 'table-admin-inputtext', 'maxlength' => 140]) }}
                </td>
                <td style="border-collapse:initial; "> * </td> 
            </table>
            {{ Form::hidden('description_ateliers_' . $atelier->id, $description_atelier, ['id' => 'description_ateliers_' . $atelier->id]) }}				
        </div>
    </div><br><br>
</div>
<?php $nb++ ?>

<script>
    var myTimer;
    $(".titre_atelier").on('change', function () {
        var num = this.id.split("_");
        $("#fieldexercices .titraille_exercices #titre_atelier_" + num[num.length - 1]).html(this.value);
    });
    
    //détecter le changement pour enregistrer broullion
    var exercice_a_change = false;
    var elments_changes = [];
    var ateliers = {};
    var details_atelier = {};

    var indice = "";
    var tosubmit = {};

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
                    //maj id exercice
                    for (var key in data.id_exercices) {
                        $('#' + key).val(data.id_exercices[key]);
                    }
                },
                error: function (XMLHttpRequest) {
                    console.log(XMLHttpRequest);
                    exercice_a_change = false;
                }
            });
        }
    }
    
    //reset de temps d'execution on clique sur continuer
    $(".next").on('click', function () {
        if ($("#etape_actuelle").val() === "fieldintro") {
            clearInterval(myTimer);
            delay = 300000;
            myTimer = setInterval(brouillonexercice, delay);
        }
        if ($("#etape_actuelle").val() === "fieldexercices")  {
            clearInterval(myTimer);
            myTimer = setTimeout(brouillonexercice, 1500);
        }
    });
    
    $(".previous").click(function () {
        if ($("#etape_actuelle").val() === "fieldexercices") {
            clearInterval(myTimer);
            myTimer = setTimeout(brouillonexercice, 1500);
        }
        if ($("#etape_actuelle").val() === "fieldpublication") {
            clearInterval(myTimer);
            delay = 300000;
            myTimer = setInterval(brouillonexercice, delay);
        }
    });
</script>