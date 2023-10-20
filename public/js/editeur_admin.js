$(document).ready(function ()
{
    var editable = false;

    $('#fleche_gauche').click(function () {
        $('#bloc_ateliers_content').find('.bloc_ateliers').animate({left: '-=150px'});
        return false;
    });

    var spanajout = function (pour, id) {
        return ('<span id="liensinputs_' + pour + '' + id + '" class="erasemove" style="display:none"><div class="moveicon"></div></br><a href="#" id="liensup_' + pour + '' + id + '" onclick="javascript:supprContainer(\'' + id + '\', \'#liensinputs_' + pour + '' + id + '\'); return false;"><div class="suppricon"></div></a></span>');
    };

    /*EDITEUR INTRO*/

    /*      AJOUTER UN TITRE */
    $("#titre-sommaire-button").click(function () {
        var nb = $(".input_titre_sommaire").length;
        nb++;
        var bloc = '<div style="position: relative;" class="sortable"><div id="titre_sommaire' + nb + '" class="input_titre_sommaire sortable" align="middle" style="width:90%; min-height:50px; border:none; margin-left:auto; margin-right:auto; text-align:center;" contentEditable="true">Titre a changer</div></div><br>';

        $('#container_intro').append(bloc);
        $('#titre_sommaire' + nb).append(spanajout("", 'titre_sommaire' + nb));
        $('.input_titre_sommaire').each(function () {
            $(this).click(function () {
                var _this = $(this);
                editionintro(editable, _this, "titre", "");
                return false;
            });
        });
        $("#intro_tp").val(nettoyertext($('#container_intro').clone()));
        $("#intro_tp").change();
        $("#intro_tp_contenu_admin").val($('#container_intro').html()).change();
        return false;
    });

    /*      AJOUTER UN SOUSTITRE */
    $("#soustitre-sommaire-button").click(function () {
        var nb = $(".input_soustitre_sommaire").length;
        nb++;
        var bloc_sstitre = '<div style="position: relative;" class="sortable"><div id="soustitre_sommaire' + nb + '" class="input_soustitre_sommaire sortable" style="width:90%; min-height:50px; border:none; margin-left:auto; margin-right:auto; text-align:center;" contentEditable="true">Soustitre a changer</div></div><br>';
        $('#container_intro').append(bloc_sstitre);
        $('#soustitre_sommaire' + nb).append(spanajout("", 'soustitre_sommaire' + nb));
        $('.input_soustitre_sommaire').each(function ()
        {
            $(this).click(function ()
            {
                var _this = $(this);
                editionintro(editable, _this, "soustitre", "");
                return false;
            });
        });
        $("#intro_tp").val(nettoyertext($('#container_intro').clone()));
        $("#intro_tp").change();
        $("#intro_tp_contenu_admin").val($('#container_intro').html()).change();
        return false;
    });

    /*      AJOUTER DU TEXTE */
    $("#texte-sommaire-button").click(function () {
        var nb = $(".input_texte_sommaire").length;
        nb++;
        var bloc = '<div style="position: relative;" class="sortable"><div id="texte_sommaire' + nb + '" class="input_texte_sommaire sortable" style="width:90%; min-height:50px; border:none; margin-left:auto; margin-right:auto; overflow:hidden;" contentEditable="true">Texte a changer</div></div>';
        $('#container_intro').append(bloc);
        $('#texte_sommaire' + nb).append(spanajout("", 'texte_sommaire' + nb));
        $('.input_texte_sommaire').each(function ()
        {
            $(this).click(function ()
            {
                var _this = $(this);
                editionintro(editable, _this, "texte", "");
                return false;
            });
        });
        $("#intro_tp").val(nettoyertext($('#container_intro').clone()));
        $("#intro_tp").change();
        $("#intro_tp_contenu_admin").val($('#container_intro').html()).change();
        return false;
    });

    /*FIN EDITEUR INTRO*/

    $('.popupparent_exercices').each(function () {
        $(this).click(function () {
            $(this).removeClass('active').addClass('dialog_operations');
            $(this).children().removeClass('active').addClass('contenu-cacher');
        });
    });

    ['titre', 'soustitre', 'texte', 'image', 'video'].forEach(function (type) {
        $('.input_' + type + '_exercice').each(function () {
            $(this).click(function () {
                editionintro_exercice(false, $(this), type, 'exercice_', '#container_exercice_' + $(this).attr('id').split('_')[2] + '_atelier_' + $(this).attr('id').split('_')[5]);
                return false;
            });
        });
    });

    $('.dragelement').each(function () {
        var id_clicked = $(this).attr('id');
        var container = $(this).parent();
        container.click(function (e) {
            if (e.target.id !== id_clicked || !$(e.target).parents('#' + id_clicked).size()) {
                $('#' + container.attr('id') + ' div.dragelement').each(function () {
                    $(this).css('border', 'none');
                    if ($(this).data('ui-dragable')) {
                        $(this).draggable('destroy');
                    }
                    $('#lienmove_' + this.id).hide();
                    $('#liensup_' + this.id).hide();
                });
            }
            return false;
        });
        observerDrag.observe($(this)[0], configDrag);
        
        $(this).bind('dragstop', function() {
            var split_id = $(this).attr('id').split('_');
            var bloc_offset = $(this).offset();
            var parentOffset = $(this).parent().offset();
            var mousex = bloc_offset.left - parentOffset.left + 40;
            var mousey = bloc_offset.top - parentOffset.top + 40;
            var vmin = Number($('#vmin_atelier_' + split_id[6]).val());
            var vmax = Number($('#vmax_atelier_' + split_id[6]).val());
            var hmin = Number($('#hmin_atelier_' + split_id[6]).val());
            var hmax = Number($('#hmax_atelier_' + split_id[6]).val());
            var relx = (((mousex * (hmax - hmin)) / $(this).parent().width()) + hmin);
            var rely = (((mousey * (vmax - vmin)) / $(this).parent().height()) + vmin);
            console.log(mousey);
            console.log(vmax + ' + ' + vmin)
            console.log($(this).parent().height())
            var id_exercice = $('#id_exercice_' + split_id[4] + '_' + split_id[6]).val();
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            $.ajax({
                url: host + '/admin/tpnumerique/exercice/position',
                type: 'post',
                data: {
                    id_exercice: id_exercice,
                    posx: relx,
                    posy: rely
                },
                dataType: 'json',
                success: function() {
                    console.log('position saved');
                }
            });
        });
    });

    $('.container_exercice').each(function () {
        observer.observe($(this)[0], config);
    });

    $('.lien-suppression-constructeur').each(function () {
        $(this).click(function () {
            var id_content = $(this).attr('id').replace('liensup_', '');
            var id_link = $(this).attr('id');
            edition = true;

            $("#" + id_content).css('border', 'none');
            $("#" + id_content).draggable("destroy");

            document.getElementById($('#' + id_content).parent().attr('id')).removeEventListener('mousemove', monitorPosition);

            var arr_str = id_link.split('_');
            var typeaenlever = arr_str[2];
            var id_exercice = "#id_exercice_" + arr_str[5] + "_" + arr_str[7];

            effacer_exercice("#" + id_content, typeaenlever, arr_str[3], arr_str[7], id_exercice);

            $('#exercice_' + typeaenlever + '_' + arr_str[5] + '').remove();
            if (!$('#receptacle-exercices_' + arr_str[7] + "").length > 0) {
                $('#receptacle-exercices_' + arr_str[7] + "").append('<p class="aucun_element">Aucun Atelier(s) crée(s).</p>');
            }
        });
    });

});

