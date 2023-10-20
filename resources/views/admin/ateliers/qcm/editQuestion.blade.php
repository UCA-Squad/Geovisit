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

@extends('admin.layouts.base')

@section('filescripts')
{{ Html::style(asset('css/admin/admin.css')) }}
{{ Html::script(asset('js/admin/qcm.js')) }}
{{ Html::script(asset('js/bootstrap/bootstrap-confirmation.min.js')) }}
@endsection

@section('content')
<div class="row" style="margin: 0px;padding: 0px;top: 0px;">
    <ul id="menu_fonctions">
        <li>
            <a class="menufonction-visited" href="#">Editeur de QCM</a>
        </li>
    </ul>
</div>
<div class="fields">
    <div id="import-export-qcm" class="row">
        <h1 class="etapes-titre">IMPORTER / EXPORTER UN QCM</h1>
        <br>
        <div class="col-lg-6">
            {{ Form::open(array('route' => ['admin::qcm::import', $id_exercice, $qcm->id], 'method' => 'post', 'files' => true)) }}
            <div style="text-align: center;">
                <div class="fichier" style="width: 50%;" class="{{ $errors->has('qcm-file') ? 'has-error' : ''}}">
                    {{ Form::file('qcm-file', ['id' => 'upload-qcm-file', 'accept' => '.xls, .xlsx, .csv, .ods', 'style' => 'width: 50%;cursor: pointer;height: 100%;margin-top: -20px;margin-left: -10px;']) }}
                    <span>IMPORTER UN FICHIER</span>
                </div>
                <small class='error-msg'>{{ $errors->first('qcm-file', ':message') }}</small>
            </div>
            {{ Form::close() }}
        </div>
        <div class="col-lg-6">
            {{ Form::open(array('route' => ['admin::qcm::export', $id_exercice, $qcm->id], 'method' => 'post')) }}
            <div style="text-align: center;">
                {{ Form::submit('EXPORTER LE QCM', ['class' => 'qcm-export']) }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
<div class="fields">
    <div id="forms" class="double_col row">
        <div class="col-lg-10">

            <h1 class="etapes-titre">CHOISIR UNE QUESTION</h1>
            {{ Form::open(array('route' => ['admin::qcm::edit::questions::select', $id_exercice, $qcm->id], 'method' => 'post')) }}
            {{ Form::hidden('qcm-question-id', is_null($question) ? 'new' : $question->id, ['id' => 'qcm-question-id']) }}
            <table class="admin-table-input-group">
                <td class="td-label">QUESTION</td>
                <td class="td-input {{ $errors->has('question-selected') ? 'has-error' : '' }}">
                    {{ Form::select('question-selected', $selectQuestions, is_null($question) ? 'new' : $question->id, ['id' => 'select-question']) }}
                </td>
                <td style="border-collapse: initial;"> * </td>
            </table>
            <small class="error-msg">{{ $errors->first('question-selected', ':message') }}</small>
            {{ Form::close() }}
            <br><br>

            @if (is_null($question))
            {{ Form::open(array('route' => ['admin::qcm::edit::questions::new', $id_exercice, $qcm->id], 'method' => 'post')) }}
            @else
            {{ Form::open(array('route' => ['admin::qcm::edit::questions::modif', $id_exercice, $qcm->id, $question->id], 'method' => 'post')) }}
            @endif

            <h3 class="etapes-soustitre">TITRE DE LA QUESTION</h3>
            <table class="admin-table-input-group">
                <td class="td-label">TITRE</td>
                <td class="td-input {{ $errors->has('question-title') ? 'has-error' : '' }}">
                    {{ Form::input('text', 'question-title', is_null($question) ? null : $question->titre, ['class' => 'table-admin-inputtext', 'placeholder' => 'Le titre de la question']) }}
                </td>
                <td style="border-collapse: initial;"> * </td>
            </table>
            <small class='error-msg'>{{ $errors->first('question-title', ':message') }}</small>
            <br>
            <h3 class="etapes-soustitre">LA QUESTION</h3>
            <table class="admin-table-input-group">
                <td class="td-label">QUESTION</td>
                <td class="td-input {{ $errors->has('question-question') ? 'has-error' : '' }}">
                    {{ Form::textarea('question-question', is_null($question) ? '' : $question->question, ['class' => 'table-admin-inputtext', 'placeholder' => 'Ecrivez ici votre question']) }}
                </td>
                <td style="border-collapse: initial;"> * </td>
            </table>
            <small class='error-msg'>{{ $errors->first('question-question', ':message') }}</small>
            <br>

            <h3 class="etapes-soustitre">LES R&Eacute;PONSES</h3>
            {{ Form::hidden('qcm-nb-answer', is_null($question) ? 0 : $question-> answers()-> count(), ['id' => 'qcm-nb-answer']) }}
            <table id="qcm-table-answer" class="admin-table-input-group {{ count(preg_grep('/answer/', array_keys($errors->getMessages()))) > 0 ? 'has-error' : '' }}">
                @if (!is_null($question))
                @foreach ($question->answers()->get() as $key => $answer)
                <tr class='answer-{{ $key }}'>
                    <td class="td-label">R&Eacute;PONSE N&deg;{{ $key + 1 }}</td>
                    <td class="td-input">
                        {{ Form::input('text', 'question-answer[' . $question->id . '][' . $key . '][' . $answer->id . ']', $answer->answer_title, ['class' => 'table-admin-inputtext']) }}
                    </td>
                    <td class="td-input">
                        <fieldset>
                            {{ Form::label('VRAI' . $key, '&nbsp;VRAI') }}
                            {{ Form::radio('question-answer-boolean-[' . $question->id . '][' . $key . '][' . $answer->id . ']', 1, $answer->answer_boolean, ['id' => 'VRAI' . $key, 'class' => 'radio-group']) }}
                            {{ Form::radio('question-answer-boolean-[' . $question->id . '][' . $key . '][' . $answer->id . ']', 0, !$answer->answer_boolean, ['id' => 'FAUX' . $key, 'class' => 'radio-group']) }}
                            {{ Form::label('FAUX' . $key, '&nbsp;FAUX') }}
                        </fieldset>
                    </td>
                    <td style="border-collapse: initial;"> *&nbsp;
                        <img src="{{ URL::asset('img/corbeille2.png') }}" style="cursor: pointer;position: absolute;"
                             data-toggle="confirmation" data-btn-ok-label="Oui" data-btn-cancel-label="Non!"
                             title="Voulez-vous supprimer cette réponse ? ATTENTION: cela entraine la perte de toute autre modification en cours"
                             data-href="{{ route('admin::qcm::edit::questions::answers::delete', ['exercice_id' => $id_exercice, 'id' => $qcm->id, 'id_question' => $question->id, 'id_answer' => $answer->id]) }}"
                             />
                    </td>
                </tr>
                @endforeach
                @if (!is_null(old('question-answer.' . $question->id)))
                @foreach(array_diff_key(old('question-answer.' . $question->id), $question->answers()->get()->toArray()) as $key => $answer)
                <tr class="answer-{{ $key}}">
                    <td class="td-label">R&Eacute;PONSE N&deg;{{ $key }}</td>
                    <td class="td-input">
                        {{ Form::input('text', 'question-answer[' . $question->id . '][' . $key . '][new]', old('question-answer.' . $question->id . '.' . $key . '.new'), ['class' => 'table-admin-inputtext']) }}
                    </td>
                    <td class="td-input">
                        <fieldset>
                            {{ Form::label('VRAI' . $key, '&nbsp;VRAI') }}
                            {{ Form::radio('question-answer-boolean-[' . $question->id . '][' . $key . '][new]', 1, old('question-answer-boolean-.' . $question->id . '.' . $key . '.new') === 1 ? true : false, ['id' => 'VRAI' . $key, 'class' => 'radio-group']) }}
                            {{ Form::label('FAUX' . $key, '&nbsp;FAUX') }}
                            {{ Form::radio('question-answer-boolean-[' . $question->id . '][' . $key . '][new]', 0, old('question-answer-boolean-.' . $question->id . '.' . $key . '.new') === 0 ? true : false, ['id' => 'FAUX' . $key, 'class' => 'radio-group']) }}
                        </fieldset>
                    </td>
                    <td style="border-collapse: initial;"> * <a href="#answer" class="answer-delete answer-{{ $key }}"><img src="{{ URL::asset('img/corbeille2.png') }}"></a></td>
                </tr>
                @endforeach
                @endif
                @elseif (!is_null(old('question-answer.new')))
                @foreach (old('question-answer.new') as $key => $answer)
                <tr class="answer-{{ $key }}">
                    <td class="td-label">R&Eacute;PONSE N&deg;{{ $key }}</td>
                    <td class="td-input">
                        {{ Form::input('text', 'question-answer[new][' . $key . '][new]', old('question-answer.new.' . $key . '.new'), ['class' => 'table-admin-inputtext']) }}
                    </td>
                    <td class="td-input">
                        <fieldset>
                            {{ Form::label('VRAI' . $key, '&nbsp;VRAI') }}
                            {{ Form::radio('question-answer-boolean-[new][' . $key . '][new]', 1, old('question-answer-boolean-.new.' . $key . '.new') === 1 ? true : false , ['id' => 'VRAI' . $key, 'class' => 'radio-group']) }}
                            {{ Form::label('FAUX' . $key, '&nbsp;FAUX') }}
                            {{ Form::radio('question-answer-boolean-[new][' . $key . '][new]', 0, old('question-answer-boolean-.new.' . $key . '.new') === 0 ? true : false, ['id' => 'FAUX' . $key, 'class' => 'radio-group']) }}
                        </fieldset>
                    </td>
                    <td style="border-collapse: initial;"> * <a href="#answer" class="answer-delete answer-{{ $key }}"><img src="{{ URL::asset('img/corbeille2.png') }}"></a></td>
                </tr>
                @endforeach
                @endif
            </table>
            <a href="#answer" name='answer' class="qcm-add-answer-link" onclick="addNewAnswer();">Cliquez-ici pour ajouter une autre r&eacute;ponse</a>
            @foreach ($errors->getMessages() as $k => $msg)
                @if (preg_match('/answer/', $k))
                <br>
                <small class="error-msg">{{ $msg[0] }}</small>
                @endif
            @endforeach
            <br><br>
            {{ Form::submit(is_null($question) ? 'CREER UNE QUESTION' : 'MODIFIER LA QUESTION', ['class' => 'liens_gerer action-button', 'value' => 'modifier', 'name' => 'valider', 'style' => 'width: 200px;']) }}
            {{ Form::close() }}
        </div>

        @if (!is_null($question))
        {{ Form::open(['route' => ['admin::qcm::edit::questions::delete', $id_exercice, $qcm->id, $question->id], 'method' => 'delete', 'onsubmit' => 'return confirm("Confirmer la suppression ?")', 'class' => 'col-sm-1', 'style' => 'magin-top: 20px;']) }}
        {{ Form::submit('SUPPRIMER LA QUESTION', ['class' => 'liens_gerer action-button', 'value' => 'supprimer', 'name' => 'valider', 'style' => 'width: 200px;']) }}
        {{ Form::close() }}
        @endif

    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {        
        $('[data-toggle=confirmation]').confirmation({
            onConfirm: function() {
                $.ajax({
                    method: 'post',
                    url: $(this).attr('data-href'),
                    data: {
                        _method: 'delete'
                    },
                    headers: {
                        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json'
                }).done(function(data) {
                    $(location).attr('href', "{{ route('admin::qcm::edit::questions::get::id', ['exercice_id' => $id_exercice, 'id' => $qcm->id, 'id_question' => is_null($question) ? 'new' : $question->id]) }}");
                }).fail(function(data) {
                    $(location).attr('href', "{{ route('admin::qcm::edit::questions::get::id', ['exercice_id' => $id_exercice, 'id' => $qcm->id, 'id_question' => is_null($question) ? 'new' : $question->id]) }}");
                });
            }
        });
    });
</script>
@endsection

