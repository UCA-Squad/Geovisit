@extends('admin.layouts.base')
@section('filescripts')
{{ Html::script(asset('js/popups_admin.js')) }}
{{ Html::script(asset('js/etapes_admin.js')) }}
{{ Html::script(asset('js/editeur_admin.js')) }}
{{ Html::script(asset('js/qcm_admin.js')) }}
{{ Html::script(asset('js/uploads.js')) }}
{{ Html::script(asset('js/geovisit_uploader.js')) }}
@endsection

@section('content')

<div id="profils" class="row-fluid" style="padding:0;">
    <h1 class="etapes-titre">INFORMATION</h1>
    <fieldset class="fields" style="text-align: center;">
        @if (session('successprofil'))
        <div class="alert alert-success">
            {{ session('successprofil') }}
        </div>
        @endif
        {{ Form::open(['route' => 'infoprofil', 'method' => 'POST', 'class' => 'profil_form', 'id' => 'profil_form1']) }}
            <div style="width:50%; display:inline; margin-right:20px; float:left;">
                <div class="form-group{{ $errors->has('nom') ? ' has-error has-feedback' : '' }}" >
                    {{ Form::label('nom', 'Nom', ['class' => 'labels_profils']) }}
                    {{ Form::text('nom', old('nom') !== null ? old('nom') : $nom, ['id' => 'nom', 'class' => 'form-control']) }}
                    @if ($errors->has('nom'))
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    <span  class="sr-only">{{ $errors->first('nom') }}</span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('prenom') ? ' has-error has-feedback' : '' }}" >
                    {{ Form::label('prenom', 'Prénom', ['class' => 'labels_profils']) }}
                    {{ Form::text('prenom', old('prenom') !== null ? old('prenom') : $prenom, ['id' => 'prenom', 'class' => 'form-control']) }}
                    @if ($errors->has('prenom'))
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    <span  class="sr-only">{{ $errors->first('prenom') }}</span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error has-feedback' : '' }}" >
                    {{ Form::label('email', 'Contact', ['class' => 'labels_profils']) }}
                    {{ Form::text('email', old('email') !== null ? old('email') : $email, ['id' => 'email', 'class' => 'form-control']) }}
                    @if ($errors->has('email'))
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    <span  class="sr-only">{{ $errors->first('email') }}</span>
                    @endif
                </div>	
            </div>
            <div style="width:40%; display:inline;float:left;">
                <label class="labels_profils">Photo</label>
                <div class="circle_img_profils">
                    @if (isset($avatar_url))
                    <img src="{{ asset($avatar_url) }}">
                    @else
                    <img src="{{ asset('/css/img/PROFIL_AVATAR.png') }}">
                    @endif
                </div>
                <a href="#" id="photo-profil-lien" style="text-decoration:none; color:#f96332;">Editer photo</a>
            </div>
            <div style="display:block;float:left;width:100%; padding-top:30px">
                {{ Form::submit('MODIFIER', ['class' => 'submit action-button']) }}
            </div>
        {{ Form::close() }}
    </fieldset>

    <h1 class="etapes-titre">CONNEXION</h1>
    <fieldset class="fields">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        {{ Form::open(['route' => 'infoconnexion', 'method' => 'POST', 'class' => 'profil_form', 'id' => 'profil_form2']) }}
            {{ Form::hidden('modif', '', ['id' => 'typemodif']) }}

            <div style="width:100%; float:left;" >
                <div class="loginback form-group" >
                    {{ Form::label('username', 'Login', ['class' => 'labels_profils']) }}
                    <div style="width:340px; float:left;" class="input-append">
                        {{ Form::text('username', old('username') !== null ? old('username') : $username, ['id' => 'username', 'class' => 'form-control', 'style' => 'display:inline-block;width:300px;']) }}
                        <button type="button" id="btlogin" class="btn btn-default btn-sm" style="height:34px; border:none">
                            <span class="glyphicon glyphicon-pencil" title="modifier"></span> 
                        </button>
                    </div>
                </div>
                <div class="login form-group{{ $errors->has('username') ? ' has-error has-feedback' : '' }} " style="display:none">
                    {{ Form::label('username', 'Login', ['class' => 'labels_profils']) }}	
                    <div style="width:340px; float:left;" class="input-append">
                        {{ Form::text('username', old('username') !== null ? old('username') : $username, ['id' => 'username', 'class' => 'form-control', 'style' => 'display:inline-block;width:300px;']) }}
                        <button type="button" id="btloginback" class="btn btn-default btn-sm" style="height:34px; border:none">
                            <span class="glyphicon glyphicon-share-alt" title="annuler"></span> 
                        </button>
                        @if ($errors->has('username'))
                        <span  class="sr-only">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group" id="mdp">
                    {{ Form::label('password', 'Mot de passe', ['class' => 'labels_profils']) }} 
                    <div style="width:340px; float:left;" class="input-append">
                        {{ Form::password('password', ['class' => 'form-control', 'style' => 'display:inline-block;width:300px', 'placeholder' => 'Cliquez sur le crayon pour modifier']) }}
                        <button type="button" id="btmodmdp" class="btn btn-default btn-sm" style="height:34px; border:none">
                            <span class="glyphicon glyphicon-pencil" title="modifier"></span> 
                        </button>
                    </div>
                </div>
                <div class="mdp form-group{{ $errors->has('password') ? ' has-error has-feedback' : '' }}" style="display:none">
                    <div style="width:340px; " class="input-append">
                        {{ Form::label('password', 'Mot de passe actuel', ['class' => 'labels_profils', 'style' => 'margin-left:-40px;']) }}
                        {{ Form::password('password', ['class' => 'form-control', 'style' => 'display:inline-block;width:300px;', 'placeholder' => 'Entrez votre mot de passe actuel']) }}
                        <button type="button" id="btmdpback" class="btn btn-default btn-sm" style="height:34px; border:none">
                            <span class="glyphicon glyphicon-share-alt" title="annuler"></span> 
                        </button>
                        @if ($errors->has('password'))
                        <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                        <span  class="sr-only">{{ $errors->first('password') }}</span>
                        @else

                        @endif
                    </div>
                </div>
                <div class="mdp form-group{{ $errors->has('new_password') ? ' has-error has-feedback' : '' }}" style="display:none">
                    {{ Form::label('new_password', 'Nouveau mot de passe', ['class' => 'labels_profils']) }}
                    {{ Form::password('new_password', ['class' => 'form-control', 'id' => 'new_password', 'placeholder' => 'Entrez votre nouveau mot de passe']) }}
                    @if ($errors->has('new_password'))
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    <span  class="sr-only">{{ $errors->first('new_password') }}</span>
                    @endif
                </div>

                <div class="mdp form-group{{ $errors->has('new_password_confirmation') ? ' has-error has-feedback' : '' }}" style="display:none">
                    {{ Form::label('new_password_confirmation', 'Confirmation du nouveau mot de passe', ['class' => 'labels_profils', 'style' => 'white-space: nowrap;margin-left:-15px;']) }}
                    {{ Form::password('new_password_confirmation', ['class' => 'form-control', 'id' => 'new_password_confirmation', 'placeholder' => 'Confirmez votre nouveau mot de passe']) }}
                    @if ($errors->has('new_password_confirmation'))
                    <span class="glyphicon glyphicon-remove form-control-feedback"></span>
                    <span  class="sr-only">{{ $errors->first('new_password_confirmation') }}</span>
                    @endif
                </div>
                <br/><br/><br/><br/>
                <input type="submit" name="submit" class="submit action-button" value="MODIFIER" id="mod" style="display:none"/></div>
            </div>
        {{ Form::close() }}
    </fieldset>

    <h1 class="etapes-titre" align="center">STATISTIQUES</h1>
    <fieldset class="fields">
        <div id="bloc-infos" style="padding:auto; width:100%; border:none;" align="center">
            <ul style="margin:auto;">
                <li style="width:25%;">
                    <p class="chiffre-info">{{$tpns}}</p>
                    <p class="type-info">TP NUMERIQUES</p>
                </li>
                <li style="width:25%;">
                    <p class="chiffre-info">{{$exercices}}</p>
                    <p class="type-info">exercices</p>
                </li>
                <li style="width:25%;">
                    <p class="chiffre-info">{{$nbfichier}}</p>
                    <p class="type-info">fichiers</p>
                </li>
                <li style="width:25%;">
                    <p class="chiffre-info">{{$classes}}</p>
                    <p class="type-info">groupes</p>
                </li>
            </ul>
        </div>
    </fieldset>
