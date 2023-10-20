
function spanajoutforupload(pour, id) {
    return ('<span id="liensinputs_' + pour + '' + id + '" class="erasemove" style="display:none"><div class="moveicon"></div></br><a href="#" id="liensup_' + pour + '' + id + '" onclick="javascript:supprContainer(\'' + id + '\', \'#liensinputs_' + pour + '' + id + '\'); return false;"><div class="suppricon"></div></a></span>');
}

function GeovisitUploader(url_ajax, pour, id_popup_generale, id_contenu_popup_generale, id_popup_over, id_contenu_popup_over, id_container_destination, type_contenu, id_array_container_hidden) {
    //VARIABLES INTERNES POUR FUTURS AJOUTS DE FONCTIONNALITES : LES EVENEMENTS drop FAISANT APPEL AU "document" ELLES NE SONT PAS UTILES
    this.pour = pour;
    this.id_popup_generale = id_popup_generale;
    this.id_contenu_popup_generale = id_contenu_popup_generale;
    this.id_popup_over = id_popup_over;
    this.id_contenu_popup_over = id_contenu_popup_over;
    this.id_container_destination = id_container_destination;
    this.type_contenu = type_contenu;
    this.vient_de = pour;
    this.defaultMessage = "<h1>DEPOSEZ VOTRE FICHIER ICI</h1></br>500Mo Maximum"; // MB

    this.initialise = function () {
        this.start();
    };

    this.start = function () {
        $(this.id_contenu_popup_over).find('.upload_dropzone').each(function () {
            var id_drop = $(this).attr('id');
            $(document).on('dragenter', '#' + id_drop, function () {
                $(this).css("background", "#feefea");
                return false;
            });

            $(document).off('drop', '#' + id_drop).on('drop', '#' + id_drop, function (e) {
                e.preventDefault();
                e.stopPropagation();
                if (e.originalEvent.dataTransfer) {
                    if (e.originalEvent.dataTransfer.files.length > 0) {

                        // STOPPE LA PROPAGATION
                        var files = e.originalEvent.dataTransfer.files;

                        //TABLEAU DE FICHIER
                        var tableauFichier = [];

                        //INFOS TAILLE TYPE
                        var f = e.originalEvent.dataTransfer.files[0];

                        var preview = $(this).find('.zone-image-preview');
                        var infos_div = $(this).find('.zone-image-infos');

                        var fileName = f.name;
                        var fileSize = formatSize(f.size, 10);
                        var texte_infos = fileName + "<br>" + fileSize + "";

                        $(this).css({"background": "white", "border": "none"});
                        $(this).find('.icondragupload').hide();
                        $(this).find('.zone-message').hide();
                        $(this).find('.bouton_upload').show();
                        $(this).find('.enlever').show();

                        $(id_contenu_popup_over).find('.bloc-upload-manuel').hide();

                        var imageType = "";
                        if (type_contenu === "photo") {
                            imageType = /image.*/;
                        } else if (type_contenu === "video") {
                            imageType = /video.*/;
                        }

                        var continuer = true;
                        [].forEach.call(files, function (file) {
                            if (file.type.match(imageType)) {
                                if (tableauFichier.length > 0) {
                                    tableauFichier = [];
                                    tableauFichier.push(file);
                                } else {
                                    tableauFichier.push(file);
                                }

                            } else {
                                alert("Ce fichier n'est pas au format " + type_contenu);
                                $('#' + id_drop).find('.icondragupload').show();
                                $('#' + id_drop).find('.zone-message').show();
                                $('#' + id_drop).find('.bouton_upload').hide();
                                $('#' + id_drop).find('.enlever').hide();
                                $('#' + id_drop).css({"border": "1px dotted #f96332"});
                                $(id_contenu_popup_over).find('.bloc-upload-manuel').show();
                                preview.html('');
                                infos_div.html('');
                                tableauFichier = [];
                                continuer = false;
                            }
                        });

                        if (continuer) {
                            if (tableauFichier[0].type.match(imageType)) {
                                var img = document.createElement("img");
                                img.classList.add("obj");
                                img.file = tableauFichier[0];
                                img.height = 80;
                                preview.append(img);
                                infos_div.html(texte_infos);
                                var reader = new FileReader();
                                reader.onload = (function (aImg) {
                                    return function (e) {
                                        var element = $();
                                        element = element.add(e.target);
                                        if (element.length === 1) {
                                            aImg.src = e.target.result;
                                        }
                                    };
                                })(img);
                                reader.readAsDataURL(tableauFichier[0]);
                            }

                            // FONCTION UPLOAD
                            $(this).find('.enlever').click(function (event) {
                                event.preventDefault();
                                $('#' + id_drop).find('.icondragupload').show();
                                $('#' + id_drop).find('.zone-message').show();
                                $('#' + id_drop).find('.bouton_upload').hide();
                                $('#' + id_drop).find('.enlever').hide();
                                $('#' + id_drop).css({"border": "1px dotted #f96332"});
                                $(id_contenu_popup_over).find('.bloc-upload-manuel').show();
                                preview.html('');
                                infos_div.html('');
                                tableauFichier = [];
                                return false;
                            });

                            $(this).find('.lancer').click(function () {

                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
                                });
                                this.url_ajax = url_ajax;

                                var formData = new FormData();
                                formData.append('file', tableauFichier[0]);
                                formData.append('type_contenu', type_contenu);
                                formData.append('depuis', pour);
                                if (pour === "profil") {
                                    formData.append('externe', 'non');
                                }

                                $.ajax({
                                    type: 'POST',
                                    url: url_ajax,
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    dataType: 'json',
                                    error: function (response) {
                                        console.log(response);
                                    },
                                    success: function (response) {
                                        var resultat = response.msg;
                                        $(id_contenu_popup_over).find('.upload_dropzone').css({"border": "1px dotted #f96332"});
                                        if (resultat !== "ERREUR") {
                                            if (pour !== "qcm_exercice") {
                                                $(id_popup_over).removeClass('active_over').addClass('dialog_operations_over');
                                                $(id_contenu_popup_over).removeClass('active').addClass('contenu-cacher');
                                            }

                                            if (pour === "profil") {
                                                $(id_contenu_popup_over).find('.icondragupload').show();
                                                $('#' + id_drop).find('.zone-message').show();
                                                $('#' + id_drop).find('.bouton_upload').hide();
                                                $('#' + id_drop).find('.enlever').hide();
                                                $('#' + id_drop).css({"border": "1px dotted #f96332"});
                                                $(id_contenu_popup_over).find('.bloc-upload-manuel').show();
                                                preview.html('');
                                                infos_div.html('');
                                                location.reload();
                                            } else if (pour === "editeur_intro") {
                                                $(id_contenu_popup_over).find('.icondragupload').show();
                                                $('#' + id_drop).find('.zone-message').show();
                                                $('#' + id_drop).find('.bouton_upload').hide();
                                                $('#' + id_drop).find('.enlever').hide();
                                                $(id_contenu_popup_over).find('.bloc-upload-manuel').show();
                                                preview.html('');
                                                infos_div.html('');
                                                $(id_popup_generale).removeClass('active').addClass('dialog_operations');
                                                $(id_contenu_popup_generale).removeClass('active').addClass('contenu-cacher');
                                                if (type_contenu === "photo") {
                                                    var nb_images = $(id_container_destination).find(".input_images_sommaire").length;
                                                    var nb = nb_images++;

                                                    var bloc_images = '<div style="position: relative;" class="sortable"><div id="image_sommaire' + nb + '" class="input_images_sommaire sortable" style="width:90%; border:none; margin-left:auto; margin-right:auto; text-align:center;" contentEditable="true"><img src="' + host + '' + resultat + '" style="max-width: 98%;" /></div></div></br>';
                                                    $(id_container_destination).append(bloc_images);
                                                    $('#image_sommaire' + nb).append(spanajoutforupload("", 'image_sommaire' + nb));
                                                    $('.input_images_sommaire').each(function () {
                                                        $(this).click(function () {
                                                            var _this = $(this);
                                                            editionintro(false, _this, "image", "");
                                                            return false;
                                                        });
                                                    });
                                                } else if (type_contenu === "video") {
                                                    var nb_videos = $(id_container_destination).find(".input_videos_sommaire").length;
                                                    var nb = nb_videos++;
                                                    var bloc_videos = '<div style="position: relative;" class="sortable"><div id="video_sommaire' + nb + '" class="input_videos_sommaire sortable" style="width:90%; border:none; margin-left:auto; margin-right:auto; text-align:center;" contentEditable="true"><video width="320" height="240" controls><source src="' + host + '' + resultat + '" type="video/mp4"></video></div></div></br>';
                                                    $(id_container_destination).append(bloc_videos);
                                                    $('#video_sommaire' + nb).append(spanajoutforupload("", 'video_sommaire' + nb));
                                                    $('.input_videos_sommaire').each(function () {
                                                        $(this).click(function () {
                                                            var _this = $(this);
                                                            editionintro(false, _this, "video", "");
                                                            return false;
                                                        });
                                                    });
                                                    var intro_exercice = $(id_array_container_hidden);
                                                    var contenu_container = $(id_container_destination).html();

                                                    intro_exercice.val(contenu_container);
                                                }
                                                $("input[name=intro_tp]:hidden").val($('#container_intro').html());
                                                $("input[name=intro_tp]:hidden").change();
                                                $("#intro_tp_contenu_admin").val($('#container_intro').html()).change();
                                            } else if (pour === "editeur_exercice") {
                                                $(id_popup_generale).removeClass('active').addClass('dialog_operations');
                                                $(id_contenu_popup_generale).removeClass('active').addClass('contenu-cacher');

                                                $(id_contenu_popup_over).find('.icondragupload').show();
                                                $('#' + id_drop).find('.zone-message').show();
                                                $('#' + id_drop).find('.bouton_upload').hide();
                                                $('#' + id_drop).find('.enlever').hide();
                                                $('#' + id_drop).css({"border": "1px dotted #f96332"});
                                                $(id_contenu_popup_over).find('.bloc-upload-manuel').show();
                                                preview.html('');
                                                infos_div.html('');

                                                var identifiants_upload = id_container_destination.split("_");
                                                var numero_ateliers_upload = identifiants_upload[4];
                                                var numero_exercice_upload = identifiants_upload[2];

                                                if (type_contenu === "photo") {
                                                    var nb_images = $(id_container_destination).find(".input_images_exercice").length;
                                                    var nb = nb_images + 1;
                                                    var bloc_images = '<div style="position: relative;" class="sortable"><div id="image_exercice_' + numero_exercice_upload + '_' + nb + '_atelier_' + numero_ateliers_upload + '" class="input_image_exercice sortable" style="width:90%; border:none; margin-left:auto; margin-right:auto; text-align:center;" contentEditable="true"><img src="' + host + '' + resultat + '" style="max-width: 98%;" /></div></div></br>';
                                                    $(id_container_destination).append(bloc_images);
                                                    $('#image_exercice_' + numero_exercice_upload + '_' + nb + '_atelier_' + numero_ateliers_upload).append(spanajout("exercice_", 'image_exercice_' + numero_exercice_upload + '_' + nb + '_atelier_' + numero_ateliers_upload));

                                                    $('.input_image_exercice').each(function () {
                                                        $(this).click(function () {
                                                            editionintro_exercice(false, $(this), 'image', 'exercice_', '#container_exercice_' + numero_exercice_upload + '_atelier_' + numero_ateliers_upload);
                                                            return false;
                                                        });
                                                    });
//                                                    var intro_exercice = $(id_array_container_hidden);
//                                                    var contenu_container = $(id_container_destination).html();
//
//                                                    intro_exercice.val(contenu_container);
                                                } else if (type_contenu === "video") {
                                                    var nb_videos = $(id_container_destination).find(".input_videos_exercice").length;
                                                    var nb = nb_videos + 1;
                                                    var bloc_videos = '<div style="position: relative;" class="sortable"><div id="video_exercice_' + numero_exercice_upload + '_' + nb + '_atelier_' + numero_ateliers_upload + '" class="input_video_exercice sortable" style="width:90%; border:none; margin-left:auto; margin-right:auto; text-align:center;" contentEditable="true"><video width="320" height="240" controls><source src="' + host + '' + resultat + '" type="video/mp4"></video></div></div></br>';
                                                    $(id_container_destination).append(bloc_videos);
                                                    $('#video_exercice_' + numero_exercice_upload + '_' + nb + '_atelier_' + numero_ateliers_upload).append(spanajout("exercice_", 'video_exercice_' + numero_exercice_upload + '_' + nb + '_atelier_' + numero_ateliers_upload));
                                                    $('.input_video_exercice').each(function () {
                                                        $(this).click(function () {
                                                            editionintro_exercice(false, $(this), 'video', 'exercice_', '#container_exercice_' + numero_exercice_upload + '_atelier_' + numero_ateliers_upload);
                                                            return false;
                                                        });
                                                    });
//                                                    var intro_exercice = $(id_array_container_hidden);                                            
//                                                    var contenu_container = $(id_container_destination).html();
//
//                                                    intro_exercice.val(contenu_container);
                                                }

                                            } else if (pour === "editeur_qcm") {
                                                $(id_popup_over).removeClass('active_over').addClass('dialog_operations_over');
                                                $(id_contenu_popup_over).removeClass('active_over').addClass('contenu-cacher');

                                                $(id_popup_generale).removeClass('active').addClass('dialog_operations');
                                                $(id_contenu_popup_generale).removeClass('active').addClass('contenu-cacher');

                                                $(id_contenu_popup_over).find('.icondragupload').show();
                                                $('#' + id_drop).find('.zone-message').show();
                                                $('#' + id_drop).find('.bouton_upload').hide();
                                                $('#' + id_drop).find('.enlever').hide();
                                                $('#' + id_drop).css({"border": "1px dotted #f96332"});
                                                $(id_contenu_popup_over).find('.bloc-upload-manuel').show();
                                                preview.html('');
                                                infos_div.html('');

                                                if (type_contenu === 'photo') {
                                                    var nb = $(id_container_destination).find('.input-image-qcm-description').length;
                                                    do {
                                                        nb++;
                                                    } while ($('#image-qcm-description-' + nb).length === true);

                                                    var bloc = '<div style="position: relative;" class="sortable"><div id="image-qcm-description-' + nb
                                                            + '" class="input-image-qcm-description sortable" style="width: 90%;border: none;margin-left: auto;margin-right: auto;text-align: center;" '
                                                            + 'contentEditable="true"><img src="' + host + '' + resultat + '" style="max-width: 98%;"/></div></div><br>';

                                                    $(id_container_destination).append(bloc);

                                                    $('#image-qcm-description-' + nb).append(spanajoutqcm('image-qcm-description-' + nb));

                                                    $('.input-image-qcm-description').each(function () {
                                                        $(this).click(function () {
                                                            var _this = $(this);
                                                            editionqcm(false, _this, 'image');
                                                            return false;
                                                        });
                                                    });
                                                } else if (type_contenu === 'video') {
                                                    var nb = $(id_container_destination).find('.input-video-qcm-description').length;
                                                    do {
                                                        nb++;
                                                    } while ($('#video-qcm-description-' + nb).length === true);

                                                    var bloc = '<div style="position: relative;" class="sortable"><div id="video-qcm-description-' + nb
                                                            + '" class="input-video-qcm-description sortable" style="width: 90%;border: none;margin-left: auto;margin-right: auto;text-align: center;" '
                                                            + 'contentEditable="true"><video width="320" height="240" controls><source src="' + host + '' + resultat + '" type="video/mp4"></video></div></div><br>';

                                                    $(id_container_destination).append(bloc);

                                                    $('#video-qcm-description-' + nb).append(spanajoutqcm('video-qcm-description-' + nb));

                                                    $('.input-video-qcm-description').each(function () {
                                                        $(this).click(function () {
                                                            var _this = $(this);
                                                            editionqcm(false, _this, 'video');
                                                            return false;
                                                        });
                                                    });
                                                }
                                            }
                                            tableauFichier = [];
                                        }
                                    }
                                });
                            });
                        }
                    }
                } else {
                    $(this).css('border', '3px dashed #BBBBBB');
                }
                return false;
            });

            $(document).on('dragover', '#' + id_drop, function (e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).css("background", "#feefea");
                return false;
            });

            $(document).on('dragleave', '#' + id_drop, function (e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).css("background", "white");
                return false;
            });

            function formatSize(bytes, decimals) {
                if (bytes === 0) {
                    return '0 Byte';
                }
                var k = 1000; // or 1024 for binary
                var dm = decimals + 1 || 3;
                var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
                var i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
            }
        });
        return false;
    };

    this.upload_exercice = function (file) {
        if (!file.type.match('image/jpeg')) {
            alert('The file must be a jpeg image');
            return false;
        }
        var reader = new FileReader();
        reader.readAsDataURL(file);
    };

    this.handleReaderLoad_exercice = function (evt) {
        var pic = {};
        pic.file = evt.target.result.split(',')[1];

        alert(pic.file);

        var str = jQuery.param(pic);
        alert(str);
    };
}