var test = function (id) {
    var parseId = id.split('-');
    var nex = parseId[1];
    var nat = parseId[2];
    var iat = $('#id_atelier_tpn_' + nat).val();
    var coords = $('#coord_qcm_' + nex + '_' + nat).val().split(',');
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $.ajax({
        url: host + '/admin/qcm/new',
        type: 'post',
        data: {x: coords[0], y: coords[1], type: 'qcm', atelier_tpn_id: iat},
        dataType: 'json',
        success: function(data) {
            localStorage.setItem('GEOVISIT.id_exercice', JSON.stringify(data));
        }
    });
};

//traitement avant brouillon
var nettoyertext = function (contenu) {
    var html = $(contenu);
    html.find('span.erasemove').remove();
    var newstring = html.html();
    if (typeof newstring === 'undefined') {
        return '';
    }
    newstring = newstring.replace(/style="position: relative;" class="sortable"/g, '');
    newstring = newstring.replace(/style="width: 90%; min-height: 50px; border: none; margin-left: auto; margin-right: auto; text-align: center;"/g, '');
    newstring = newstring.replace(/contenteditable="true"/g, '');
    newstring = newstring.replace(/style="width: 90%; min-height: 50px; border: none; margin-left: auto; margin-right: auto; overflow: hidden;"/g, '');

    return newstring;
};

// AU CLIC SUR BLOCS TEXTE : EDITION, BORDER, AJOUT DE LIENS MOUVEMENT/DESTRUCTION
var editionintro = function (editable, _this, type, pour) {

    var move_pour = "";

    if (pour === "qcm_") {
        move_pour = "qcm_exercice";
    } else if (pour === "") {
        move_pour = "intro";
    } else if (pour.indexOf("exercice") !== -1) {
        move_pour = "exercice";
    }

    var id = $(_this).attr('id');

    var color = "";
    if (type === "titre") {
        color = "#f96332";
    } else if (type === "soustitre") {
        color = "green";
    } else if (type === "texte") {
        color = "blue";
    } else if (type === "image") {
        color = "black";
    } else if (type === "video") {
        color = "yellow";
    }

    if (!editable) {
        if (type !== "titre" || type !== "soustitre" || type !== "texte") {
            tmp = _this.text();
            _this.select();
        }

        $('#container_' + move_pour).sortable({
            placeholder: "ui-state-highlight",
            helper: 'clone',
            handle: '.moveicon',
            cursor: 'move'
        });

        _this.css({'width': '90%', 'border-style': 'dashed', 'border-color': color, 'margin-left': 'auto', 'margin-right': 'auto'});
        $('#liensinputs_' + pour + id).show();

        _this.blur(function () {
            _this.css({'width': '90%', 'border': 'none', 'margin-left': 'auto', 'margin-right': 'auto'});
            $('#liensinputs_' + pour + id).hide();
            editable = false;
            if (move_pour === "intro") {
                var intro_tp = $("#intro_tp");
                intro_tp.val(nettoyertext($('#container_intro').clone()));
                intro_tp.change();
                $("#intro_tp_contenu_admin").val($('#container_intro').html()).change();
            }
        });
    }
    editable = true;
    return false;
};