</form>
</div>

@endsection
@section('style')
.has-feedback label~.form-control-feedback {
top: 55px;
}
.sr-only{position:relative; color: #a94442;top:10px}
.form-group{width:300px; margin:auto; text-align: center;}
.form-control{ width:300px; margin:auto; text-align: center;}
@endsection

@section('scripts')

@if ($errors-> has('username'))
<script>
$(".login").show();
$("#btlogin").parent().parent().hide();
$("#mdp").hide();
$("#mod").show();
$("#typemodif").val('username');
</script>
@endif

@if ($errors-> has('password') || $errors->has('new_password') || $errors-> has('new_password_confirmation'))
<script>
    $(".mdp").show();
    $("#btlogin").parent().parent().hide();
    $("#mdp").hide();
    $("#mod").show();
    $("#typemodif").val('password');
</script>
@endif


<script>
    $("#btlogin").click(function () {
        $(this).parent().parent().hide();
        $("#mdp").hide();
        $(".login").show();
        $("#mod").show();
        $("#typemodif").val('username');
    });
    $("#btloginback").click(function () {
        $(".loginback").show();
        $(this).parent().parent().hide();
        $("#mdp").show();
        $("#mod").hide();
    });

    $("#btmodmdp").click(function () {
        $(".mdp").show();
        $("#btlogin").parent().parent().hide();
        $("#mdp").hide();
        $("#mod").show();
        $("#typemodif").val('password');

    });
    $("#btmdpback").click(function () {
        $(".loginback").show();
        $(".mdp").hide();
        $("#mdp").show();
        $("#mod").hide();
    });
</script>
@endsection