var img = false;
var vid = false;

$(document).ready(function () {

    $('.fermerpopup_over_exercices').each(function () {
        $(this).click(function () {
            if ($(this).hasClass('fleche_gauche_table')) {
                if ($('#popup_dossier_apercu_exercice').hasClass('contenu-cacher')) {
                    $(this).parent().parent().removeClass('active').addClass('contenu-cacher');
                    $(this).parent().parent().parent().removeClass('active_over').addClass('contenu-cacher');
                    $('#popup_exercice_upload').removeClass('dialog_operations').addClass('active');
                    $('#contenus_popup_upload_exercice').removeClass('contenu-cacher').addClass('active');
                } else if ($('#popup_dossier_contenu_exercice').hasClass('contenu-cacher')) {
                    $('#popup_dossier_apercu_exercice').removeClass('active').addClass('contenu-cacher');
                    $('#popup_dossier_contenu_exercice').removeClass('contenu-cacher').addClass('active');
                }
            } else {
                $(this).parent().parent().removeClass('active').addClass('contenu-cacher');
                $(this).parent().parent().parent().removeClass('active_over').addClass('contenu-cacher');
                $('#popup_exercice_upload').removeClass('dialog_operations').addClass('active');
                $('#contenus_popup_upload_exercice').removeClass('contenu-cacher').addClass('active');
            }
        });
    });

    $('.fermerpopup_exercices').each(function () {
        $(this).click(function () {
            $(this).parent('.active').removeClass('active').addClass('contenu-cacher');
            $(this).parent().parent().parent('.active').removeClass('active').addClass('contenu-cacher');
        });
    });

    var spanajoutforupload = function (pour, id) {
        return ('<span id="liensinputs_' + pour + id + '" class="erasemove" style="display: none;"><div class="moveicon"></div><br><a href="#" id="liensup_' + pour + id + '" onclick="javascript:supprContainer(\'' + id + '\', \'#liensinputs_' + pour + id + '\'); return false;"><div class="suppricon"></div></a></span>');
    };

    $('.liens_upload').each(function () {
        $(this).click(function () {
            if ($(this).attr('id') === 'photo-qcm-description-button' || $(this).attr('id') === 'video-qcm-description-button') {
                if ($(this).hasClass('photo')) {
                    showUploadExercicePopup('img');
                }
                if ($(this).hasClass('video')) {
                    showUploadExercicePopup('vid');
                }
            } else {
                $("#popup_sites_upload").removeClass('dialog_operations').addClass('active');
                $("#contenus_popup_upload").removeClass('contenu-cacher').addClass('active');

                if ($(this).attr('id') === 'photo-sommaire-button') {
                    img = true;
                    vid = false;
                } else if ($(this).attr('id') === 'video-sommaire-button') {
                    img = false;
                    vid = true;
                }
            }
        });
    });

    // UPLOAD FICHIER DEPUIS PC DRAG AND DROP
    $('#chx_afficher_photo_upload_intro').click(function () {
        $("#popup_sites_over_dragupload").removeClass('dialog_operations_over').addClass('active_over');
        $("#contenus_popup_over_dragupload").removeClass('contenu-cacher').addClass('active');

        type = img ? 'photo' : 'video';

        var zone_drop_intro = new GeovisitUploader(host + '/admin/uploader', "editeur_intro", "#popup_sites_upload", "#contenus_popup_upload", "#popup_sites_over_dragupload", "#contenus_popup_over_dragupload", '#container_intro', type, "");
        zone_drop_intro.initialise();
        delete zone_drop_intro;

        return false;
    });

    // UPLOAD FICHIER DEPUIS PC VIA EXPLORATEUR FICHIERS
    $('#chx_photo_intro').click(function () {
        $('#chx-upload-photo-intro').submit(function (evt) {
            evt.preventDefault();

            $.ajax({
                method: 'POST',
                url: host + '/admin/tpnumerique/uploader',
                data: {
                    file: $('#chx_photo_intro').val(),
                    type_contenu: img ? 'photo' : 'video',
                    depuis: 'editeur_intro',
                    _token: $('input[name=_token]').val()
                },
                dataType: 'json'
            }.done(function (response) {
                $("#popup_sites_over_dragupload").removeClass('active_over').addClass('dialog_operations_over');
                $("#contenus_popup_over_dragupload").removeClass('active').addClass('contenu-cacher');
                $("#popup_sites_upload").removeClass('active').addClass('dialog_operations');
                $("#contenus_popup_upload").removeClass('active').addClass('contenu-cacher');

                if (img) {
                    var nb = $('.input_images_sommaire').length;
                    nb++;
                    var bloc = '<div style="position: relative;" class="sortable"><div id="image_sommaire' + nb + '" class="input_images_sommaire sortable" style="width:90%; border:none; margin-left:auto; margin-right:auto; text-align:center;" contentEditable="true"><img src="' + host + '' + response.msg + '" style="max-width: 98%;" /></div></div></br>';
                } else if (vid) {
                    var nb = $('.input_videos_sommaire').length;
                    nb++;
                    var bloc = '<div style="position: relative;" class="sortable"><div id="video_sommaire' + nb + '" class="input_videos_sommaire sortable" style="width:90%; border:none; margin-left:auto; margin-right:auto; text-align:center;" contentEditable="true"><video width="320" height="240" controls><source src="' + host + '' + response.msg + '" type="video/mp4"></video></div></div></br>';
                }

                $("#container_intro").append(bloc);

                if (img) {
                    $('#image_sommaire' + nb).append(spanajoutforupload("", 'image_sommaire' + nb));
                    $('.input_images_sommaire').each(function ()
                    {
                        $(this).click(function () {
                            var _this = $(this);
                            editionintro(false, _this, "image", "");
                            return false;
                        });
                    });
                } else if (vid) {
                    $('#video_sommaire' + nb).append(spanajoutforupload("", 'video_sommaire' + nb));
                    $('.input_videos_sommaire').each(function () {
                        $(this).click(function () {
                            var _this = $(this);
                            editionintro(false, _this, "video", "");
                            return false;
                        });
                    });
                }
                $("input[name=intro_tp]:hidden").val($('#container_intro').html());
                $("input[name=intro_tp]:hidden").change();
                $("#intro_tp_contenu_admin").val($('#container_intro').html()).change();
            }));
        });
    });

    // UPLOAD FICHIER DEPUIS FICHIERS PERSOS EN LIGNE
    $('#chx_afficher_photo_dossier_intro').on('click', function () {
        type = img ? 'img' : 'vid';
        $.ajax({
            method: 'POST',
            url: host + '/admin/fichiers/type/' + type,
            data: {'_token': $('input[name=_token]').val()},
            dataType: 'json',
            success: function (data) {
                var table = $('#files_table').dataTable({
                    destroy: true,
                    data: data,
                    columns: [
                        {title: 'thumbnail', data: 'thumbnails', targets: 0, visible: img},
                        {title: 'nom', data: 'nom', targets: 1},
                        {title: 'date', data: 'date', targets: 2},
                        {title: 'url', data: 'url', targets: 3, visible: vid, render: function (url, type, row) {
                                return '<a href="' + url + '" target="_blank">' + url + '</a>';
                            }},
                        {title: 'type', data: 'type', targets: 4, visible: false}
                    ],
                    order: [[1, 'asc']],
                    scrollY: '400px',
                    scrollCollapse: false,
                    lengthMenu: [[5, 10, 25, -1], [5, 10, 25, 'All']]
                });

                //ajustement taille cellule header si scroll vertical
                setTimeout(function () {
                    table.fnAdjustColumnSizing();
                }, 10);

                $('#files_table tbody').on('click', 'tr', function () {
                    var row = table.fnGetData(this);

                    if (img) {
                        var contenu = '<div style="margin: 50px;">' + row.thumbnails + '<div style="margin-left: 50px;margin-bottom: 200px;display: inline-block;">' + row.nom + '</div></div>';
                    } else if (vid) {
                        var contenu = '<div style="margin: 50px 50px 200px 50px;">Souhaitez vous utiliser la vidéo suivante : ' + row.nom + ' (cliquez <a href="' + row.url + '" target="_blank">ici</a> pour voir la vidéo)</div>';
                    }

                    $('#popup_dossier_apercu').empty();
                    $('#popup_dossier_apercu').html(contenu + '<div id="bouton_upload_intro" class="row bouton_upload"><br/><br/><div class="bloc-boutons-submits"><a href="#" id="submit_dossierupload" class="lancer fermerpopup submit" style="height:60px; width: 50%; display:block; text-decoration: none; padding-top: 20px;margin: auto;">TERMINER</a></div></div>');
                    $('#popup_dossier_contenu').addClass('contenu-cacher');
                    $('#popup_dossier_apercu').removeClass('contenu-cacher').addClass('active');
                    $(".fleche_gauche_dossier").click(function () {
                        $("#popup_dossier_apercu").removeClass('active').addClass('contenu-cacher');
                        $("#popup_dossier_contenu").removeClass('contenu-cacher').addClass('active');
                    });

                    $('#submit_dossierupload').click(function () {
                        $('#popup_over_dossier').removeClass('active_over').addClass('dialog_operation_over');
                        $('#contenus_popup_over_dossier').removeClass('active').addClass('contenu-cacher');

                        if (img) {
                            var nb = $('.input_images_sommaire').length;
                            nb++;
                            var bloc = '<div style="position: relative;" class="sortable"><div id="image_sommaire' + nb + '" class="input_images_sommaire sortable" style="width:90%; border:none; margin-left:auto; margin-right:auto; text-align:center;" contentEditable="true"><img src="' + row.url + '" style="max-width: 98%;"></div></div></br>';
                        } else if (vid) {
                            var nb = $('.input_videos_sommaire').length;
                            nb++;
                            var bloc = '<div style="position: relative;" class="sortable"><div id="video_sommaire' + nb + '" class="input_videos_sommaire sortable" style="width: 90%;border: medium none;margin-left: auto;margin-right: auto;text-align: center;"><video controls="" width="320" height="240"><source src="' + row.url + '" type="' + row.type + '"></video></div></div><br>';
                        }

                        $('#container_intro').append(bloc);

                        if (img) {
                            $('#image_sommaire' + nb).append(spanajoutforupload("", 'image_sommaire' + nb));
                            $('.input_images_sommaire').each(function () {
                                $(this).click(function () {
                                    var _this = $(this);
                                    editionintro(false, _this, "image", "");
                                    return false;
                                });
                            });
                        } else if (vid) {
                            $('#video_sommaire' + nb).append(spanajoutforupload('', 'video_sommaire' + nb));
                            $('.input_videos_sommaire').each(function () {
                                $(this).click(function () {
                                    var _this = $(this);
                                    editionintro(false, _this, 'video', '');
                                    return false;
                                });
                            });
                        }

                        $("#popup_dossier_apercu").removeClass('active').addClass('contenu-cacher');
                        $("#popup_dossier_contenu").removeClass('contenu-cacher').addClass('active');
                        $("#popup_sites_upload").removeClass('active').addClass('dialog_operations');
                        $("#contenus_popup_upload").removeClass('active').addClass('contenu-cacher');
                        $("input[name=intro_tp]:hidden").val($('#container_intro').html());
                        $("input[name=intro_tp]:hidden").change();
                        $("#intro_tp_contenu_admin").val($('#container_intro').html()).change();
                    });
                    return false;
                });
            },
            error: function (XMLHttpRequest) {
                console.log(XMLHttpRequest);
            }
        });
        $("#popup_over_dossier").removeClass('dialog_operations_over').addClass('active_over');
        $("#contenus_popup_over_dossier").removeClass('contenu-cacher').addClass('active');
        $(".fleche_gauche_dossier").on('click', function () {
            if ($("#popup_dossier_apercu").attr("class") === "row" || $("#popup_dossier_apercu").attr("class") === "row contenu-cacher") {
                $("#popup_over_dossier").removeClass('active_over').addClass('dialog_operations_over');
                $("#contenus_popup_over_dossier").removeClass('active').addClass('contenu-cacher');
            }
        });
        return false;
    });

    // UPLOAD PAR LIENS EXTERNES
    $('#chx_afficher_photo_externe_intro').click(function () {
        $('#popup_sites_over_liensupload').removeClass('dialog_operations_over').addClass('active_over');
        $("#contenus_popup_over_liensupload").removeClass('contenu-cacher').addClass('active');

        $('#submit_lienupload').click(function () {
            var val_input_lien = $("#contenus_popup_over_liensupload").find('input[name="input_lien_upload"]').val();

            if (val_input_lien !== "") {
                $("#popup_sites_upload").removeClass('active').addClass('dialog_operations');
                $("#contenus_popup_upload").removeClass('active').addClass('contenu-cacher');

                if (img) {
                    var nb = $('.input_images_sommaire').length;
                    nb++;
                    var bloc = '<div style="position: relative;" class="sortable"><div id="image_sommaire' + nb + '" class="input_images_sommaire sortable" style="width:90%; border:none; margin-left:auto; margin-right:auto; text-align:center;" contentEditable="true"><img src="' + val_input_lien + '" style="max-width: 98%;"/></div></div></br>';
                } else if (vid) {
                    var nb = $('.input_videos_sommaire').length;
                    nb++;
                    if (val_input_lien.indexOf('youtube') !== -1 || val_input_lien.indexOf('youtu.be') !== -1) {
                        var lien = val_input_lien.split('/');
                        var new_link = 'https://www.youtube-nocookie.com/embed/' + lien[lien.length - 1].replace('watch?v=', '');
                        var bloc = '<div style="position: relative;" class="sortable"><div id="video_sommaire' + nb + '" class="input_videos_sommaire sortable" style="width:90%; border:none; margin-left:auto; margin-right:auto; text-align:center;" contentEditable="true"><iframe width="560" height="315" src="' + new_link + '" frameborder="0" allowfullscreen></iframe></div></div></br>';
                    } else {
                        var bloc = '<div style="position: relative;" class="sortable"><div id="video_sommaire' + nb + '" class="input_videos_sommaire sortable" style="width:90%; border:none; margin-left:auto; margin-right:auto; text-align:center;" contentEditable="true"><video width="320" height="240" controls><source src="' + val_input_lien + '" type="video/mp4"></video></div></div></br>';
                    }
                }

                $("#container_intro").append(bloc);

                if (img) {
                    $('#image_sommaire' + nb).append(spanajoutforupload("", 'image_sommaire' + nb));
                    $('.input_imaages_sommaire').each(function () {
                        $(this).click(function () {
                            var _this = $(this);
                            editionintro(false, _this, "image", "");
                            return false;
                        });
                    });
                } else if (vid) {
                    $('#video_sommaire' + nb).append(spanajoutforupload("", 'video_sommaire' + nb));
                    $('.input_videos_sommaire').each(function () {
                        $(this).click(function () {
                            var _this = $(this);
                            editionintro(false, _this, "video", "");
                            return false;
                        });
                    });
                }
                $("#contenus_popup_over_liensupload").find('input[name="input_lien_upload"]').val('');
                $("input[name=intro_tp]:hidden").val($('#container_intro').html());
                $("input[name=intro_tp]:hidden").change();
                $("#intro_tp_contenu_admin").val($('#container_intro').html()).change();
            }
        });
        return false;

    });

    // UPLOAD PHOTO PROFIL
    $('#photo-profil-lien').click(function () {
        $("#popup_sites_upload").removeClass('dialog_operations').addClass('active');
        $("#contenus_popup_upload").removeClass('contenu-cacher').addClass('active');

        $('#chx_afficher_photo_upload_intro').click(function () {
            $("#popup_sites_over_dragupload").removeClass('dialog_operations_over').addClass('active_over');
            $("#contenus_popup_over_dragupload").removeClass('contenu-cacher').addClass('active');

            var zone_drop_profil = new GeovisitUploader(host + '/admin/uploader', "profil", "#popup_sites_upload", "#contenus_popup_upload", "#popup_sites_over_dragupload", "#contenus_popup_over_dragupload", '#container_intro', 'photo', "");
            zone_drop_profil.initialise();
            delete zone_drop_profil;

            return false;
        });
    });

});