// APRES CLIC SUR VOIR APERCU DE L'INTRO MISE EN FORME COMME EN FRONT
var voirContainer = function (pour) {
    var html = $('#container_' + pour).html();

    if (html !== "" || html !== undefined) {
        var htmlmodif = prepareIntro(html, pour);
        $("#popup_sites_intro").removeClass('dialog_operations').addClass('active');
        $("#popup_intro").empty().append(htmlmodif);
        $("#popup_intro").removeClass('contenu-cacher').addClass('active');
    }
    return false;
};

var voirContainer_exercice = function (id, pour) {
    var html = $(id).html();
    var htmlmodif = prepareIntro(html, pour);
    $("#popup_sites_intro").removeClass('dialog_operations').addClass('active');
    $("#popup_intro").empty().append(htmlmodif);
    $("#popup_intro").removeClass('contenu-cacher').addClass('active');
    return false;
};

// APRES CLIC SUR BIN DESTRUCTION DU BLOC
var supprContainer = function (id, idliens) {
    $("#" + id).parent().next('br').remove();
    $("#" + id).parent().remove();
    return false;
};

// APRES CLIC SUR ARROW REORGANISATION DES BLOCS
var moveContainer = function (id, idliens, pour) {
    $('#container_' + pour).sortable({
        placeholder: "ui-state-highlight",
        helper: 'clone'
    });
    $('#container_' + pour).sortable("option", "disabled", false);

    return false;
};

var stopMoveContainer = function (id, idliens, pour) {
    $('#container_' + pour).sortable('disable');
    return false;
};

// MODIFIER CSS DES INTROS POUR LE FRONT
var prepareIntro = function (html, depuis) {
    var suffixe = "";

    if (depuis === "exercice") {
        suffixe = "_exercice";
    } else if (depuis === "intro") {
        suffixe = "_sommaire";
    }
    var temp = html;

    // ENLEVER erasemove
    if (temp !== "" || temp !== undefined) {
        if (temp.indexOf("input_titre" + suffixe + " sortable") !== -1) {
            var pattern = "input_titre" + suffixe + " sortable";
            var reg = new RegExp(pattern, "g");
            temp = temp.replace(reg, "popup_intro_titre");
        }
        if (temp.indexOf("input_soustitre" + suffixe + " sortable") !== -1) {
            var pattern = "input_soustitre" + suffixe + " sortable";
            var reg = new RegExp(pattern, "g");
            temp = temp.replace(reg, "popup_intro_sstitre");
        }
        if (temp.indexOf("input_texte" + suffixe + " sortable") !== -1) {
            var pattern = "input_texte" + suffixe + " sortable";
            var reg = new RegExp(pattern, "g");
            temp = temp.replace(reg, "popup_intro_texte");
        }
        if (temp.indexOf('style="width:90%; border:none; margin-left:auto; margin-right:auto; text-align:center;" align="middle"') !== -1) {
            var pattern = 'style="width:90%; border:none; margin-left:auto; margin-right:auto; text-align:center;" align="middle"';
            var reg = new RegExp(pattern, "g");
            temp = temp.replace(reg, "");
        }
        if (temp.indexOf('contentEditable="true"') !== -1) {
            var pattern = 'contentEditable="true"';
            var reg = new RegExp(pattern, "g");
            temp = temp.replace(reg, "");
        }
        if (temp.indexOf('class="sortable"') !== -1) {
            var pattern = 'class="sortable"';
            var reg = new RegExp(pattern, "g");
            temp = temp.replace(reg, "");
        }
        return temp;
    } else {
        return "";
    }
};

