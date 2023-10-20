@extends('admin.layouts.base')


@section('content')
<div class="row-fluid" style="padding:0;">
    <div class="row" style="margin:20px;">
        <h1 class="etapes-titre">MES ENSEIGNANTS ({{ $nbprofs }})</h1>
        <h3 class="etapes-soustitre">AJOUTER UN NOUVEAU ENSEIGNANT</h3>
        <table class="admin-table-input-group">
            <td class="td-label">ENSEIGNANT</td>
            <td class="td-input">
                <a href="#" id="btn_groupe" data-toggle="modal" data-target="#myModal">
                    Cliquer ici pour ajouter un  nouveau enseignant<img src="{{URL::asset('css/img/ICONE_PLUS.png') }}" style="float:right;"></a>
            </td><td style="border-collapse:initial; "> * </td>
        </table>
    </div>
    <div class="row" style="margin:30px">
        @if ($nbprofs > 0)
        <table class="etudiant">
            <tr>

                <th>LOGIN</th>
                <th>NOM</th>		
                <th>PRENOM</th>
                <th>CONTACT</th>
                <th></th>
                <th></th>	
            </tr>
            @foreach ($profs as $prof)
            <tr>
                <td>{{$prof->user->username}}</td><td>{{$prof->user->nom}}</td><td>{{$prof->user->prenom}}</td><td>{{$prof->user->email}}</td>
                <td><a href="{{ route('prof.edit', array('prof' => $prof->id)) }}"><img src="{{URL::asset('img/crayon2.png') }}" /></a></td>

                @if ($prof->user->is_admin === 0)
                <td> <img src="{{URL::asset('img/corbeille2.png') }}" style="cursor:pointer" data-toggle="confirmation" data-btn-ok-label="Oui" data-btn-cancel-label="Non!" title="Voulez-vous supprimer ce enseignant?" data-href="{{ route('prof.destroy', array('prof' => $prof->id)) }}"/> </td>	
                @endif
            </tr>							
            @endforeach
        </table>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="javascript:window.location = '{{url('admin/professeur')}}'"><span aria-hidden="true">&times;</span></button>
                        <h1 class="etapes-titre">NOUVEAU ENSEIGNANT</h1>
                    </div>
                    <div class="modal-body">
                        @if ($errors->any())
                        <script>
                            $(document).ready(function () {
                                $('#myModal').modal();
                            });
                        </script>
                        @endif
                        @if ($errors->has('username') || $errors->has('nom') || $errors->has('prenom') || $errors->has('email'))
                        <div class="alert alert-danger" align="center">

                            @if ($errors->has('username'))
                            {{$errors->first('username') }}<br/>
                            @endif
                            @if ($errors->has('nom'))
                            {{$errors->first('nom') }}<br/>
                            @endif
                            @if ($errors->has('prenom'))
                            {{$errors->first('prenom') }}<br/>
                            @endif
                            @if ($errors->has('email'))
                            {{$errors->first('email') }}<br/>
                            @endif
                        </div>
                        @endif
                        <form method="POST" action="{{route('prof.create')}}" id="formprof">
                            {!! csrf_field() !!}
                            <div class="table-responsive" style="width:100%" align="center">
                                <table  class="headertable" id="etudiants">
                                    <tr>
                                        <th>LOGIN</th>
                                        <th>NOM</th>		
                                        <th>PRENOM</th>
                                        <th>CONTACT</th>
                                    </tr>
                                    @if(!is_null(old('username')))
                                    <tr>
                                        <td><input type="text" name="username" class="username" value="{{old('username')}}" laceholder="Login" {!! $errors->has('username') ? 'style="border: 1px solid #a94442"' : '' !!}/></td>
                                        <td><input type="text" name="nom" value="{{old('nom')}}" placeholder="Nom" {!! $errors->has('nom') ? 'style="border: 1px solid #a94442"' : '' !!}/></td>		
                                        <td><input type="text" name="prenom" value="{{old('prenom')}}" placeholder="PRENOM" {!! $errors->has('prenom') ? 'style="border: 1px solid #a94442"' : '' !!}/></td>
                                        <td><input type="text" name="email" value="{{old('email')}}" placeholder="Contact" {!! $errors->has('email') ? 'style="border: 1px solid #a94442"' : '' !!}/></td>

                                        </td>
                                    </tr>
                                    @else
                                    <tr>
                                        <td><input type="text" name="username" class="username" placeholder="Login" /></td>
                                        <td><input type="text" name="nom" placeholder="Nom" /></td>		
                                        <td><input type="text" name="prenom" placeholder="PRENOM" /></td>
                                        <td><input type="text" name="email" placeholder="Contact" /></td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                            <div class="row" align="center" style="margin-top:20px">      <input type="submit" class="submitprofil action-button" value="TERMINER"/></div> 
                        </form>
                    </div>
                    <div class="modal-footer" align="center"> 
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="" accept-charset="UTF-8" style="display:none" id="delete">
            {!! csrf_field() !!}

            <input name="_method" type="hidden" value="DELETE">
        </form>
        @endif
    </div>
</div>
@endsection

@section('filescripts')
{{ Html::script(asset('js/bootstrap/bootstrap-confirmation.min.js')) }}
@endsection	

@section('scripts')
<script>
    $(document).ready(function () {
        $('[data-toggle=confirmation]').confirmation({onConfirm: function () {
                $.ajax({
                    method: 'post',
                    url: $(this).attr('data-href'),
                    data: $('#delete').serialize(),
                    dataType: "json"})

                        .done(function (data) {
                            $(location).attr("href", "{{url('admin/professeur')}}");
                        })
                        .fail(function (data) {
                            $(location).attr("href", "{{url('admin/professeur')}}");
                        });

            }});
    });
</script>
@endsection