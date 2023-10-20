/* 
 * 
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

function addNewAnswer() {
    question_id = $('#qcm-question-id').val();
    nb_answer = $('#qcm-nb-answer').val();
    nb_answer++;
    
    content = '<tr class="answer-' + nb_answer + '"><td class="td-label">R&Eacute;PONSE N&deg;' + nb_answer + '</td>';
    content += '<td class="td-input">';
    content += '<input type="text" name="question-answer[' + question_id + '][' + nb_answer + '][new]"' 
            + ' placeholder="saisir une r&eacute;ponse" class="table-admin-inputtext">';
    content += '</td>';
    content += '<td class="td-input"><fieldset>';
    content += '<label for="VRAI' + nb_answer + '">&nbsp;VRAI</label>';
    content += '<input id="VRAI' + nb_answer + '" class="radio-group" checked="checked" type="radio" name="question-answer-boolean-[' + question_id + '][' + nb_answer + '][new]" value="1">';
    content += '<input id="FAUX' + nb_answer + '" class="radio-group" type="radio" name="question-answer-boolean-[' + question_id + '][' + nb_answer + '][new]" value="0">';
    content += '<label for="FAUX' + nb_answer + '">&nbsp;FAUX</label>';
    content += '</fieldset></td>';
    content += '<td style="border-collapse: initial;"> * ' + 
            '<a href="#answer" class="answer-delete answer-' + nb_answer + '"><img src="' + host + '/img/corbeille2.png"></a></td>';
    content += '</tr>';
        
    $('#qcm-table-answer').append(content);
    $('#qcm-nb-answer').val(nb_answer);
    
    $('.radio-group').checkboxradio();
    $('fieldset').controlgroup();    
}

spanajoutqcm = function(id) {
     return ('<span id="liensinputs_' + id + '" class="erasemove" style="display:none"><div class="moveicon"></div></br><a href="#" id="liensup_' 
             +  id + '" onclick="javascript:supprContainer(\'' + id + '\'); return false;"><div class="suppricon"></div></a></span>');
};

supprContainer = function(id) {
    $('#' + id).parent().next('br').remove();
    $('#' + id).parent().remove();
    $('#qcm-description').val(nettoyertext($('#container-qcm-description').clone())).change();
    $('#qcm-description-admin').val($('#container-qcm-description').html()).change();
    return false;
};

editionqcm = function(editable, _this, type) {
    var id = $(_this).attr('id');
    var color;
    
    if (type === 'titre') {
        color = '#F96332';
    } else if (type === 'soustitre') {
        color = 'green';
    } else if (type === 'texte') {
        color = 'blue';
    } else if (type === 'image') {
        color = 'black';
    } else if (type === 'video') {
        color = 'yellow';
    }
    
    if (!editable) {
        if (type !== 'titre' || type !== 'soustitre' || type !== 'texte') {
            tmp = _this.text();
            _this.select();
        }
        
        $('#container-qcm-description').sortable({
            placeholder: 'ui-state-highlight',
            helper: 'clone',
            handle: '.moveicon',
            cursor: 'move'
        });
        
        _this.css({
            width: '90%',
            'border-style': 'dashed',
            'border-color': color,
            'margin-left': 'auto',
            'margin-right': 'auto'
        });
        
        $('#liensinputs_' + id).show();
        
        _this.blur(function() {
            _this.css({
                width: '90%',
                border: 'none',
                'margin-left': 'auto',
                'margin-right': 'auto'
            });
            
            $('#liensinputs_' + id).hide();
            
            editable = false;
            
            $('#qcm-description').val(nettoyertext($('#container-qcm-description').clone())).change();
            $('#qcm-description-admin').val($('#container-qcm-description').html()).change();
        });
        
        $('#qcm-description').val(nettoyertext($('#container-qcm-description').clone())).change();        
        $('#qcm-description-admin').val($('#container-qcm-description').html()).change();
    }
    
    editable = true;
    return false;
};

nettoyertext = function(content) {
    var html = $(content);
    
    html.find('span.erasemove').remove();
    var newstring = html.html();
    
    if (typeof newstring === 'undefined') {
        return '';
    }
    
    newstring = newstring.replace(/ style="position: relative;" class="sortable"/g, '');
    newstring = newstring.replace(/ style="width: 90%;min-height: 50px;border: none;margin-left: auto;margin-right: auto;text-align: center;"/g, '');
    newstring = newstring.replace(/ contenteditable="true"/g, '');
    newstring = newstring.replace(/ style="width: 90%;min-height: 50px;border: none;margin-left: auto;margin-right: auto;overflow: hidden;"/g, '');
    
    return newstring;
};

getIdExercice = function() {
    var id_exercice = JSON.parse(localStorage.getItem('GEOVISIT.id_exercice'));
    localStorage.removeItem('GEOVISIT.id_exercice');
    $('#form-qcm').attr('action', host + '/admin/qcm/new/' + id_exercice.id_exercice);
};

$(document).ready(function() {
    
    var editable = false;
    
    ['titre', 'soustitre', 'texte', 'image', 'video'].forEach(function (type) {
        $('.input-' + type + '-qcm-description').each(function () {
            $(this).click(function () {
                editionqcm(false, $(this), type);
                return false;
            });
        });
    });
    
    $(document).on('click', '.answer-delete', function() {
        var classId = '.' + $(this).prop('className').match(/answer-\d+/g)[0];
        var r = confirm('Souhaitez vous supprimer cette réponse ?');
        
        if (r === true) {
            $(classId).remove();
        }
    });
    
    $('#select-question').selectmenu({
        change: function() {
            this.form.submit();
        }
    });
    
    $('.radio-group').checkboxradio();
    $('fieldset').controlgroup();
    
    $('#titre-qcm-description-button').click(function() {
        var nb = $(".input-titre-qcm-description").length;
        nb++;
        
        var bloc = '<div style="position: relative;" class="sortable"><div id="titre-qcm-description-' + nb 
                + '" class="input-titre-qcm-description sortable" align="middle" style="width: 90%;' 
                + 'min-height: 50px;border: none;margin-left: auto;margin-right: auto;text-align: center;" contentEditable="true">'
                + 'Titre a changer</div></div><br>';
        
        $('#container-qcm-description').append(bloc);
        $('#titre-qcm-description-' + nb).append(spanajoutqcm('titre-qcm-description-' + nb));
        $('.input-titre-qcm-description').each(function() {
            $(this).click(function() {
                var _this = $(this);
                editionqcm(editable, _this, 'titre');
                return false;
            });
        });
        
        $('#qcm-description').val(nettoyertext($('#container-qcm-description').clone()));
        $('#qcm-description').change();
        $('#qcm-description-admin').val($('#container-qcm-description').html()).change();
        
        return false;        
    });
    
    $('#soustitre-qcm-description-button').click(function() {
        var nb = $('.input-soustitre-qcm-description').length;
        nb++;
        
        var bloc = '<div style="position: relative;" class="sortable"><div id="soustitre-qcm-description-' + nb 
                + '" class="input-soustitre-qcm-description sortable" align="middle" style="width: 90%;' 
                + 'min-height: 50px;border: none;margin-left: auto;margin-right: auto;text-align: center;" contentEditable="true">'
                + 'Sous-titre a changer</div></div><br>';
        
        $('#container-qcm-description').append(bloc);
        $('#soustitre-qcm-description-' + nb).append(spanajoutqcm('soustitre-qcm-description-' + nb));
        $('.input-soustitre-qcm-description').each(function() {
            $(this).click(function() {
                var _this = $(this);
                editionqcm(editable, _this, 'soustitre');
                return false;
            });
        });
        
        $('#qcm-description').val(nettoyertext($('#container-qcm-description').clone()));
        $('#qcm-description').change();
        $('#qcm-description-admin').val($('#container-qcm-description').html()).change();
        
        return false;   
    });
    
    $('#texte-qcm-description-button').click(function() {
        var nb = $('.input-texte-qcm-description').length;
        nb ++;
        
        var bloc = '<div style="position: relative;" class="sortable"><div id="texte-qcm-description-' + nb 
                + '" class="input-texte-qcm-description sortable" align="middle" style="width: 90%;' 
                + 'min-height: 50px;border: none;margin-left: auto;margin-right: auto;text-align: center;" contentEditable="true">'
                + 'Texte a changer</div></div><br>';
        
        $('#container-qcm-description').append(bloc);
        $('#texte-qcm-description-' + nb).append(spanajoutqcm('texte-qcm-description-' + nb));
        $('.input-texte-qcm-description').each(function() {
            $(this).click(function() {
                var _this = $(this);
                editionqcm(editable, _this, 'texte');
                return false;
            });
        });
        
        $('#qcm-description').val(nettoyertext($('#container-qcm-description').clone()));
        $('#qcm-description').change();
        $('#qcm-description-admin').val($('#container-qcm-description').html()).change();
        
        return false;
    });
    
    $('.fermerpopup_exercices').each(function() {
        $(this).click(function() {
            $(this).parent('.active').removeClass('active').addClass('contenu-cacher');
            $(this).parent().parent().parent('.active').removeClass('active').addClass('contenu-cacher');
        });
    });
    
    $('#upload-qcm-file').on('change', function() {
        this.form.submit();
    });
    
});