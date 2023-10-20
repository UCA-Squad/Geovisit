$(document).ready(function () {
    $('.active_over').each(function () {
        $(this).click(function () {
            $(this).closest('.active').removeClass('active').addClass('contenu-cacher');
            $(this).removeClass('.active_over').addClass('dialog_operations_over');
        });
    });

    $('.popupparent').each(function () {
        $(this).click(function () {
            $(this).removeClass('active').addClass('dialog_operations');
            $(this).children().removeClass('active').addClass('contenu-cacher');
        });
    });

    //CHOIX DU SITE
    $("#btn_site").click(function () {
        $("#popup_sites_chx").removeClass('dialog_operations').addClass('active');
        $("#contenus_popup_sites_chx").removeClass('contenu-cacher').addClass('active');

        /*SLIDESHOW*/
        var current_fs, next_fs, previous_fs;
        var animating;

        //AU DEPART
        start_fs = $(".fleche_droite_site").parent().parent();
        start_fs.show();
        start_next_fs = $(".fleche_droite_site").parent().parent().next();
        start_next_fs.hide();

        //AU CLIC A DROITE("SUIVANT")
        $(".fleche_droite_site").click(function () {
            if (animating) {
                return false;
            }
            animating = true;
            current_fs = $(this).parent().parent();
            next_fs = $(this).parent().parent().next();
            next_fs.show();

            animating = false;
            current_fs.hide();
        });


        //AU CLIC A GAUCHE("PRECEDENT")
        $(".fleche_gauche_site").each(function () {
            $(".fleche_gauche_site").click(function () {
                if (animating) {
                    return false;
                }
                animating = true;
                current_fs = $(this).parent().parent();
                previous_fs = $(this).parent().parent().prev();
                previous_fs.show();

                animating = false;
                current_fs.hide();
            });
        });

        //AU CLIC SUR LE BOUTON CORRESPONDANT AU SITE
        $('.valid-choix-site').each(function () {
            $(this).click(function ()  {
                var id_site = $(this).attr('id');
                id_site = id_site.replace('submit_chx_site_', '');

                $.ajax({
                    url: host + '/admin/choisirsite',
                    type: "post",
                    data: {'id_site': id_site, 'destination': 'slider', '_token': $('input[name=_token]').val()},
                    dataType: "json",
                    success: function (data) {
                        $("#popup_sites_chx").removeClass('active').addClass('dialog_operations');
                        $("#contenus_popup_sites_chx").removeClass('active').addClass('contenu-cacher');
                        $('#btn_site').html('');
                        $('#btn_site').append('<span style="color:#000000;">' + data.nom_site + '</span>' + '<img src="' + host + '/css/img/ICONE_PLUS.png" style="float:right;">');
                        $('#slider_ateliers').html('');
                        $('#slider_ateliers').append(data.maquette);
                        $('#id_site').val(id_site);
                        $("#id_site").change();
                        $('#image_site_publication').attr('src', host + '' + data.image_site);
                        $('#titre_site_publier').html('');
                        $('#titre_site_publier').html(data.nom_site);
                        $('#intro_voir_site2').attr('href', host + '/site/' + id_site);
                        $('#intro_voir_site2').show();
                    }
                });
            });
        });
        return false;
    });


    //SI LE CHOIX A DEJA ETE FAIT AU RECHARGEMENT
    if ($('#id_site').val() !== "") {
        var id_site = $('#id_site').val();
        $.ajax({
            url: host + '/admin/choisirsite',
            type: "post",
            data: {'id_site': id_site, 'destination': 'slider', '_token': $('input[name=_token]').val()},
            dataType: "json",
            success: function (data) {
                $('#btn_site').html('');
                $('#btn_site').append(data.nom_site + '<img src="' + host + '/css/img/ICONE_PLUS.png" style="float:right;">');
                $('#slider_ateliers').html('');
                $('#slider_ateliers').append(data.maquette);
                $('#id_site').val(id_site);
                $('#image_site_publication').attr('src', host + '' + data.image_site);
                $('#titre_site_publier').html('');
                $('#titre_site_publier').html(data.nom_site);
            }
        });
    }

    $('.fermerpopup').each(function () {
        $(this).click(function () {
            $(this).parent(".active").removeClass("active").addClass('contenu-cacher');
            $(this).parent().parent().parent(".active").removeClass("active").addClass('dialog_operations');
        });
    });

    $('.fermerpopup_sites').each(function () {
        $(this).click(function () {
            $(this).next(".active").removeClass("active").addClass('contenu-cacher');
            $(this).parent(".active").removeClass("active").addClass('dialog_operations');
        });
    });

    $('.fermerpopup_over').each(function () {
        $(this).click(function ()  {
            $(this).closest(".active_over").removeClass("active_over").addClass('contenu-cacher');
            $(this).parent(".active_over").removeClass("active_over").addClass('dialog_operations_over');
        });
    });
});