var upload_manuel = function (id, form) {
    if (id === 'chx_photo_intro' && form === 'chx-upload-photo-intro') {

        alert('Le fichier ' + $('#chx_photo_intro').val() + ' vient d\'être téléchargé.');

        var formData = new FormData();
        formData.append('type_contenu', img ? 'photo' : 'video');
        formData.append('depuis', 'editeur_intro');
        formData.append('file', $('#' + form).find('input[type=file]')[0].files[0]);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            url: host + '/admin/uploader',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json'
        }).done(function (response) {
            $("#popup_sites_over_dragupload").removeClass('active_over').addClass('dialog_operations_over');
            $("#contenus_popup_over_dragupload").removeClass('active').addClass('contenu-cacher');

            $("#popup_sites_upload").removeClass('active').addClass('dialog_operations');
            $("#contenus_popup_upload").removeClass('active').addClass('contenu-cacher');

            if (img) {
                var nb = $('.input_images_sommaire').length;
                nb++;
                var bloc = '<div style="position: relative;" class="sortable"><div id="image_sommaire' + nb + '" class="input_images_sommaire sortable" style="width:90%; border:none; margin-left:auto; margin-right:auto; text-align:center;" contentEditable="true"><img src="' + host + '' + response.msg + '" style="max-width: 98%;" /></div></div></br>';
            } else if (vid) {
                var nb = $('.input_videos_sommaire').length;
                nb++;
                var bloc = '<div style="position: relative;" class="sortable"><div id="video_sommaire' + nb + '" class="input_videos_sommaire sortable" style="width:90%; border:none; margin-left:auto; margin-right:auto; text-align:center;" contentEditable="true"><video width="320" height="240" controls><source src="' + host + '' + response.msg + '" type="video/mp4"></video></div></div></br>';
            }

            $('#container_intro').append(bloc);

            if (img) {
                $('#image_sommaire' + nb).append(spanajoutforupload("", 'image_sommaire' + nb));
                $('.input_images_sommaire').each(function () {
                    $(this).click(function () {
                        var _this = $(this);
                        editionintro(false, _this, "image", "");
                        return false;
                    });
                });
            } else if (vid) {
                $('#video_sommaire' + nb).append(spanajoutforupload("", 'video_sommaire' + nb));
                $('.input_videos_sommaire').each(function () {
                    $(this).click(function () {
                        var _this = $(this);
                        editionintro(false, _this, "video", "");
                        return false;
                    });
                });
            }
        });
    }
};