var type_envoye = "";
var edition = false;
var placer_exercices = function (id_button, atelier_id, nom_atelier) {
    /*EDITEUR PLACEMENT EXERCICES*/

    $(document).ready(function () {
        var id_container_placement = '#container_placement_exercice_' + atelier_id;
        var place_texte_exercice = "";
        var id_lien_move = "";
        var id_lien_suppr = "";
        var nbdutypeexercice = "";
        var compteur = $(id_container_placement).children().length - 1;
        var nb_textes_exercices = $(".place_texte_exercice").length;
        var nb_qcm_exercices = $(".place_qcm_exercice").length;
        var nb_photo_exercices = $(".place_photo_exercice").length;
        var nb_video_exercices = $(".place_video_exercice").length;

        //ATELIER ID A RAJOUTER CHAQUE EXERCICE
        //      PREPARATION DE L'ACTION POUR LES BOUTONS TEXTES EXERCICES
        if (id_button.indexOf("texte-exercice-button") !== -1) {
            nbdutypeexercice = "";
            compteur++;
            nbdutypeexercice = nb_textes_exercices + 1;

            var ajouts = '<div id="blocsliens_texte_' + nbdutypeexercice + '_exercice_' + compteur + '_atelier_' + atelier_id + '" style="display:inline; float:left; margin-left:20px;"><span id="liensinputs_content_texte_' + nbdutypeexercice + '_exercice_' + compteur + '_atelier_' + atelier_id + '" class="erasemove_exercices"><a href="#" id="lienmove_content_texte_' + nbdutypeexercice + '_exercice_' + compteur + '_atelier_' + atelier_id + '" class="lien-move-constructeur" style="display:none;"><div class="moveicon_exercice"></div></a></br><a href="#" id="liensup_content_texte_' + nbdutypeexercice + '_exercice_' + compteur + '_atelier_' + atelier_id + '" class="lien-suppression-constructeur" style="display:none;"><div class="suppricon_exercice"></div></a></span></div>';
            place_texte_exercice = '<div id="content_texte_' + nbdutypeexercice + '_exercice_' + compteur + '_atelier_' + atelier_id + '" style="width:90px; height:90px;" class="sortable dragelement"><div class="infos_exercices" style="display:inline; float:left; margin:10px;"><div id="place_texte_' + nbdutypeexercice + '_exercice_' + compteur + '_atelier_' + atelier_id + '" class="place_texte_exercice sortable" style="width:41px; height:41px; background-image: url(\'' + host + '/css/img/ICONE_TEXTE_TRANSPARENT_DECALE.png\'); background-repeat: no-repeat;"></div><div style="color:#f96332; font-family: \'Lato\', sans-serif; font-weight: 700; clear:both;">Exercice ' + compteur + '</div></div>' + ajouts + '</div>';

            id_content = "content_texte_" + nbdutypeexercice + "_exercice_" + compteur + "_atelier_" + atelier_id + "";
            id_lien_move = "lienmove_content_texte_" + nbdutypeexercice + "_exercice_" + compteur + "_atelier_" + atelier_id + "";
            id_lien_suppr = "liensup_content_texte_" + nbdutypeexercice + "_exercice_" + compteur + "_atelier_" + atelier_id + "";

            type_envoye = "texte";
            ajax_ajout_exercice(atelier_id, nom_atelier, type_envoye, compteur, nbdutypeexercice);
        }

        //      PREPARATION DE L'ACTION POUR LES BOUTONS QCM EXERCICES
        if (id_button.indexOf("qcm-exercice-button") !== -1) {
            nbdutypeexercice = "";
            compteur++;
            nbdutypeexercice = nb_qcm_exercices + 1;

            var ajouts = '<div id="blocsliens_qcm_' + nbdutypeexercice + '_exercice_' + compteur + '_atelier_' + atelier_id + '" style="display:inline; float:left; margin-left:20px;"><span id="liensinputs_content_qcm_' + nbdutypeexercice + '_exercice_' + compteur + '_atelier_' + atelier_id + '" class="erasemove_exercices"><a href="#" id="lienmove_content_qcm_' + nbdutypeexercice + '_exercice_' + compteur + '_atelier_' + atelier_id + '" class="lien-move-constructeur" style="display:none;"><div class="moveicon_exercice"></div></a></br><a href="#" id="liensup_content_qcm_' + nbdutypeexercice + '_exercice_' + compteur + '_atelier_' + atelier_id + '"  class="lien-suppression-constructeur" style="display:none;"><div class="suppricon_exercice"></div></a></span></div>';
            place_texte_exercice = '<div id="content_qcm_' + nbdutypeexercice + '_exercice_' + compteur + '_atelier_' + atelier_id + '" style="width:90px; height:90px;" class="sortable dragelement"><div class="infos_exercices" style="display:inline; float:left; margin:10px;"><div id="place_qcm_' + nbdutypeexercice + '_exercice_' + compteur + '_atelier_' + atelier_id + '" class="place_qcm_exercice sortable" style="width:41px; height:41px; background-image: url(\'' + host + '/css/img/ICONE_QCM_TRANSPARENT_DECALE.png\'); background-repeat: no-repeat;"></div><div style="color:#f96332; font-family: \'Lato\', sans-serif; font-weight: 700; clear:both;">Exercice ' + compteur + '</div></div>' + ajouts + '</div>';

            id_content = "content_qcm_" + nbdutypeexercice + "_exercice_" + compteur + "_atelier_" + atelier_id + "";
            id_lien_move = "lienmove_content_qcm_" + nbdutypeexercice + "_exercice_" + compteur + "_atelier_" + atelier_id + "";
            id_lien_suppr = "liensup_content_qcm_" + nbdutypeexercice + "_exercice_" + compteur + "_atelier_" + atelier_id + "";

            type_envoye = "qcm";
            ajax_ajout_exercice(atelier_id, nom_atelier, type_envoye, compteur, nbdutypeexercice);
        }

        //      PREPARATION DE L'ACTION POUR LES BOUTONS PHOTO EXERCICES
        if (id_button.indexOf("photo-exercice-button") !== -1) {
            nbdutypeexercice = "";
            compteur++;
            nbdutypeexercice = nb_photo_exercices + 1;

            var ajouts = '<div id="blocsliens_photo_' + nbdutypeexercice + '_exercice_' + compteur + '_atelier_' + atelier_id + '" style="display:inline; float:left; margin-left:20px;"><span id="liensinputs_content_photo_' + nbdutypeexercice + '_exercice_' + compteur + '_atelier_' + atelier_id + '" class="erasemove_exercices"><a href="#" id="lienmove_content_photo_' + nbdutypeexercice + '_exercice_' + compteur + '_atelier_' + atelier_id + '" class="lien-move-constructeur" style="display:none;"><div class="moveicon_exercice"></div></a></br><a href="#" id="liensup_content_photo_' + nbdutypeexercice + '_exercice_' + compteur + '_atelier_' + atelier_id + '"  class="lien-suppression-constructeur" style="display:none;"><div class="suppricon_exercice"></div></a></span></div>';
            place_texte_exercice = '<div id="content_photo_' + nbdutypeexercice + '_exercice_' + compteur + '_atelier_' + atelier_id + '" style="width:90px; height:90px;" class="sortable dragelement"><div class="infos_exercices" style="display:inline; float:left; margin:10px;"><div id="place_photo_exercice_' + nbdutypeexercice + '_atelier_' + atelier_id + '" class="place_photo_exercice sortable" style="width:51px; height:41px; background-image: url(\'' + host + '/css/img/ICONE_PHOTO_TRANSPARENT_DECALE.png\'); background-repeat: no-repeat;"></div><div style="color:#f96332; font-family: \'Lato\', sans-serif; font-weight: 700; clear:both;">Exercice ' + compteur + '</div></div>' + ajouts + '</div>';

            id_content = "content_photo_" + nbdutypeexercice + "_exercice_" + compteur + "_atelier_" + atelier_id + "";
            id_lien_move = "lienmove_content_photo_" + nbdutypeexercice + "_exercice_" + compteur + "_atelier_" + atelier_id + "";
            id_lien_suppr = "liensup_content_photo_" + nbdutypeexercice + "_exercice_" + compteur + "_atelier_" + atelier_id + "";

            type_envoye = "photo";
            ajax_ajout_exercice(atelier_id, nom_atelier, type_envoye, compteur, nbdutypeexercice);
        }

        //      PREPARATION DE L'ACTION POUR LES BOUTONS VIDEO EXERCICES
        if (id_button.indexOf("video-exercice-button") !== -1) {
            nbdutypeexercice = "";
            compteur++;
            nbdutypeexercice = nb_video_exercices + 1;

            var ajouts = '<div id="blocsliens_video_' + nbdutypeexercice + '_exercice_' + compteur + '_atelier_' + atelier_id + '" style="display:inline; float:left; margin-left:20px;"><span id="liensinputs_content_video_' + nbdutypeexercice + '_exercice_' + compteur + '_atelier_' + atelier_id + '" class="erasemove_exercices"><a href="#" id="lienmove_content_video_' + nbdutypeexercice + '_exercice_' + compteur + '_atelier_' + atelier_id + '" class="lien-move-constructeur" style="display:none;"><div class="moveicon_exercice"></div></a></br><a href="#" id="liensup_content_video_' + nbdutypeexercice + '_exercice_' + compteur + '_atelier_' + atelier_id + '"  class="lien-suppression-constructeur" style="display:none;"><div class="suppricon_exercice"></div></a></span></div>';
            place_texte_exercice = '<div id="content_video_' + nbdutypeexercice + '_exercice_' + compteur + '_atelier_' + atelier_id + '" style="width:90px; height:90px;" class="sortable dragelement"><div class="infos_exercices" style="display:inline; float:left; margin:10px;"><div id="place_video_exercice_' + nbdutypeexercice + '_atelier_' + atelier_id + '" class="place_video_exercice sortable" style="width:43px; height:41px; background-image: url(\'' + host + '/css/img/ICONE_VIDEO_TRANSPARENT_DECALE.png\'); background-repeat: no-repeat;"></div><div style="color:#f96332; font-family: \'Lato\', sans-serif; font-weight: 700; clear:both;">Exercice ' + compteur + '</div></div>' + ajouts + '</div>';

            id_content = "content_video_" + nbdutypeexercice + "_exercice_" + compteur + "_atelier_" + atelier_id + "";
            id_lien_move = "lienmove_content_video_" + nbdutypeexercice + "_exercice_" + compteur + "_atelier_" + atelier_id + "";
            id_lien_suppr = "liensup_content_video_" + nbdutypeexercice + "_exercice_" + compteur + "_atelier_" + atelier_id + "";

            type_envoye = "video";
            ajax_ajout_exercice(atelier_id, nom_atelier, type_envoye, compteur, nbdutypeexercice);
        }

        //      AJOUT DES ICONES A DEPLACER DANS LE CONTENEUR
        $(id_container_placement).append(place_texte_exercice);

        //      L'ICONE DEVIENT DRAGGABLE AU CLIC SUR L'ICONE ARROW, SINON SUPPRIME LE BLOC AU CLIC SUR L'ICONE POUBELLE
        $('.dragelement').each(function () {
            var id_clicked = $(this).attr('id');
            var tmp_edition = 'off';

            $(this).click(function () {
                var clicked_id = $(this).attr('id');
                var arr_elements = clicked_id.split("_");
                var nbdutypeexercice_action = arr_elements[2];
                var atelier_id_action = arr_elements[6];
                var type_envoye_action = arr_elements[1];
                var compteur_action = arr_elements[4];
                var tmp_edition = 'off';
                var edition = false;

                tmp_edition = actionsExercices(edition, "#" + clicked_id, atelier_id_action, nbdutypeexercice_action, type_envoye_action, compteur_action, id_lien_move, id_lien_suppr);

                if (tmp_edition === 'off') {
                    edition = false;
                }
                if (tmp_edition === 'on') {
                    edition = true;
                }

                return false;
            });

            $(id_container_placement).click(function (e) {
                if (e.target.id !== '#' + id_clicked || !$(e.target).parents("#" + id_clicked).size()) {
                    $(id_container_placement + " div.dragelement").each(function () {
                        $(this).css('border', 'none');
                        if ($(this).data('ui-draggable')) {
                            $(this).draggable("destroy");
                        }

                        $('#lienmove_' + this.id).hide();
                        $('#liensup_' + this.id).hide();
                    });

                    tmp_edition === 'off';
                    edition = false;
                }
                return false;
            });
        });

        //      SUPPRESSION DES EXERCICES CHOISIS
        $('.lien-suppression-constructeur').each(function () {
            $(this).click(function () {
                var id_link = $(this).attr('id');
                edition = true;

                $("#" + id_content).css('border', 'none');
                $("#" + id_content).draggable("destroy");

                document.getElementById($('#' + id_content).parent().attr('id')).removeEventListener('mousemove', monitorPosition);

                var arr_str = id_link.split('_');
                var typeaenlever = arr_str[2];
                var id_exercice = "#id_exercice_" + arr_str[5] + "_" + atelier_id;

                effacer_exercice("#" + id_content, typeaenlever, nbdutypeexercice, atelier_id, id_exercice);

                $('#exercice_' + typeaenlever + '_' + compteur + '').remove();
                if (!$('#receptacle-exercices_' + atelier_id + "").length > 0) {
                    $('#receptacle-exercices_' + atelier_id + "").append('<p class="aucun_element">Aucun Atelier(s) crée(s).</p>');
                }

                if (type_envoye === "texte") {
                    nb_textes_exercices--;
                } else if (type_envoye === "qcm") {
                    nb_qcm_exercices--;
                } else if (type_envoye === "photo") {
                    nb_photo_exercices--;
                } else if (type_envoye === "video") {
                    nb_video_exercices--;
                }

                if (!compteur > 0) {
                    compteur = 0;
                } else {
                    compteur--;
                }
            });
        });
        return false;
    });
};

