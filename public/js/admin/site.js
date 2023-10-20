/* 
 * This file is a part of the OPGC Data Center project
 * 
 * Observatoire de Physique du Globe de Clermont-Ferrand
 * Campus Universitaire des Cezeaux
 * 4 Avenue Blaise Pascal
 * TSA 60026 - CS 60026
 * 63178 AUBIERE CEDEX FRANCE
 * 
 * Author: Yannick Guehenneux
 *         y.guehenneux [at] opgc.fr
 * 
 */

var initialValues = [10, 25, 75, 90];

function updateSoundValue(ui) {
    $(ui.handle).attr('data-value', ui.value + '%');

    var classId = $(ui.handle).parent().prop('className').match(/audio-\d+/g)[0];
    $('.' + classId + '.audio-out-min').val(ui.values[0] / 100);
    $('.' + classId + '.audio-in-min').val(ui.values[1] / 100);
    $('.' + classId + '.audio-in-max').val(ui.values[2] / 100);
    $('.' + classId + '.audio-out-max').val(ui.values[3] / 100);
}

function createSlider(numb, init_values = null) {
    if (init_values !== null) {
        init_values = init_values.map(function(x) { return x * 100; });
    }
    $(".slider-" + numb).slider({
        min: -10,
        max: 110,
        step: 0.1,
        range: false,
        values: init_values === null ? [10, 25, 75, 90] : init_values,
        create: function (event, ui) {
            var handles = $(this).find('.ui-slider-handle');
            if (init_values === null) {
                $.each(initialValues, function (i, v) {
                    updateSoundValue({
                        value: v,
                        handle: handles.eq(i)[0],
                        values: initialValues
                    });
                });
            } else {                
                $.each(init_values, function (i, v) {
                    updateSoundValue({
                        value: v,
                        handle: handles.eq(i)[0],
                        values: init_values
                    });
                });
            }
        },
        slide: function (event, ui) {
            var handleIndex = $('span', event.target).index(ui.handle);
            var curr = ui.values[handleIndex];
            var next = ui.values[handleIndex + 1] - 0.1;
            var prev = ui.values[handleIndex - 1] + 0.1;

            if (curr > next || curr < prev) {
                return false;
            }

            updateSoundValue(ui);
        }
    });
}

function updatePannellumSlider(ui, type) {
    $(ui.handle).attr('data-value', ui.value + '°');
    $('#' + type + '-input').val(ui.value);
}

function createPannellumSlider(type) {    
    switch (type) {
        case 'haov':
            var min = 0;
            var max = 360;            
            break;
        case 'vaov':
            var min = 0;
            var max = 180;
            break;
        case 'voffset':
            var min = -90;
            var max = 90;
            break;
    }
    
    var value = $('#' + type + '-input').val();
    
    $('.slider-' + type).slider({
        min: min,
        max: max,
        step: 0.001,
        value: value,
        create: function (event, ui) {
            updatePannellumSlider({value: value, handle:$(this).find('.ui-slider-handle')[0]}, type);
        },
        slide: function(event, ui) {
            updatePannellumSlider(ui, type);
        }
    });
}

function addNewSound() {
    $('.add-sound-link').remove();

    $('#number-sounds').get(0).value++;

    $('#sound-selector-container').append('\
<table class="admin-table-input-group audio-' + $('#number-sounds').val() + '">\n\
    <td class="td-label">Audio</td>\n\
    <td class="td-input">\n\
        <label class="custom-file-upload">\n\
            <input type="file" name="audio-files[]" accept=".mp3" class="input-file"><span>Cliquez ici pour ajouter un fichier audio</span><img src="' + host + '/css/img/ICONE_PLUS.png" style="float:right;">\n\
        </label>\n\
    </td>\n\
    <td style="border-collapse:initial"> *&nbsp;<a href="#sound" class="audio-delete audio-' + $('#number-sounds').val() + '"><img src="' + host + '/img/corbeille2.png"></a></td>\n\
</table>\n\
<div class="audio-slider slider-' + $('#number-sounds').val() + ' audio-' + $('#number-sounds').val() + '"></div>\n\
<input type="hidden" name="audio-out-min[]" class="audio-out-min audio-' + $('#number-sounds').val() + '"/>\n\
<input type="hidden" name="audio-in-min[]" class="audio-in-min audio-' + $('#number-sounds').val() + '"/>\n\
<input type="hidden" name="audio-in-max[]" class="audio-in-max audio-' + $('#number-sounds').val() + '"/>\n\
<input type="hidden" name="audio-out-max[]" class="audio-out-max audio-' + $('#number-sounds').val() + '" step="0.1"/>');

    createSlider($('#number-sounds').val());

    $('#sound-selector-container').append('<a href="#sound" name="sound" class="add-sound-link" onclick="addNewSound()">Cliquez-ici pour ajouter un autre son d&apos;ambiance</a>');
}

function roundDecimal(numb, dec) {
    return Math.round(numb * Math.pow(10, dec)) / Math.pow(10, dec);
}