//AU CLIC SUR UNE CHECKBOX (CHOIX D'ATELIER)
var OptionsSelected = function (input) {
    $(document).ready(function () {
        var id_atelier_choisi = $(input).val();
        var cochee = $(input).is(':checked');
        var selections = $(input).closest('input[name^="selection_atelier"]');

        var data_titres = {};
        $('input[name^="titres_ateliers\\["]').serializeArray().map(function (n) {
            var name = n['name'].replace(/titres_ateliers\[([0-9]*)\]\[(.*)\]/, '$1');
            data_titres[name] = n['value'];
        });

        var data_descr = {};
        $('input[name^="description_ateliers\\["]').serializeArray().map(function (n) {
            var name = n['name'].replace(/description_ateliers\[([0-9]*)\]\[(.*)\]/, '$1');
            data_descr[name] = n['value'];
        });

        if (cochee) {
            var ajouts = '_token=' + $('input[name=_token]').val() + '&etat=coche' + '&atelier_nom=' + $('input[name="atelier_nom[' + id_atelier_choisi + ']"]').val() + '&titre_atelier=' + $('input[name="titres_ateliers[' + id_atelier_choisi + ']"]').val() + '&description_atelier=' + $('input[name="description_ateliers[' + id_atelier_choisi + ']"]').val() + '&id_atelier_choisi=' + id_atelier_choisi + '&id_atelier_tpn=' + $('input[name=id_atelier_tpn_' + id_atelier_choisi + ']').val();

            $.ajax({
                url: host + '/admin/ajoutatelier',
                type: "post",
                data: ajouts,
                dataType: "json",
                success: function (data) {
                    if ($('#nbre_atelier').html() === 0) {
                        $('#receptacle-ateliers .aucun_element').remove();
                    }
                    $('#receptacle-ateliers').append(data.maquettes);

                    //PRODUCTION DES BLOCS D'ATELIERS
                    $('#receptacle-exercices-placement').append(data.crea_atelier);
                    $('#nbre_atelier').html(Number($('#nbre_atelier').html()) + 1);
                }
            });
        } else if (!cochee) {
            if (selections.length > 0) {
                var ajouts = '_token=' + $('input[name=_token]').val() + '&id_atelier_tpn=' + $('input[name=id_atelier_tpn_' + id_atelier_choisi + ']').val() + '&etat=noncoche' + '&id_atelier_choisi=' + id_atelier_choisi + '&';
                $.ajax({
                    url: host + '/admin/ajoutatelier',
                    type: "post",
                    data: ajouts,
                    dataType: "json",
                    success: function (data) {
                        $('#titre_ateliers_' + id_atelier_choisi).parents('.bloc_inputs').parent().parent().remove();
                        $("#container_placement_exercice_" + id_atelier_choisi).parents('.fields').remove();
                        
                        //PRODUCTION DES BLOCS D'ATELIERS
                        $('#nbre_atelier').html(Number($('#nbre_atelier').html()) - 1);
                        if ($('#nbre_atelier').html() === 0) {
                            $('#receptacle-ateliers').html('');
                            $('#receptacle-ateliers').append('<p class="aucun_element">Aucun atelier séléctionné</p>');
                            $('#nbre_atelier').html("0");
                            
                            $('#receptacle-exercices-placement').html('');
                            $('#receptacle-exercices-placement').append('<p class="aucun_element">Aucun Atelier(s) crée(s).</p>');
                        }
                    },
                    error: function (XMLHttpRequest) {
                        console.log(XMLHttpRequest);
                    }
                });
            }
        }
    });
};