var upload_manuel_profil = function (id, form) {

    if (id === "chx_photo_intro" && form === "chx-upload-photo-intro") {
        var formData = new FormData();
        formData.append('type_contenu', 'photo');
        formData.append('externe', 'non');
        formData.append('depuis', 'profil');

        formData.append('file', $('#' + form).find('input[type=file]')[0].files[0]);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: "POST",
            url: host + '/admin/uploader',
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json"}
        ).done(function (response) {
            $("#popup_sites_over_dragupload").removeClass('active_over').addClass('dialog_operations_over');
            $("#contenus_popup_over_dragupload").removeClass('active').addClass('contenu-cacher');

            $("#popup_sites_upload").removeClass('active').addClass('dialog_operations');
            $("#contenus_popup_upload").removeClass('active').addClass('contenu-cacher');
            location.reload();
        });
    }
};

var showUploadExercicePopup = function (type, nex = null, nat = null) {
    $('#popup_exercice_upload').removeClass('dialog_operations').addClass('active');
    $('#contenus_popup_upload_exercice').removeClass('contenu-cacher').addClass('active');

    document.getElementById('chx_afficher_photo_upload_exercice').removeEventListener('onclick', showDragUploadPopup);
    document.getElementById('chx_afficher_photo_upload_exercice').onclick = function () {
        showDragUploadPopup(type, nex, nat);
    };

    $('#chx_afficher_photo_externe_exercice').on('click', function () {
        /* Affichage popup copy liens */
        $('#contenus_popup_over_liensupload_exercices').find('input[name="input_lien_upload_exercices"]').val('');
        $('#popup_exercices_over_liensupload').removeClass('contenu-cacher').addClass('active_over');
        $('#contenus_popup_over_liensupload_exercices').removeClass('contenu-cacher').addClass('active');
        document.getElementById('submit_lienupload_exercices').removeEventListener('onclick', linkUploadExercice);
        document.getElementById('submit_lienupload_exercices').onclick = function () {
            linkUploadExercice(type, nex, nat);
        };
    });

    document.getElementById('chx_afficher_photo_dossier_exercice').removeEventListener('onclick', pathUploadExercice);
    document.getElementById('chx_afficher_photo_dossier_exercice').onclick = function () {
        pathUploadExercice(type, nex, nat);
    };
};

