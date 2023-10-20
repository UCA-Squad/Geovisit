@extends('layouts.intro')
@section('content')



<form  role="form" method="POST" action="{{ url('/password/reset') }}">
    {!! csrf_field() !!}

    <div id="overlay_connexion">

        <img id="splash_connexion" src="../../img/splash.png"></img>
        <div>
            @if ($errors->has('password_confirmation'))
            <span class="help-block">
                <strong>{{ $errors->first('password_confirmation') }}</strong>
            </span>
            @endif
            @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif
            @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
            @endif
        </div>
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="input">

            <svg id="numero_svg" width="800" height="100">
            <rect id="numero_rect" x="25%" y="30px" rx="30" ry="30" width="400" height="60" style="fill:white;stroke:none;stroke-width:1;fill-opacity:0.2;stroke-opacity:1"/>

            </svg>	
            <img id="numero_icon" src="../../img/icon_numero.png"/>
            <input type="email"  name="email" value="{{ $email or old('email') }}" placeholder="Email">

        </div>




        <div class="input">

            <svg id="numero_svg" width="800" height="100">
            <rect id="numero_rect" x="25%" y="30px" rx="30" ry="30" width="400" height="60" style="fill:white;stroke:none;stroke-width:1;fill-opacity:0.2;stroke-opacity:1"/>
            </svg>
            <img id="numero_icon" src="../../img/icon_mdp.png"/>
            <input type="password"  name="password" placeholder="Mot de passe">


        </div>

        <div class="input">
            <svg id="numero_svg" width="800" height="100">
            <rect id="numero_rect" x="25%" y="30px" rx="30" ry="30" width="400" height="60" style="fill:white;stroke:none;stroke-width:1;fill-opacity:0.2;stroke-opacity:1"/>
            </svg>
            <img id="numero_icon" src="../../img/icon_mdp.png"/>
            <input type="password"  name="password_confirmation" placeholder="Confirmation du mot de passe">


        </div>

        <div id="bouton_connexion"><br/>

            <svg id="bouton_connexion_svg" width="800" height="120">
            <rect id="bouton_connexion_rect" x="25%" y="25%" rx="30" ry="30" width="400" height="60" style="fill:#f96331;stroke:none;stroke-width:1;fill-opacity:1;stroke-opacity:1"/>
            </svg>


            <input type="submit" id="bouton_connexion_label" value="Valider"/>
        </div>
    </div>
</form>

@endsection
@section('styles')
#bouton_connexion_label{cursor:pointer; width:300px; border:none;}
body, html{
-webkit-touch-callout: none;
-webkit-user-select: none;
-khtml-user-select: none;
-moz-user-select: none;
-ms-user-select: none;
user-select: none;
background-color: transparent;
background-image: url("../../img/flou.jpg");
overflow: hidden;
color:white
}
.input{height:80px; position:relative; z-index:31}
input{
border: 0;
outline: 0;
background: transparent;
width: 200px;
top: -65px;
position: relative;
color:white;
left:-50px;
pointer-events: all;
}

#overlay_connexion{
position: absolute;
top: 50%;
left: 50%;
width: 800px;
z-index: 30;
opacity: 1;
font-family: 'Lato', sans-serif;
text-align: center;
pointer-events: none;

transform: translate(-50%, -50%);
}
#splash_connexion
{
position: relative;
width: 25%;
}
#bouton_connexion, #numero, #mdp
{
position: relative;
z-index: 31;
}
#bouton_connexion_svg, #numero_svg, #mdp_svg{
}
#bouton_connexion_rect, #numero_rect, #mdp_rect{
pointer-events: all;
}
#bouton_connexion_label, .numero_label, .mdp_label{
position: absolute;
top: 50%;
font-size: 15px;
color: #ffffff;

}
button{background-color: transparent;
border: none;
z-index:100}
#bouton_connexion_label{
font-weight: bold;
left: 50%;

transform: translate(-50%, 0%);
}
.numero_label, .mdp_label{
font-weight: lighter;
left: 275px;
opacity: 0.8;
pointer-events: all;
}
#space, #numero, #mdp{
height: 100px;
}
#bouton_connexion{
height: 140px;
}
.mdp_label{
top: 40px;

transform: translate(0%, -50%);
}
.numero_label{
top: 60px;

transform: translate(0%, -50%);
}
#numero_icon{
position: relative;
opacity: 0.8;
width: 25px;
top: -45px;
left:-60px;
transform: translate(0%, -50%);
}
#mdp_icon{
position: absolute;
left: 225px;
opacity: 0.8;
width: 28px;
top: 40px;

transform: translate(0%, -50%);
}
.input input::-webkit-input-placeholder {
font-size: 15px;
color: #ffffff;
font-weight: lighter;
opacity: 0.8;
}

.input input:-moz-placeholder { /* Firefox 18- */
font-size: 15px;
color: #ffffff;
font-weight: lighter;
opacity: 0.8;
}

.input input::-moz-placeholder {  /* Firefox 19+ */
font-size: 15px;
color: #ffffff;
font-weight: lighter;
opacity: 0.8;
}

.input input:-ms-input-placeholder {  
font-size: 15px;
color: #ffffff;
font-weight: lighter;
opacity: 0.8;

}
@endsection