var actionsExercices = function (edition, id_blocdrag, atelier_id, nbdutypeexercice, type_envoye, compteur) {
    var color = "";

    if (!edition) {

        if (type_envoye === "texte") {
            color = "#f96332";
        } else if (type_envoye === "video") {
            color = "green";
        } else if (type_envoye === "qcm") {
            color = "blue";
        } else if (type_envoye === "photo") {
            color = "red";
        }

        if (id_blocdrag) {
            $(id_blocdrag).css('border', '2px dashed ' + color + '');
            var blocdrag = id_blocdrag.replace("#", "");

            $('#lienmove_' + blocdrag).show();
            $('#liensup_' + blocdrag).show();
            $(id_blocdrag).draggable({containment: 'parent'});
            $(id_blocdrag).css('cursor', 'move');

            $(id_blocdrag).parent().mousemove(monitorPosition(id_blocdrag, atelier_id, type_envoye, compteur));
        }
        editions = true;
        return 'on';
    }
    return false;
};

var monitorPosition = function (id_blocdrag, atelier_id, type, compteur) {
    var bloc_offset = $(id_blocdrag).offset();
    var parentOffset = $(id_blocdrag).parent().offset();
    var mousex = bloc_offset.left - parentOffset.left + 40;
    var mousey = bloc_offset.top - parentOffset.top + 40;
    var vmin = Number($('#vmin_atelier_' + atelier_id).val());
    var vmax = Number($('#vmax_atelier_' + atelier_id).val());
    var hmin = Number($('#hmin_atelier_' + atelier_id).val());
    var hmax = Number($('#hmax_atelier_' + atelier_id).val());
    var relx = (((mousex * (hmax - hmin)) / $(id_blocdrag).parent().width()) + hmin);
    var rely = (((mousey * (vmax - vmin)) / $(id_blocdrag).parent().height()) + vmin);

    $(id_blocdrag).attr('title', relx + ',' + rely);
    $('input[name="coord[' + type + '][' + compteur + '][' + atelier_id + ']"]').val(relx + ',' + rely);
};