var showDragUploadPopup = function (type, nex, nat) {
    /* Affichage popup direct upload */
    $('#popup_exercices_over_dragupload').removeClass('contenu-cacher').addClass('active_over');
    $('#contenus_popup_over_dragupload_exercices').removeClass('contenu-cacher').addClass('active');

    if (type === 'img') {
        var tex = 'photo';
    } else if (type === 'vid') {
        var tex = 'video';
    }

    if (nex === null && nat === null) {
        var editeur = 'editeur_qcm';
        var container = '#container-qcm-description';
    } else {
        var editeur = 'editeur_exercice';
        var container = '#container_exercice_' + nex + '_atelier_' + nat;
    }

    var zone_drop_exercice = new GeovisitUploader(host + '/admin/uploader', editeur,
            '#popup_exercice_upload', '#contenus_popup_upload_exercice', '#popup_exercices_over_dragupload',
            '#contenus_popup_over_dragupload_exercices', container, tex, null
            );

    zone_drop_exercice.initialise();

    delete zone_drop_exercice;

    document.getElementById('chx_photo_exercices').removeEventListener('onchange', directUploadExercice);
    document.getElementById('chx_photo_exercices').onchange = function () {
        directUploadExercice(type, nex, nat);
    };
};

var linkUploadExercice = function (type, nex, nat) {
    var val_input_lien = $('#contenus_popup_over_liensupload_exercices').find('input[name="input_lien_upload_exercices"]').val();
    var bloc;

    if (val_input_lien !== '') {
        if (type === 'img') {

            if (nex === null && nat === null) {
                var nb = $('.input-image-qcm-description').length;
                do {
                    nb++;
                } while ($('#image-qcm-description-' + nb).length === true);

                bloc = '<div style="position: relative;" class="sortable"><div id="image-qcm-description-' + nb
                        + '" class="input-image-qcm-description sortable" style="width: 90%;boder: none;margin-left: auto;margin-right: auto;text-align: center;" '
                        + 'contentEditable="true"><img src="' + val_input_lien + '" style="max-width: 98%;"></div></div><br>';
            } else {
                var nb = $('.input_image_exercice').length;
                nb++;

                bloc = '<div style="position: relative;" class="sortable"><div id="image_exercice_'
                        + nex + '_' + nb + '_atelier_' + nat + '" class="input_image_exercice sortable" '
                        + 'style="width: 90%;border: none;margin-left: auto;margin-right: auto;text-align: center;"'
                        + ' contentEditable="true"><img src="' + val_input_lien + '" style="max-width: 98%;"></div></div><br>';
            }

        } else if (type === 'vid') {

            if (nex === null && nat === null) {
                var nb = $('.input-video-qcm-description').length;
                do {
                    nb++;
                } while ($('#video-qcm-description-' + nb).length === 1);
            } else {
                var nb = $('.input_video_exercice').length;
                nb++;
            }

            if (val_input_lien.indexOf('youtube') !== -1 || val_input_lien.indexOf('youtu.be') !== -1) {
                var lien = val_input_lien.split('/');
                var new_link = 'https://www.youtube-nocookie.com/embed/' + lien[lien.length - 1].replace('watch?v=', '');

                if (nex === null && nat === null) {
                    bloc = '<div style="position: relative;" class="sortable"><div id="video-qcm-description-' + nb
                            + '" class="input-video-qcm-description sortable" style="width: 90%;border: none;margin-left: auto;margin-right: auto;text-align: center;" '
                            + 'contentEditable="true"><iframe width="560" height="315" src="' + new_link + '" frameborder="0" allowfullscreen></iframe></div></div><br>';
                } else {
                    bloc = '<div style="position: relative;" class="sortable"><div id="video_exercice_' + nex + '_'
                            + nb + '_atelier_' + nat + '" class="input_video_exercice sortable" style="width:90%; border:none; '
                            + 'margin-left:auto; margin-right:auto; text-align:center;" contentEditable="true">'
                            + '<iframe width="560" height="315" src="' + new_link + '" frameborder="0" allowfullscreen></iframe>'
                            + '</div></div><br>';
                }
            } else {
                if (nex === null && nat === null) {
                    bloc = '<div style="position: relative;" class="sortable"><div id="video-qcm-description-' + nb
                            + '" class="input-video-qcm-description sortable" style="width: 90%;border: none;margin-left: auto;margin-right: auto;text-align: center;" '
                            + 'contentEditable="true"><video width="320" height="240" controls><source src="' + val_input_lien + '" type="video/mp4"></video></div></div><br>';
                } else {
                    bloc = '<div style="position: relative;" class="sortable"><div id="video_exercice_' + nex + '_' + nb
                            + '_atelier_' + nat + '" class="input_video_exercice sortable" style="width:90%; border:none;'
                            + ' margin-left:auto; margin-right:auto; text-align:center;" contentEditable="true">'
                            + '<video width="320" height="240" controls><source src="' + val_input_lien
                            + '" type="video/mp4"></video></div></div><br>';
                }

            }
        }

        if (nex === null && nat === null) {
            $('#container-qcm-description').append(bloc);
        } else {
            $('#container_exercice_' + nex + '_atelier_' + nat).append(bloc);
        }

        if (type === 'img') {
            if (nex === null && nat === null) {
                $('#image-qcm-description-' + nb).append(spanajoutqcm('image-qcm-description-' + nb));
                $('.input-image-qcm-description').each(function () {
                    $(this).click(function () {
                        editionqcm(false, $(this), 'image');
                        return false;
                    });
                });
            } else {
                $('#image_exercice_' + nex + '_' + nb + '_atelier_' + nat).append(spanajoutforupload('exercice_', 'image_exercice_' + nex + '_' + nb + '_atelier_' + nat));
                $('.input_image_exercice').each(function () {
                    $(this).click(function () {
                        editionintro_exercice(false, $(this), 'image', 'exercice_', '#container_exercice_' + nex + '_atelier_' + nat);
                        return false;
                    });
                });
            }

        } else if (type === 'vid') {
            if (nex === null && nat === null) {
                $('#video-qcm-description-' + nb).append(spanajoutqcm('video-qcm-description-' + nb));
                $('.input-video-qcm-description').each(function () {
                    $(this).click(function () {
                        editionqcm(false, $(this), 'video');
                        return false;
                    });
                });
            } else {
                $('#video_exercice_' + nex + '_' + nb + '_atelier_' + nat).append(spanajoutforupload('exercice_', 'video_exercice_' + nex + '_' + nb + '_atelier_' + nat));
                $('.input_video_exercice').each(function () {
                    $(this).click(function () {
                        editionintro_exercice(false, $(this), 'video', 'exercice_', '#container_exercice_' + nex + '_atelier_' + nat);
                        return false;
                    });
                });
            }
        }

        $('#contenus_popup_over_liensupload_exercices').removeClass('active').addClass('contenu-cacher');
        $('#popup_exercices_over_liensupload').removeClass('active_over').addClass('dialog_operations_over');
    }
};

