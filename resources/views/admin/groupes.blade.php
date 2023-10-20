@extends('admin.layouts.base')

@section('content')

<div class="row-fluid" style="padding:0;">
    <div class="row" style="margin:20px;">
        <h1 class="etapes-titre">MES GROUPES ({{ $nbgroupes }})</h1>
        <h3 class="etapes-soustitre">AJOUTER UN NOUVEAU GROUPE</h3>
        <table class="admin-table-input-group">
            <td class="td-label">GROUPE</td>
            <td class="td-input">
                <a href="#" id="btn_groupe" data-toggle="modal" data-target="#myModal">Cliquer ici pour ajouter un  nouveau groupe<img src="{{URL::asset('css/img/ICONE_PLUS.png') }}" style="float:right;"></a>
            </td><td style="border-collapse:initial; "> * </td>
        </table>
    </div>
    @if ($nbgroupes > 0)
    <div class="row" style="margin:20px;">
        @foreach ($groupes as $groupe)
        <div class="panel-group">
            <div class="panel" id="paneladmin">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <span style="width:300px;display: inline-block;">Groupe {{$groupe->titre}}</span>|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nb d’étudiant : {{$groupe->etudiants()->count()}}
                        <img src="{{URL::asset('img/corbeille.png') }}" style="float:right;margin-left:40px;cursor:pointer" data-toggle="confirmation" data-btn-ok-label="Oui" data-btn-cancel-label="Non!" title="Voulez-vous supprimer ce groupe?" data-href="{{ route('groupe.destroy', $groupe->id) }}"/> 
                        <a href="{{ route('groupe.edit', $groupe->id) }}"><img src="{{URL::asset('img/crayon.png') }}" style="float:right;margin-left:40px"/></a> 
                        <a data-toggle="collapse" href="#collapse{{$groupe->id}}"><img src="{{URL::asset('img/show.png') }}" style="float:right;"/></a>
                    </h4>
                </div>
                <div id="collapse{{$groupe->id}}" class="panel-collapse collapse {{ (session('affich')==$groupe->id) ? ' in' : ''}}">
                    <div class="panel-body">
                        @if($groupe->etudiants()->count() > 0)
                        <table class="etudiant"> <tr>
                                <th>LOGIN</th>
                                <th>N° D’ETUDIANT</th>
                                <th>NOM</th>		
                                <th>PRENOM</th>
                                <th>CONTACT</th>
                            </tr>
                            @foreach ($groupe->etudiants()->get() as $etudiant)
                            @foreach ($etudiant->user()->get() as $etudiantdetail)
                            <tr>
                                <td>{{ $etudiantdetail->username }}</td>
                                <td>{{ $etudiant->ine }}</td>
                                <td>{{ $etudiantdetail->nom }}</td>
                                <td>{{ $etudiantdetail->prenom }}</td>
                                <td>{{ $etudiantdetail->email }}</td>
                            </tr>
                            @endforeach
                            @endforeach
                        </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="javascript:window.location ='{{url('admin/groupes')}}'"><span aria-hidden="true">&times;</span></button>
                <h1 class="etapes-titre">NOUVEAU GROUPE</h1>
            </div>
            <div class="modal-body">

                @if ($errors->any())
                <script>
                    $(document).ready(function () {
                        $('#myModal').modal();
                    });
                </script>                        
                <div class="alert alert-danger" align="center">
                    {{ $errors->first('titre') }}
                </div>
                @endif

                {{ Form::open(['route' => 'groupe.create', 'method' => 'post', 'id' => 'formgroupe']) }}
                <h3 class="etapes-soustitre">NOM DU GROUPE</h3>
                <table class="admin-table-input-group">
                    <tr>
                        <td class="td-label">GROUPE</td>
                        <td>
                            {{ Form::text('titre', old('titre'), ['id' => 'titreg', 'placeholder' => 'Saisir un nom pour le groupe', 'class' => 'table-admin-inputtext', 'style' => ($errors->has('titre') ? 'border: 1px solid #A94442 !important;' : '')]) }}
                        </td>
                        <td style="border-collapse:initial; ">&nbsp;* </td>
                    </tr>
                </table>
                <h3 class="etapes-soustitre">AJOUT DES MEMBRES</h3>
                <table id='etudiants-list' class="table table-striped table-bordered" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>LOGIN</th>
                            <th>N&deg;INE</th>
                            <th>NOM</th>
                            <th>PRENOM</th>
                            <th>EMAIL</th>
                            <th>AJOUTER</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($etds as $etd)
                        <tr>
                            <td>{{ $etd->user->username }}</td>
                            <td>{{ $etd->ine }}</td>
                            <td>{{ $etd->user->nom }}</td>
                            <td>{{ $etd->user->prenom }}</td>
                            <td>{{ $etd->user->email }}</td>
                            <td>{{ Form::checkbox('etudiants[]', $etd->id, ((is_array(old('etudiants')) && in_array($etd->id, old('etudiants'))) ? true : false)) }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
@endsection

@section('styles')
<style>
    .sr-only{
        position:relative; 
        color: #a94442;
        white-space: nowrap;
    }
    .error td{
        border: 1px solid #a94442; 
    }
    .panel{
        font-family: 'Lato', sans-serif; 
        font-weight: 700px; 
        font-size:16px; 
    }
    .panel-heading { 
        color:white;    
        background-color: #f96332;
        padding: 20px;
    }
    .modal-content{
        padding:20px;
    }
    #etudiants {
        counter-reset: rowNumber;
    }
    #etudiants tr:not(:first-child){
        counter-increment: rowNumber;
    }
    #etudiants tr td:first-child::before {
        content: counter(rowNumber);
        min-width: 1em;
        margin-right: 0.5em;
    }
    #myModal .table-responsive{
        max-height:400px;  
    }
    .panel .popover-title{
        color:#000;
    }
    .ui-autocomplete{
        z-index:2147483647; max-height:150px;overflow:auto;
    }
</style>
@endsection

@section('filescripts')
{{ Html::script(asset('js/bootstrap/bootstrap-confirmation.min.js')) }}
@endsection	

@section('scripts')
<script>
    $(document).ready(function () {
        
        var table = $('#etudiants-list').DataTable({
            scrollY: "200px",
            pageLength: -1,
            bPaginate: false,
            bLengthChange: false
        });
        
        $( "#myModal" ).on('shown.bs.modal', function(){
            table.columns.adjust().draw();
        });
        
        $('[data-toggle=confirmation]').confirmation({onConfirm: function () {                
                $.ajax({
                    url: $(this).attr('data-href'),
                    type: 'DELETE',
                    data: $('#delete').serialize(),
                    success: function (result) {
                        $(location).attr('href', '{{url("admin/groupes")}}');
                    }
                });
            }
        });
        
    });
</script>
@endsection