var stopDrag_exercice = function (id_blocdrag) {
    $(id_blocdrag).draggable("destroy");
};

var effacer_exercice = function (ideffacer, type_exercice, numeroexercice, atelier_id, id_exercice) {
    $(ideffacer).remove();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: host + '/admin/exercicefface',
        type: "post",
        data: {'idatelier': atelier_id, 'type': type_exercice, 'numero_exercice': numeroexercice, 'id_exercice': $(id_exercice).val()},
        dataType: "json",
        success: function (data) {
            $('#nbre_exercice_modifie').html(data.nbre);
        }
    });
};

var observer = new MutationObserver(function (mutations) {
    var newNodes = mutations[0].addedNodes;
    var container_id = null;
    if (newNodes !== null) {
        if (mutations[0].type === 'childList') {
            if (mutations[0].target.id !== '') {
                container_id = mutations[0].target.id;
            } else {
                return false;
            }
        } else if (mutations[0].type === 'characterData') {
            if (mutations[0].target.parentNode === null) {
                return false;
            }
            if (mutations[0].target.parentNode.id !== '') {
                container_id = $('#' + mutations[0].target.parentNode.id).parent().parent().attr('id');
            } else {
                container_id = $('#' + mutations[0].target.parentNode.parentNode.id).parent().parent().attr('id');
            }
        }
        saveChange(container_id);
    }
});

var observerDrag = new MutationObserver(function (mutations) {
    var newNodes = mutations[0].addedNodes;
    if (newNodes !== null) {
        if (mutations[0].type === 'attributes') {
            var container_id = 'container_exercice_' + mutations[0].target.id.split('_')[4] + '_atelier_' + mutations[0].target.id.split('_')[6];
        } else if (mutations[0].type === 'childList') {
            var container_id = 'container_exercice_' + mutations[0].addedNodes[0].id.split('_')[4] + '_atelier_' + mutations[0].addedNodes[0].id.split('_')[6];
        }
        saveChange(container_id);
    }
});