var pathUploadExercice = function (type, nex, nat) {
    $('#popup_over_dossier_exercice').removeClass('contenu-cacher').addClass('active_over');
    $('#contenus_popup_over_dossier_exercice').removeClass('contenu-cacher').addClass('active');

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'POST',
        url: host + '/admin/fichiers/type/' + type,
        dataType: 'json',
        success: function (data) {
            var table = $('#files_table_exercices').dataTable({
                destroy: true,
                data: data,
                columns: [
                    {title: 'thumbnail', data: 'thumbnails', targets: 0, visible: type === 'img' ? true : false},
                    {title: 'nom', data: 'nom', targets: 1},
                    {title: 'date', data: 'date', targets: 2},
                    {title: 'url', data: 'url', targets: 3, visible: type === 'vid' ? true : false, render: function (url, type, row) {
                            return '<a href="' + url + '" target="_blank">' + url + '</a>';
                        }},
                    {title: 'type', data: 'type', targets: 4, visible: false}
                ],
                order: [[1, 'asc']],
                scrollY: '400px',
                scrollCollapse: false,
                lengthMenu: [[5, 10, 25, -1], [5, 10, 25, 'All']]
            });

            setTimeout(function () {
                table.fnAdjustColumnSizing();
            }, 10);

            $('#files_table_exercices tbody').on('click', 'tr', function () {
                var row = table.fnGetData(this);

                if (type === 'img') {
                    var contenu = '<div style="margin: 50px;">' + row.thumbnails + '<div style="margin-left: 50px;margin-bottom: 200px;display: inline-block;">' + row.nom + '</div></div>';
                } else if (type === 'vid') {
                    var contenu = '<div style="margin: 50px 50px 200px 50px;">Souhaitez-vous utiliser le vidéo suivante : ' + row.nom + ' (Cliquez <a href="' + row.url + '" target="_blank">ici</a> pour voir la vidéo)</div>';
                }

                $('#popup_dossier_apercu_exercice').empty();
                $('#popup_dossier_apercu_exercice').html(contenu + '<div id="bouton_upload_exercices" class="row bouton_upload"><br/><br/><div class="bloc-boutons-submits"><a href="#" id="submit_dossierupload_exercices" class="lancer fermerpopup submit" style="height:60px; width: 50%; display:block; text-decoration: none; padding-top: 20px;margin: auto;">TERMINER</a></div></div>');
                $('#popup_dossier_contenu_exercice').addClass('contenu-cacher');
                $('#popup_dossier_apercu_exercice').removeClass('contenu-cacher').addClass('active');

                $('#submit_dossierupload_exercices').on('click', function () {
                    $('#popup_over_dossier_exercice').removeClass('active_over').addClass('dialog_operation_over');
                    $('#contenus_popup_over_dossier_exercice').removeClass('active').addClass('contenu-cacher');

                    if (type === 'img') {
                        if (nex === null && nat === null) {
                            var nb = $('.input-image-qcm-description').length;
                            do {
                                nb++;
                            } while ($('#image-qcm-description-' + nb).length === 1);

                            var bloc = '<div style="position: relative;" class="sortable"><div id="image-qcm-description-' + nb
                                    + '" class="input-image-qcm-description sortable" style="width: 90%;border: none;margin-left: auto;margin-right: auto;text-align: center;" '
                                    + 'contentEditable="true"><img src="' + row.url + '" style="max-width: 98%;"></div></div><br>';
                        } else {
                            var nb = $('.input_image_exercice').length;
                            nb++;
                            var bloc = '<div style="position: relative;" class="sortable"><div id="image_exercice_' + nex + '_' + nb + '_atelier_' + nat
                                    + '" class="input_image_exercice sortable" style="width: 90%;border: none;margin-left: auto;margin-right: auto;text-align: center;" contentEditable="true"><img src="'
                                    + row.url + '" style="max-width: 98%;"></div></div><br>';
                        }
                    } else if (type === 'vid') {
                        if (nex === null && nat === null) {
                            var nb = $('.input-video-qcm-description').length;
                            do {
                                nb++;
                            } while ($('#video-qcm-description-' + nb).length === 1);

                            var bloc = '<div style="position: relative;" class="sortable"><div id="video-qcm-description-' + nb
                                    + '" class="input-video-qcm-description sortable" style="width: 90%;border: none;margin-left: auto;margin-right: auto;text-align: center;">'
                                    + '<video controls width="320" height="240"><source src="' + row.url + '" type="' + row.type + '"></video></div></div><br>';
                        } else {
                            var nb = $('.input_video_exercice').length;
                            nb++;
                            var bloc = '<div style="position: relative;" class="sortable"><div id="video_exercice_' + nex + '_' + nb + '_atelier_' + nat
                                    + '" class="input_video_exercice sortable" style="width: 90%;border: none;margin-left: auto;margin-right: auto;text-align: center;"><video controls="" width="320" height="240"><source src="'
                                    + row.url + '" type="' + row.type + '"></video></div></div><br>';
                        }
                    }

                    if (nex === null && nat === null) {
                        $('#container-qcm-description').append(bloc);
                    } else {
                        $('#container_exercice_' + nex + '_atelier_' + nat).append(bloc);
                    }

                    if (type === 'img') {
                        if (nex === null && nat === null) {
                            $('#image-qcm-description-' + nb).append(spanajoutqcm('image-qcm-description-' + nb));
                            $('.input-image-qcm-description').each(function () {
                                $(this).click(function () {
                                    editionqcm(false, $(this), 'image');
                                    return false;
                                });
                            });
                        } else {
                            $('#image_exercice_' + nex + '_' + nb + '_atelier_' + nat).append(spanajoutforupload('exercice_', 'image_exercice_' + nex + '_' + nb + '_atelier_' + nat));
                            $('.input_image_exercice').each(function () {
                                $(this).click(function () {
                                    editionintro_exercice(false, $(this), 'image', 'exercice_', '#container_exercice_' + nex + '_atelier_' + nat);
                                    return false;
                                });
                            });
                        }
                    } else if (type === 'vid') {
                        if (nex === null && nat === null) {
                            $('#video-qcm-description-' + nb).append(spanajoutqcm('video-qcm-description-' + nb));
                            $('.input-video-qcm-description').each(function () {
                                $(this).click(function () {
                                    editionqcm(false, $(this), 'video');
                                    return false;
                                });
                            });
                        } else {
                            $('#video_exercice_' + nex + '_' + nb + '_atelier_' + nat).append(spanajoutforupload('exercice_', 'video_exercice_' + nex + '_' + nb + '_atelier_' + nat));
                            $('.input_video_exercice').each(function () {
                                $(this).click(function () {
                                    editionintro_exercice(false, $(this), 'video', 'exercice_', '#container_exercice_' + nex + '_atelier_' + nat);
                                    return false;
                                });
                            });
                        }
                    }

                    $('#popup_dossier_apercu_exercice').removeClass('active').addClass('contenu-cacher');
                    $('#popup_dossier_contenu_exercice').removeClass('contenu-cacher').addClass('active');
                });
                return false;
            });
        },
        error: function (XMLHttpRequest) {
            console.log(XMLHttpRequest);
        }
    });
};

