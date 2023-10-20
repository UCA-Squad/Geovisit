<?php
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
?>
{{ Form::open(['route' => ['qcm::submit', 'id' => $qcm['id']], 'method' => 'POST', 'id' => 'qcm-form', 'class' => 'exercice']) }}
<div id="qcm-header">
    <h1 class="qcm-title exercice">{{ $qcm['titre'] }}</h1>
    <br><br>
    <div class="qcm-text exercice">{!! $qcm['description'] !!}</div>
    <span id="qcm-start" class="qcm-button exercice">COMMENCER</span>
</div>

<div id="qcm-body" style="display: none;">
    {{ Form::hidden('qcm-current-question', $qcm['questions'][0]['id'], ['id' => 'qcm-current-question']) }}
    {{ Form::hidden('qcm-id', $qcm['id'], ['id' => 'qcm-id']) }}
    {{ Form::select('qcm-questions-choice', $qcm['questions_list'], $qcm['questions'][0]['id'], ['id' => 'qcm-questions-choice', 'class' => 'exercice']) }}

    @foreach($qcm['questions'] as $question)
    <div id="question-{{ $question['id'] }}" class="exercice qcm-question-div" style="display: none;">
        <h3 class="qcm-title exercice">{{ $question['titre'] }}</h3>
        <p class="qcm-text exercice">{{ $question['question'] }}</p>
        <center>
            <table class="exercice">
                @foreach($question['answers'] as $answer)
                <tr class="exercice">
                    <td class="exercice">
                        {{ Form::checkbox('qcm-question-' . $question['id'] . '[]', 'answer-' . $answer['id'], false, ['id' => 'qcm-question-' . $question['id'] . '-answer-' . $answer['id'], 'class' => 'qcm-answer exercice']) }}
                    </td>
                    <td class="qcm-cell exercice">
                        {{ Form::label('qcm-question-' . $question['id'] . '-answer-' . $answer['id'], $answer['answer_title'], ['class' => 'qcm-text qcm-answer exercice']) }}
                    </td>  
                    <td class="exercice qcm-cell" id="qcm-question-{{ $question['id'] }}-answer-{{ $answer['id'] }}-corr"></td>
                    <td class="exercice qcm-cell" id="qcm-question-{{ $question['id'] }}-answer-{{ $answer['id'] }}-err"></td>
                </tr>
                @endforeach
            </table>
            <span class="exercice" id="qcm-question-{{ $question['id'] }}-corr"></span>
        </center>
    </div>
    @endforeach
    <span id="qcm-previous" class="qcm-button exercice" style="float: left;">QUESTION PRECEDENTE</span>
    <span id="qcm-next" class="qcm-button exercice" style="float: right;">QUESTION SUIVANTE</span>
    <br>
    <span id="qcm-submit" class="qcm-submit exercice">VALIDER VOS REPONSES</span>
</div>
<div id="qcm-error" class="exercice" style="display: none;">
    <p class="qcm-text exercice">Il est n&eacute;cessaire de r&eacute;pondre &agrave; toutes les questions du QCM pour le valider</p>
    <br>
    <span id='qcm-back' class="qcm-submit exercice" style="margin-top: 100px;">RETOURNER AU QCM</span>
</div>
<div id="qcm-result" class="exercice" style="display: none;">
    <div class="exercice" id="qcm-result-content">
        <p class="exercice qcm-msg" style="font-size: 45px;">Votre score est de <span id="qcm-result-percent" class="exercice"></span>&percnt;</p>
        <p class="exercice qcm-text">Vous avez r&eacute;pondu correctement &agrave; <span id="qcm-result-ok" class="exercice"></span> question(s) sur <span id="qcm-result-tot" class="exercice"></span></p>
    </div>
    <br><br>
    <span id="qcm-verif" class="qcm-submit exercice">RETOURNER AU QCM</span>
</div>

{{ Form::close() }}

<script>    
    $('#qcm-start').click(function() {
        $('#question-' + $('#qcm-current-question').val()).toggle();
        $('#qcm-header').toggle();
        $('#qcm-body').toggle();
    });

    $('#qcm-questions-choice').change(function (evt) {
        if ($('#question-' + $('#qcm-current-question').val()).is(":visible")) {
            $('#question-' + $('#qcm-current-question').val()).toggle();
        }
        $('#qcm-current-question').val($(this).val());
        $('#question-' + $(this).val()).toggle();
    });

    $('#qcm-next').click(function() {
        var newval = $('#qcm-questions-choice > option:selected').next().val();

        if (typeof(newval) !== 'undefined') {
            $('#qcm-questions-choice').val(newval).trigger('change');
        }
    });

    $('#qcm-previous').click(function() {
        var newval = $('#qcm-questions-choice > option:selected').prev().val();

        if (typeof(newval) !== 'undefined') {
            $('#qcm-questions-choice').val(newval).trigger('change');
        }
    });

    $('#qcm-back').click(function() {
        $('#qcm-body').toggle();
        $('#qcm-error').toggle();
    });

    $('#qcm-verif').click(function() {
        $('#qcm-body').toggle();
        $('#qcm-result').toggle();
    });

    $('#qcm-submit').click(function() {
        var dataString = $('#qcm-form').serialize();
        $.ajax({
            type: 'POST',
            url: host + '/qcm/submit/' + $('#qcm-id').val(),
            data: dataString,
            success: function(response) {
                var q = 1;
                var nb_ok = 0;

                response.correction.forEach(function (question) {
                    var nb_err = 0;                    
                    $('#qcm-question-' + question.id + '-corr').empty();

                    question.answers.forEach(function (answer) {
                        $('#qcm-question-' + question.id + '-answer-' + answer.id + '-err').empty();
                        if (answer.boolean) {
                            $('#qcm-question-' + question.id + '-answer-' + answer.id + '-corr').html('<p class="qcm-vrai exercice">VRAI</p>');
                            if (!$('#qcm-question-' + question.id + '-answer-' + answer.id).is(':checked')) {
                                $('#qcm-question-' + question.id + '-answer-' + answer.id + '-err').html('<p class="exercice qcm-text qcm-cell">Vous avez donn&eacute; une mauvaise r&eacute;ponse</p>');
                                nb_err++;
                            }
                        } else {
                            $('#qcm-question-' + question.id + '-answer-' + answer.id + '-corr').html('<p class="qcm-faux exercice">FAUX</p>');
                            if ($('#qcm-question-' + question.id + '-answer-' + answer.id).is(':checked')) {
                                $('#qcm-question-' + question.id + '-answer-' + answer.id + '-err').html('<p class="exercice qcm-text qcm-cell">Vous avez donn&eacute; une mauvaise r&eacute;ponse</p>');
                                nb_err++;
                            }
                        }
                    });

                    if (nb_err === 0) {
                        $('#qcm-question-' + question.id + '-corr').html('<p class="exercice qcm-msg">Vous avez r&eacute;pondu correctement &agrave; cette question.</p>');
                        nb_ok++;
                    } else {
                        $('#qcm-question-' + question.id + '-corr').html('<p class="exercice qcm-msg">Vous avez fait ' + nb_err + ' erreur' + (nb_err === 1 ? '' : 's') + ' sur cette question</p>');
                    }

                    q++;
                });

                $('#qcm-result-percent').html(Math.round(((nb_ok / response.nb) * 100.0) * 100) / 100);
                $('#qcm-result-ok').html(nb_ok);
                $('#qcm-result-tot').html(response.nb);

                $('#qcm-body').toggle();
                $('#qcm-result').toggle();
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    $('#qcm-body').toggle();
                    $('#qcm-error').toggle();
                }
            }
        });
    });
</script>