var saveChange = function (container_id) {
    var num = container_id.split('_');
    var indice = $("input[name='id_atelier_tpn_" + num[num.length - 1] + "']").val();
    if (!ateliers.hasOwnProperty(indice)) {
        ateliers[indice] = {};
    }
    var details_atelier = {};

    details_atelier['id_exercice'] = $('#' + container_id).parent().parent().parent().find($("input[name^='id_exercice']")).val();
    details_atelier['id_exercice_retour'] = $('#' + container_id).parent().parent().parent().find($("input[name^='id_exercice']")).attr('id');
    details_atelier['type_exercice'] = $('#' + container_id).parent().parent().parent().find($("input[name^='type_exercice']")).val();
    details_atelier['coord'] = $('#' + container_id).parent().parent().find("input[name^='coord']").val();
    details_atelier['contenu_exercice'] = nettoyertext($('#' + container_id).clone());
    details_atelier['contenu_admin_exercice'] = $('#' + container_id).blur().html();

    ateliers[indice][$('#' + container_id).parent().parent().parent().find($("input[name^='numero_exercice']")).val()] = details_atelier;
    exercice_a_change = true;
};

var config = {
    childList: true,
    characterData: true,
    subtree: true
};

var configDrag = {
    attributes: true,
    attributeFilter: ['style']
};

var ajax_ajout_exercice = function (atelier_id, nom_atelier, type_envoye, compteur, nbdutypeexercice) {
    $.ajax({
        url: host + '/admin/creerateliers',
        type: "post",
        data: {'idatelier': atelier_id, 'nom_atelier': nom_atelier, 'typecree': type_envoye, 'nb_exercice': compteur, 'nbdutypeexercice': nbdutypeexercice, '_token': $('input[name=_token]').val()},
        dataType: "json",
        success: function (data) {
            $('#receptacle-exercices_' + atelier_id + "").find('.aucun_element').remove();
            $('#receptacle-exercices_' + atelier_id + "").append(data.maquettes);
            $('#nbre_exercice_modifie').html(data.nbre);
            if (data.type !== 'qcm') {
                observer.observe($('#container_exercice_' + compteur + '_atelier_' + atelier_id)[0], config);
            }
        }
    });
};

var spanajout = function (pour, id) {
    return ('<span id="liensinputs_' + pour + id + '" class="erasemove" style="display:none;"><div class="moveicon"></div><br><a href="#" id="liensup_' + pour + id + '" onclick="javascript:supprContainer(\'' + id + '\', \'#liensinputs_' + pour + '' + id + '\'); return false;"><div class="suppricon"></div></a></span>');
};

var clickAjout = function (id_button) {
    var bouton_editeur = $('#' + id_button).attr('id');
    var ids = bouton_editeur.split('-');
    var nex = ids[4];
    var nat = ids[7];

    if (bouton_editeur.indexOf('button-titres-exercice') !== -1) {

        /* AJOUT D'UN TITRE */

        var nb = $('.input_titre_exercice').length;
        nb++;
        var bloc = '<div style="position: relative;" class="sortable"><div id="titre_exercice_' + nex + '_' + nb + '_atelier_' + nat + '" class="input_titre_exercice sortable" style="width:90%; min-height:50px; border:none; margin-left:auto; margin-right:auto;" contentEditable="true">TITRE A CHANGER</div></div>';

        $('#container_exercice_' + nex + '_atelier_' + nat).append(bloc);
        $('#titre_exercice_' + nex + '_' + nb + '_atelier_' + nat).append(spanajout('exercice_', 'titre_exercice_' + nex + '_' + nb + '_atelier_' + nat));

        $('.input_titre_exercice').each(function () {
            $(this).click(function () {
                editionintro_exercice(false, $(this), 'titre', 'exercice_', '#container_exercice_' + nex + '_atelier_' + nat);
                return false;
            });
        });

    } else if (bouton_editeur.indexOf('soustitre-exercice') !== -1) {

        /* AJOUT SOUSTITRE */

        var nb = $('.input_soustitre_exercice').length;
        nb++;
        var bloc = '<div style="position: relative;" class="sortable"><div id="soustitre_exercice_' + nex + '_' + nb + '_atelier_' + nat + '" class="input_soustitre_exercice sortable" style="width:90%; min-height:50px; border:none; margin-left:auto; margin-right:auto;" contentEditable="true">Sous titre a changer</div></div>';

        $('#container_exercice_' + nex + '_atelier_' + nat).append(bloc);
        $('#soustitre_exercice_' + nex + '_' + nb + '_atelier_' + nat).append(spanajout('exercice_', 'soustitre_exercice_' + nex + '_' + nb + '_atelier_' + nat));

        $('.input_soustitre_exercice').each(function () {
            $(this).click(function () {
                editionintro_exercice(false, $(this), 'soustitre', 'exercice_', '#container_exercice_' + nex + '_atelier_' + nat);
                return false;
            });
        });

    } else if (bouton_editeur.indexOf('texte-exercice') !== -1) {

        /* AJOUT DE TEXTE */

        var nb = $('.input_texte_exercice').length;
        nb++;
        var bloc = '<div style="position: relative;" class="sortable"><div id="texte_exercice_' + nex + '_' + nb + '_atelier_' + nat + '" class="input_texte_exercice sortable" style="width:90%; min-height:50px; border:none; margin-left:auto; margin-right:auto;" contentEditable="true">Texte a changer</div></div>';

        $('#container_exercice_' + nex + '_atelier_' + nat).append(bloc);
        $('#texte_exercice_' + nex + '_' + nb + '_atelier_' + nat).append(spanajout('exercice_', 'texte_exercice_' + nex + '_' + nb + '_atelier_' + nat));

        $('.input_texte_exercice').each(function () {
            $(this).click(function () {
                editionintro_exercice(false, $(this), 'texte', 'exercice_', '#container_exercice_' + nex + '_atelier_' + nat);
                return false;
            });
        });
    } else if (bouton_editeur.indexOf('photo-exercice') !== -1) {
        showUploadExercicePopup('img', nex, nat);
    } else if (bouton_editeur.indexOf('video-exercice') !== -1) {
        showUploadExercicePopup('vid', nex, nat);
    }

    return false;
};