var directUploadExercice = function (type, nex, nat) {
    var tpc;

    if (type === 'img') {
        tpc = 'photo';
    } else if (type === 'vid') {
        tpc = 'video';
    }

    $('#chx_photo_exercices_type').val(tpc);

    var form = document.getElementById('chx-upload-photo-exercice-direct');
    form.removeEventListener('onsubmit', directUploadAjaxExercice);
    form.onsubmit = function () {
        directUploadAjaxExercice(form, type, nex, nat);
    };

    $('#chx_photo_exercices_submit').click();
    $('#chx_photo_exercices').val('');
};

var directUploadAjaxExercice = function (form, type, nex, nat) {
    event.preventDefault();
    var formData = new FormData(form);
    var bloc;

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        method: 'POST',
        url: host + '/admin/uploader',
        data: formData,
        cache: false,
        contentType: false,
        processData: false
    }).done(function (response) {
        $('#popup_exercices_over_dragupload').removeClass('active_over').addClass('dialog_operation_over');
        $('#contenus_popup_over_dragupload_exercices').removeClass('active').addClass('contenu-cacher');

        if (type === 'img') {
            if (nex === null && nat === null) {
                var nb = $('.input-image-qcm-description').length;
                do {
                    nb++;
                } while ($('#image-qcm-description-' + nb).length === 1);

                bloc = '<div style="position: relative;" class="sortable"><div id="image-qcm-description-' + nb
                        + '" class="input-image-qcm-description sortable" style="width: 90%;border: none;margin-left: auto;margin-right: auto;text-align: center;" '
                        + 'contentEditable="true"><img src="' + host + response.msg + '" style="max-width: 98%;"></div></div><br>';
            } else {
                var nb = $('.input_image_exercice').length;
                nb++;

                bloc = '<div style="position: relative;" class="sortable"><div id="image_exercice_' + nex + '_' + nb + '_atelier_' + nat
                        + '" class="input_image_exercice sortable" style="width: 90%;border: none;margin-left: auto;margin-right: auto;text-align: center;" contentEditable="true"><img src="'
                        + host + response.msg + '" style="max-width: 98%;"></div></div><br>';
            }
        } else if (type === 'vid') {
            if (nex === null && nat === null) {
                var nb = $('.input-video-qcm-description').length;
                do {
                    nb++;
                } while ($('#video-qcm-description-' + nb).length === 1);

                bloc = '<div style="position: relative;" class="sortable"><div id="video-qcm-description-' + nb
                        + '" class="input-video-qcm-description sortable" style="width: 90%;border: none;margin-left: auto;margin-right: auto;text-align: center;">'
                        + '<video controls width="320" height="240"><source src="' + host + response.msg + '" type="' + response.type + '"></video></div></div><br>';
            } else {
                var nb = $('.input_video_exercice').length;
                nb++;

                bloc = '<div style="position: relative;" class="sortable"><div id="video_exercice_' + nex + '_' + nb + '_atelier_' + nat
                        + '" class="input_video_exercice sortable" style="width: 90%;border: medium none;margin-left: auto;margin-right: auto;text-align: center;"><video controls="" width="320" height="240"><source src="'
                        + host + response.msg + '" type="' + response.type + '"></video></div></div><br>';
            }
        }

        if (nex === null && nat === null) {
            $('#container-qcm-description').append(bloc);
        } else {
            $('#container_exercice_' + nex + '_atelier_' + nat).append(bloc);
        }

        if (type === 'img') {
            if (nex === null && nat === null) {
                $('#image-qcm-description-' + nb).append(spanajoutqcm('image-qcm-description-' + nb));
                $('.input-image-qcm-description').each(function () {
                    $(this).click(function () {
                        editionqcm(false, $(this), 'image');
                        return false;
                    });
                });
            } else {
                $('#image_exercice_' + nex + '_' + nb + '_atelier_' + nat).append(spanajoutforupload('exercice_', 'image_exercice_' + nex + '_' + nb + '_atelier_' + nat));
                $('.input_image_exercice').each(function () {
                    $(this).click(function () {
                        editionintro_exercice(false, $(this), 'image', 'exercice_', '#container_exercice_' + nex + '_atelier_' + nat);
                        return false;
                    });
                });
            }
        } else if (type === 'vid') {
            if (nex === null && nat === null) {
                $('#video-qcm-description-' + nb).append(spanajoutqcm('video-qcm-description-' + nb));
                $('.input-video-qcm-description').each(function () {
                    $(this).click(function () {
                        editionqcm(false, $(this), 'video');
                        return false;
                    });
                });
            } else {
                $('#video_exercice_' + nex + '_' + nb + '_atelier_' + nat).append(spanajoutforupload('exercice_', 'video_exercice_' + nex + '_' + nb + '_atelier_' + nat));
                $('.input_video_exercice').each(function () {
                    $(this).click(function () {
                        editionintro_exercice(false, $(this), 'video', 'exercice_', '#container_exercice_' + nex + '_atelier_' + nat);
                        return false;
                    });
                });
            }
        }

        $('#popup_dossier_apercu_exercice').removeClass('active').addClass('contenu-cacher');
        $('#popup_dossier_contenu_exercice').removeClass('contenu-cacher').addClass('active');
    });
};