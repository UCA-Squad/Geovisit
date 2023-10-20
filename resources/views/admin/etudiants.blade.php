<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

@extends('admin.layouts.base')

@section('content')
<div class="row-fluid" style="padding: 0;">
    <div class="row" style="margin: 20px;">
        <h1 class="etapes-titre">MES ETUDIANTS ({{ $nbetds }})</h1>
        <h3 class="etapes-soustitre">AJOUTER UN NOUVEAU ETUDIANT</h3>
        <table class="admin-table-input-group">
            <td class="td-label">ETUDIANT</td>
            <td class="td-input">
                <a href="#" data-toggle="modal" data-target="#myModal">
                    Cliquer ici pour ajouter un nouveau &eacute;tudiant
                    <img src="{{ URL::asset('css/img/ICONE_PLUS.png') }}" style="float: right;">
                </a>
            </td>
            <td style="border-collapse: initial;">&nbsp;* </td>
        </table>
    </div>
    <div class="row" style="margin: 30px;">
        @if ($nbetds > 0)
        <table class="etudiant">
            <tr>
                <th>LOGIN</th>
                <th>N&deg;INE</th>
                <th>NOM</th>
                <th>PRENOM</th>
                <th>CONTACT</th>
                <th></th>
                <th></th>
            </tr>
            @foreach ($etds as $etd)
            <tr>
                <td>{{ $etd->user->username }}</td>
                <td>{{ $etd->ine }}</td>
                <td>{{ $etd->user->nom }}</td>
                <td>{{ $etd->user->prenom }}</td>
                <td>{{ $etd->user->email }}</td>
                <td>
                    <a href="{{ route('admin::etudiants::edit', ['etd' => $etd->id]) }}">
                        <img src="{{ URL::asset('img/crayon2.png') }}" />
                    </a>
                </td>
                <td>
                    <img src="{{ URL::asset('img/corbeille2.png') }}" style="cursor: pointer;" 
                         data-toggle="confirmation" data-btn-ok-label="Oui" data-btn-cancel-label="Non!"
                         title="voulez-vous supprimer cet &eacute;tudiant?"
                         data-href="{{ route('admin::etudiants::delete', ['etd' => $etd->id]) }}"
                         />
                </td>
            </tr>
            @endforeach
        </table>
        @endif

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                onclick="javascript:window.location = '{{ url('admin/etudiants') }}'">
                            <span aria-hidden="true">&times;</span>
                        </button>   
                        <h1 class="etapes-titre">NOUVEAU &Eacute;TUDIANT</h1>
                    </div>
                    <div class="modal-body">
                        @if ($errors->any())
                        <script>
                            $(document).ready(function () {
                                $('#myModal').modal();
                            });
                        </script>                        
                        <div class="alert alert-danger" align="center">
                            {{ $errors->first('username') }}<br>
                            {{ $errors->first('ine') }}<br>
                            {{ $errors->first('nom') }}<br>
                            {{ $errors->first('prenom') }}<br>
                            {{ $errors->first('email') }}
                        </div>
                        @endif
                        {{ Form::open(['route' => 'admin::etudiants::create', 'method' => 'post', 'id' => 'formetud']) }}
                        <div class="table-responsive" style="width: 100%;">
                            <table class="headertable" id="etudiants">
                                <tr>
                                    <th>LOGIN</th>
                                    <th>N&deg;INE</th>
                                    <th>NOM</th>
                                    <th>PRENOM</th>
                                    <th>CONTACT</th>
                                </tr>
                                <tr>
                                    <td>
                                        {{ Form::text('username', old('username'), ['placeholder' => 'Login', 'style' => ($errors->has('username') ? 'border: 1px solid #A94442' : '')]) }}
                                    </td>
                                    <td>
                                        {{ Form::text('ine', old('ine'), ['placeholder' => 'numero INE', 'style' => ($errors->has('ine') ? 'border: 1px solid #A94442' : '')]) }}
                                    </td>
                                    <td>
                                        {{ Form::text('nom', old('nom'), ['placeholder' => 'Nom', 'style' => ($errors->has('nom') ? 'border: 1px solid #A94442' : '')]) }}
                                    </td>
                                    <td>
                                        {{ Form::text('prenom', old('prenom'), ['placeholder' => 'Pr&eacute;nom', 'style' => ($errors->has('prenom') ? 'border: 1px solid #A94442' : '')]) }}
                                    </td>
                                    <td>
                                        {{ Form::text('email', old('email'), ['placeholder' => 'Email', 'style' => ($errors->has('email') ? 'border: 1px solid #A94442' : '')]) }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="row" align="center" style="margin-top: 20px;">
                            {{ Form::submit('TERMINER', ['class' => 'submitprofil action-button']) }}
                        </div>
                        {{ Form::close() }}
                    </div>
                    <div class="modal-footer" align="center">                    
                    </div>
                </div>
            </div>
        </div>
        {{ Form::open(['method' => 'post', 'id' => 'delete', 'style' => 'display: none;']) }}
            {{ Form::hidden('_method', 'DELETE') }}
        {{ Form::close() }}        
    </div>
</div>
@endsection

@section('filescripts')
{{ Html::script(asset('js/bootstrap/bootstrap-confirmation.min.js')) }}
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('[data-toggle=confirmation]').confirmation({
            onConfirm: function() {
                $.ajax({
                    method: 'post',
                    url: $(this).attr('data-href'),
                    data: $('#delete').serialize(),
                    dataType: 'json'
                }).done(function(data) {
                    $(location).attr('href', "{{ url('admin/etudiants') }}");
                }).fail(function(data) {
                    $(location).attr('href', "{{ url('admin/etudiants') }}");
                });                
            }
        });
    });
</script>
@endsection
