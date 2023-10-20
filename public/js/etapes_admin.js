
var current_fs, next_fs, previous_fs;
var left, opacity, scale;
var animating;

$(document).ready(function () {

    $('#publier_maintenant').click(function () {
        var form = $('#tpnumform2');
        var titre_tp = $("input[name=titre_tp]");
        var descr_tp = $("input[name=descr_tp]");
        var submit = true;
        
        // GESTION ERREURS
        if (titre_tp.val() === "") {
            $("#erreur_titre_tp").show();
            submit = false;
        } else {
            $("#erreur_titre_tp").hide();
        }
        
        if (descr_tp.val() === "") {
            $("#erreur_description_tp").show();
            submit = false;
        } else {
            $("#erreur_description_tp").hide();
        }
        
        $('.container_exercice').each(function () {
            if ($(this).html() === "")  {
                $("#erreur_exercice").show();
                submit = false;
                return false;
            } else {
                $("#erreur_exercice").hide();
            }
        });
        
        if (submit) {            
            $('.erreurs_admin').each(function () {
                $(this).hide();
            });
            $('#etat').val("asubmit");

            form.submit();
        }
    });

    //POST FORMULAIRE PUBLICATION PLUS TARD
    $('#publier_plustard').click(function () {
        $('.erreurs_admin').each(function () {
            $(this).hide();
        });
        
        $('#etat').val("asubmitplustard");
        var form = $('#tpnumform2');
        form.submit();
    });
    //FIN POST FORMULAIRE

    // TITRE DYNAMIQUE PUBLICATION
    var titre_tp = $("input[name=titre_tp]");
    var site_tp = $("input[name=id_site]");

    $(titre_tp).blur(function () {
        if (titre_tp.val().length === 0)
            $('.titre_dynamique_publication').html('Titre dynamique de mon tp');
        else
            $('.titre_dynamique_publication').html(titre_tp.val());
    });

    $("#etape_actuelle").val("fieldintro");
    $(".next").click(function () {
        var arr_nb_cochee = 0;
        $('.checkbox-admin').each(function () {
            var input = $(this).attr('id');
            var cochee = $("#" + input).is(':checked');
            if (cochee) {
                arr_nb_cochee++;
            }
        });

        if ($("#etape_actuelle").val() === "fieldintro") {
            if (site_tp.val() === "") {
                $("#erreur_site_tp").show();
            } else {
                $("#erreur_site_tp").hide();
            }

            if (site_tp.val() !== "" && arr_nb_cochee === 0) {
                $("#erreur_ateliers_tp").show();
            } else{
                $("#erreur_ateliers_tp").hide();
            }
            
            if (site_tp.val() !== "" && arr_nb_cochee > 0) {
                $('.erreurs_admin').each(function () {
                    $(this).hide();
                });

                if (animating) {
                    return false;
                }
                animating = true;

                current_fs = $(this).parent().parent();
                next_fs = $(this).parent().parent().next();
                $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
                next_fs.show();
                var id_next = next_fs.attr('id');                
                
                $.ajax({
                    url: host + '/admin/setactive',
                    type: "post",
                    data: {'active': id_next, '_token': $('input[name=_token]').val()},
                    dataType: "json",
                    success: function (data) {
                        $("#etape_actuelle").val(data.msg);
                    }
                });


                animating = false;
                current_fs.hide();

                //code pour brouillon
                var tosubmit = {};
                tosubmit['_token'] = $('input[name=_token]').val();
                
                var site = '';
                var id_brouillon = ($("#id_brouillon").val() !== '') ? $("#id_brouillon").val() : '0';
                if (id_brouillon === '0') {
                    tosubmit['id_site'] = $('input[name=id_site]').val();
                    site = '+id_site';
                }
                var titres = [];
                var descriptions = [];
                tosubmit['selection_atelier'] = $("input[name='selection_atelier[]']:checked").map(function () {
                    titres[this.value] = $("input[name='titre_ateliers[" + this.value + "]'").val();
                    descriptions[this.value] = $("input[name='description_ateliers[" + this.value + "]'").val();
                    return this.value;
                }).get();
                tosubmit['titres_ateliers'] = titres;
                tosubmit['description_ateliers'] = descriptions;
                $.ajax({
                    url: host + '/admin/tpnumerique/brouillon/' + id_brouillon + '/selection_atelier+titres_ateliers+description_ateliers' + site,
                    type: "post",
                    data: tosubmit,
                    dataType: "json",
                    success: function (data) {
                        if (id_brouillon === '0') {
                            $("#id_brouillon").val(data.id);
                            $("#id_brouillon2").val(data.id);
                        }
                        
                        for (var index in data.id_ateliers_tpn) {
                            $("#fieldexercices .titraille_exercices #id_atelier_tpn_" + index).val(data.id_ateliers_tpn[index]);
                        }
                        
                        $('.intro_voir_placementexercice').each(function () {
                            var url = $(this).attr('href').split("/");                        
                            $(this).attr('href', $(this).attr('href').replace('/0', '/' + $("#id_atelier_tpn_" + url[url.length - 2]).val()));
                        });
                    },
                    error: function (XMLHttpRequest) {
                        console.log(XMLHttpRequest);
                    }
                });
            }
        } else {
            if ($("#etape_actuelle").val() === "fieldexercices") {
                var nbTotal = 0;
                $('.container_placement_exercice').each(function () {
                    var nbExeDetectes = $(this).find('.dragelement').length;
                    nbTotal += nbExeDetectes;
                });
                
                if (nbTotal === 0) {
                    $("#erreur_exercices_tp").show();
                } else if (nbTotal > 0) {
                    if (animating) {
                        return false;
                    }
                    animating = true;

                    current_fs = $(this).parent().parent();
                    next_fs = $(this).parent().parent().next();
                    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
                    next_fs.show();
                    var id_next = next_fs.attr('id');
                    
                    $.ajax({
                        url: host + '/admin/setactive',
                        type: "post",
                        data: {'active': id_next, '_token': $('input[name=_token]').val()},
                        dataType: "json",
                        success: function (data) {
                            $("#etape_actuelle").val(data.msg);
                        }
                    });
                    animating = false;
                    current_fs.hide();
                }
            }
        }
    });

    $(".previous").each(function () {

        $(".previous").click(function () {
            if (animating)
                return false;
            animating = true;

            current_fs = $(this).parent().parent();
            previous_fs = $(this).parent().parent().prev();
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
            previous_fs.show();
            var id_previous = previous_fs.attr('id');
            
            $.ajax({
                url: host + '/admin/setactive',
                type: "post",
                data: {'active': id_previous, '_token': $('input[name=_token]').val()},
                dataType: "json",
                success: function (data) {
                    $("#etape_actuelle").val(data.msg);
                }
            });            
            animating = false;
            current_fs.hide();
        });
    });
});