function getCoordinatesFromMap(coord) {
    $('#site-map-latmin').val(roundDecimal(coord[0]['lat'], 5));
    $('#site-map-latmax').val(roundDecimal(coord[2]['lat'], 5));
    $('#site-map-lonmin').val(roundDecimal(coord[0]['lng'], 5));
    $('#site-map-lonmax').val(roundDecimal(coord[2]['lng'], 5));
}

function getAtelierCoordinatesFromMap(coord) {
    $('#x_carte').val(roundDecimal(coord.lat, 5));
    $('#y_carte').val(roundDecimal(coord.lng, 5));
}

function checkCoordinates(latmin, latmax, lonmin, lonmax) {
    if (isNaN(latmin) || isNaN(latmax) || isNaN(lonmin) || isNaN(lonmax)) {
        return false;
    }
    if (latmin < -90.0 || latmin > 90.0 || latmax < -90.0 || latmax > 90.0) {
        return false;
    }
    if (lonmin < -180.0 || lonmin > 180.0 || lonmax < -180.0 || lonmax > 180.0) {
        return false;
    }
    if (latmin > latmax || lonmin > lonmax) {
        return false;
    }
    return true;
}

function checkPoint(lat, lng) {
    if (isNaN(lat) || isNaN(lng)) {
        return false;
    }
    if (lat < -90.0 || lat > 90.0 || lng < -180.0 || lng > 180.0) {
        return false;
    }
    return true;
}

function cursorRippleEffect(e) {
    $('.videoContainer').find('.ripple').remove();
    $('<div class="ripple" style="left:' + e.clientX + 'px;top:' + e.clientY + 'px;animation: ripple-effect .6s linear;"></div>').appendTo('.videoContainer');
}

$(document).ready(function ()
{
    var dWidth = $(window).width() * 0.75;
    var dHeight = $(window).height() * 0.95;
    
    //    display the name of the uploaded file on the form
    $(document).on('change', '.input-file', function () {
        var fic = $(this).val().match(/[^\\/]*$/)[0];
        $(this).next().html(fic);
        $(this).next().css('color', '#777');
    });

    /* Supprimer un formulaire de son d'ambiance  */
    $(document).on('click', '.audio-delete', function () {
        var classId = '.' + $(this).prop('className').match(/audio-\d+/g)[0];
        $(classId).remove();
    });
    
    if (!$('.slider-0').hasClass('ui-widget-content')){
        createSlider(0);
    }

    $('#site-popup-map').dialog({
        resizable: true,
        autoOpen: false,
        modal: true,
        width: 1050,
        height: 750,
        title: 'Utlisez le bouton à droite pour dessiner une zone d\'interêt qui représentera les limites de la carte',
        open: function () {
            drawMap();
        }
    });

    $('#site-popup-map-link').click(function () {
        $('#site-popup-map').dialog('open');
    });

    $('#radio-carte-set').buttonset();

    $('.radio-carte').click(function () {
        var typeCarte = $(this).val();
        if (typeCarte === 'fixe') {
            $('#carte-interactive-content').hide();
            $('#carte-fixe-content').show();
        } else {
            $('#carte-fixe-content').hide();
            $('#carte-interactive-content').show();
        }
    });

    $('#select-atelier').selectmenu({
        change: function () {
            this.form.submit();
        }
    });

    $('#atelier-popup-video').dialog({
        resizable: false,
        autoOpen: false,
        modal: true,
        width: 1320,
        height: 820,
        title: 'Cliquez sur la vidéo pour extraire les coordonnées'
    });

    $('.video-popup-link').click(function () {
        $('#atelier-popup-video').dialog('open');
    });

    $('#atelier-video').click(function (e) {
        cursorRippleEffect(e);
        if (!this.paused && !this.ended) {
            $('.btnPlay').click();
        }
        $('#atelier-timestamp').val(roundDecimal(this.currentTime, 3));
        $('#atelier-x-video').val(roundDecimal((e.offsetX / this.videoWidth) * 100, 3));
        $('#atelier-y-video').val(roundDecimal((e.offsetY / this.videoHeight) * 100, 3));
    });
    
    $('#atlier-popup-carte').dialog({
        resizable: true,
        autoOpen: false,
        modal: true,
        width: dWidth,
        height: dHeight,
        title: 'Cliquez sur la carte pour extraire les coordonnées',
        open: function() {
            drawMapAtelier();
        }
    });

    $('.carte-popup-link').click(function () {
        $('#atlier-popup-carte').dialog('open');
    });

    $('#carte-img').click(function (e) {
        var posX = roundDecimal((e.offsetX / this.width) * 100, 3);
        var posY = roundDecimal((e.offsetY / this.height) * 100, 3);
        $('#atelier-x-carte').val(posX);
        $('#atelier-y-carte').val(posY);
        $('#point-carte').css({top: posY + '%',left: posX + '%'});
        $('#point-carte').css({display: 'inline'});
    });
    
    ['haov', 'vaov', 'voffset'].forEach(function(type) {
        createPannellumSlider(type);
        $('#' + type + '-input').on('keyup mouseup', function() {
            $('.slider-' + type).slider('option', 'value', $(this).val());
            $($('.slider-' + type).find('.ui-slider-handle')[0]).attr('data-value', $(this).val() + '°');
        });
    });

});