var editionintro_exercice = function (editable, _this, type, pour, container) {
    var id = $(_this).attr('id');
    var color = null;

    switch (type) {
        case 'titre':
            color = '#F96332';
            break;
        case 'soustitre':
            color = 'green';
            break;
        case 'texte':
            color = 'blue';
            break;
        case 'image':
            color = 'black';
            break;
        case 'video':
            color = 'yellow';
            break;
    }

    if (!editable) {
        if (type !== 'titre' || type !== 'soustitre' || type !== 'texte') {
            tmp = _this.text();
            _this.select();
        }

        $(container).sortable({
            placeholder: 'ui-state-highlight',
            helper: 'clone',
            handle: '.moveicon',
            cursor: 'move'
        });

        _this.css({
            width: '90%',
            border: 'dashed',
            'border-color': color,
            'margin-left': 'auto',
            'margin-right': 'auto'
        });
        $('#liensinputs_' + pour + id).show();

        _this.blur(function () {
            _this.css({
                width: '90%',
                border: 'none',
                'margin-left': 'auto',
                'margin-right': 'auto'
            });
            $('#liensinputs_' + pour + id).hide();
            editable = false;
        });
        editable = true;
    }
    return false;
};

var moveContainer_exercice = function (id, idliens, pour) {
    $(pour).sortable({
        placeholder: 'ui-state-highlight',
        helper: 'clone'
    });
    $(pour).sortable('option', 'disabled', false);
    return false;
};

var stopMoveContainer_exercice = function (id, idliens, pour) {
    $(pour).sortable('disable');
    return false;
};

var supprContainer_exercice = function (id, idliens) {
    $('#' + id).parent().next('br').remove();
    $('#' + id).parent().remove();
    return false;
};

var ajoutIconExercice = function (id, type, nbtype, nbex, posx, posy) {
    var icon = '';
    var iconw = 41;
    switch (type) {
        case 'texte':
            icon = host + '/css/img/ICONE_TEXTE_TRANSPARENT_DECALE.png';
            break;
        case 'photo':
            icon = host + '/css/img/ICONE_PHOTO_TRANSPARENT_DECALE.png';
            iconw = 51;
            break;
        case 'video':
            icon = host + '/css/img/ICONE_VIDEO_TRANSPARENT_DECALE.png';
            iconw = 43;
            break;
        case 'qcm':
            icon = host + '/css/img/ICONE_QCM_TRANSPARENT_DECALE.png';
            break;
    }
    var ajouts = '<div id="blocsliens_' + type + '_' + nbtype + '_exercice_' + nbex + '_atelier_' + id + '" style="display:inline; float:left; margin-left:20px;"><span id="liensinputs_content_' + type + '_' + nbtype + '_exercice_' + nbex + '_atelier_' + id + '" class="erasemove_exercices"><a href="#" id="lienmove_content_' + type + '_' + nbtype + '_exercice_' + nbex + '_atelier_' + id + '" class="lien-move-constructeur" style="display:none;"><div class="moveicon_exercice"></div></a></br><a href="#" id="liensup_content_' + type + '_' + nbtype + '_exercice_' + nbex + '_atelier_' + id + '" class="lien-suppression-constructeur" style="display:none;"><div class="suppricon_exercice"></div></a></span></div>';
    var bloc_exercice = '<div id="content_' + type + '_' + nbtype + '_exercice_' + nbex + '_atelier_' + id + '" style="width:90px; height:90px;" class="sortable dragelement"><div class="infos_exercices" style="display:inline; float:left; margin:10px;"><div id="place_' + type + '_' + nbtype + '_exercice_' + nbex + '_atelier_' + id + '" class="place_' + type + '_exercice sortable" style="width:' + iconw + 'px; height:41px; background-image: url(\'' + icon + '\'); background-repeat: no-repeat;"></div><div style="color:#f96332; font-family: \'Lato\', sans-serif; font-weight: 700; clear:both;">Exercice ' + nbex + '</div></div>' + ajouts + '</div>';
    $('#container_placement_exercice_' + id).append(bloc_exercice);

    setTimeout(function () {
        var bloc_drag = $('#content_' + type + '_' + nbtype + '_exercice_' + nbex + '_atelier_' + id);
        var parentOffset = $('#container_placement_exercice_' + id).offset();
        var vmin = Number($('#vmin_atelier_' + id).val());
        var vmax = Number($('#vmax_atelier_' + id).val());
        var hmin = Number($('#hmin_atelier_' + id).val());
        var hmax = Number($('#hmax_atelier_' + id).val());
        var relx = (((posx - hmin) * bloc_drag.parent().width()) / (hmax - hmin));
        var mousex = parentOffset.left + relx - 40;
        var rely = (((posy - vmin) * bloc_drag.parent().height()) / (vmax - vmin));
        var mousey = parentOffset.top + rely - 40;

        bloc_drag.offset({top: mousey, left: mousex});
        bloc_drag.attr('title', posx + ',' + posy);

        $('input[name="coord[' + type + '][' + nbex + '][' + id + ']"]').val(posx + ',' + posy);
    }, 6000);

    $('#content_' + type + '_' + nbtype + '_exercice_' + nbex + '_atelier_' + id).click(function () {
        actionsExercices(false, '#' + $(this).attr('id'), id, nbtype, type, nbex);
        return false;
    });
};


