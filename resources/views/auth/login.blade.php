@extends('layouts.intro')
@section('content')


<form role="form" method="POST" action="{{ url('/login') }}" id="formlogin">
    {!! csrf_field() !!}
    <div id="overlay_connexion">

        <img id="splash_connexion" src="img/splash.png"></img>
        <div id="space"></div>
        <span class="error" id="errorusername">
            <strong></strong>
        </span>

        <div id="numero">

            <svg id="numero_svg" width="800" height="100">
            <rect id="numero_rect" x="25%" y="30px" rx="30" ry="30" width="400" height="60" style="fill:white;stroke:none;stroke-width:1;fill-opacity:0.2;stroke-opacity:1"/>
            </svg>	
            <img id="numero_icon" src="img/icon_numero.png"/>
            <div class="numero_label" id="numero_texte" ></div>
            <input type="username" class="numero_label label" name="username" value="{{ old('username') }}" placeholder="N° Étudiant">

        </div>
        <div id="mdp">
            <svg id="mdp_svg" width="800" height="100">
            <rect id="mdp_rect" x="25%" y="10px" rx="30" ry="30" width="400" height="60" style="fill:white;stroke:none;stroke-width:1;fill-opacity:0.2;stroke-opacity:1"/>
            </svg>
            <img id="mdp_icon" src="img/icon_mdp.png"/>
            <div class="mdp_label" id="mdp_texte"></div>
            <input class="mdp_label label" id="mdp_input" type="password" name="password" value="" placeholder="Mot de Passe">
            <span class="error" id="errorpassword">
                <strong></strong>
            </span>
        </div>
        <a href="{{ url('/password/reset') }}" style="color:white;    pointer-events: all;position:relative;z-index:32" id="oubli">Mot de passe oublié?</a> 
        <!--<button type="submit" >CONNEXION</button> -->

        <div id="bouton_connexion"><br/>

            <svg id="bouton_connexion_svg" width="800" height="120">
            <rect id="bouton_connexion_rect" x="25%" y="25%" rx="30" ry="30" width="400" height="60" style="fill:#f96331;stroke:none;stroke-width:1;fill-opacity:1;stroke-opacity:1"/>
            </svg>


            <div id="bouton_connexion_label">CONNEXION</div>
        </div>
    </div>
    <input type="submit" name="submit" value="" id="submit"/>
</form>    
<!--  <div class="form-group">
      <div class="col-md-6 col-md-offset-4">
          <div class="checkbox">
              <label>
                  <input type="checkbox" name="remember"> Remember Me
              </label>
          </div>
      </div>
  </div> -->




<!--      <a class="btn btn-link" href="{{ url('/password/reset') }}">Mot de passe oublié?</a> -->


@endsection
@section('scripts')
<script>

    tl = new TimelineLite();

    $("#bouton_connexion_rect").mouseover(function () {
        $("#bouton_connexion_rect").css({fill: "#fa6b3b"});
    });
    $("#bouton_connexion_rect").mouseleave(function () {
        $("#bouton_connexion_rect").css({fill: "#f96331"});
    });
    $("#bouton_connexion_rect").mousedown(function () {
        $("#bouton_connexion_rect").css({fill: "#f96331"});
    });

    $("#numero_input").keydown(function () {
        $("#numero_texte").css({opacity: 0});
    });
    $("#mdp_input").keydown(function () {
        $("#mdp_texte").css({opacity: 0});
    });
    $("#numero_input").change(function () {
        if ($("#numero_input").val() == "") {
            $("#numero_texte").css({opacity: 0.8});
        }
    });
    $("#mdp_input").change(function () {
        if ($("#mdp_input").val() == "") {
            $("#mdp_texte").css({opacity: 0.8});
        }
    });
    $("#oubli").on('click', function (e) {
        e.preventDefault();
        tl.to($("#overlay_temp"), 0.5, {autoAlpha: 0});
        tl.to($("#overlay_connexion"), 0.5, {autoAlpha: 0});
        $(document.body).append("<div id=\"overlay_temp\"></div>");
        $("#overlay_temp").css({"position": "fixed", "opacity": "0", "width": "100%", "height": "100%", "top": "0", "left": "0"});
        $("#overlay_temp").load("{{ url('/password/reset') }}");
        // console.log('sucess'+	data.body);
        tl.to($("#overlay_temp"), 0.5, {autoAlpha: 1});
    });
    document.getElementById("bouton_connexion_rect").addEventListener('click', function () {
        /*if($("#overlay_temp").length == 1){
         tl.to($("#overlay_temp"), 0.5, {autoAlpha: 0});
         }*/ /*else {
          tl.to($("#overlay_connexion"), 0.5, {autoAlpha: 0});
          $(document.body).append("<div id=\"overlay_temp\"></div>");
          $("#overlay_temp").css({"position": "fixed", "opacity": "0", "width": "100%", "height": "100%", "top": "0", "left": "0"});
          
          }*/
        //setTimeout($("#formlogin").submit(), 500)
        $("#submit").click();
    });
    $("#formlogin").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            method: $(this).attr('method'),
            url: $(this).attr('action'),
            headers: { 'X-CSRF-TOKEN': $('input[name="_token"]')[0].value },
            data: $(this).serialize(),
            dataType: "json",
        })

                .done(function (data) {
//			if(response.status == 422)
//			{
//						 $('.error').empty();
//			  $.each(data.errors, function (key, value) {
//
//                var input = '#formlogin input[name=' + key + ']';
//		 console.log(input);
//		 
//                $('#error'+key).text(value);               
//
//            });
//			}
                    if (data['redirect'] === 'choix') {
                        //code

                        tl.to($("#overlay_temp"), 0.5, {autoAlpha: 0});
                        tl.to($("#overlay_connexion"), 0.5, {autoAlpha: 0});
                        $(document.body).append("<div id=\"overlay_temp\"></div>");
                        $("#overlay_temp").css({"position": "fixed", "opacity": "0", "width": "100%", "height": "100%", "top": "0", "left": "0"});
                        $("#overlay_temp").load("{{ url('/choix') }}");
                        // console.log('sucess'+	data.body);
                        tl.to($("#overlay_temp"), 0.5, {autoAlpha: 1});
                    } else
                        window.location.replace("{{url('/admin')}}");
                })
                .fail(function (data) {
                    $('.error').empty();

                    $.each(data.responseJSON, function (key, value) {

                        var input = '#formlogin input[name=' + key + ']';

                        $('#error' + key).text(value);

                    });


                });



    });

//$(document).ready(function(){
////	$("#formlogin").submit(function(e){ // On sélectionne le formulaire par son identifiant
////    e.preventDefault(); // Le navigateur ne peut pas envoyer le formulaire
////			console.log('test');
////
////    
////     
////    $.ajax({
////
////    //...
////
////        method: "POST",
////            url: "{{ url('/login') }}",
////            data: $(this).serialize(),
////
////    //...
////
////    });
////
////});
//
//
//   
//    $("#formlogin").on('submit',function(e) {  	 
//        e.preventDefault();
//		
//        //$.ajaxSetup({
//        //    headers: {
//        //        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
//        //    }
//        //})
//                
//        $.ajax({
//            method: $(this).attr('method'),
//            url: $(this).attr('action'),
//            data: $(this).serialize(),
//            dataType: "json"})
//	    
//	 .done(function(data) {
////			if(response.status == 422)
////			{
////						 $('.error').empty();
////			  $.each(data.errors, function (key, value) {
////
////                var input = '#formlogin input[name=' + key + ']';
////		 console.log(input);
////		 
////                $('#error'+key).text(value);               
////
////            });
////			}
//							tl.to($("#overlay_temp"), 0.5, {autoAlpha: 0});
//tl.to($("#overlay_connexion"), 0.5, {autoAlpha: 0});
//			$(document.body).append("<div id=\"overlay_temp\"></div>");
//			$("#overlay_temp").css({"position": "fixed", "opacity": "0", "width": "100%", "height": "100%", "top": "0", "left": "0"});
//			$("#overlay_temp").load("{{ url('/choix') }}");
//				// console.log('sucess'+	data.body);
//			 })
//			 .fail(function(data) {
//			 $('.error').empty();
//			  console.log('sucess'+	data.status);
//			 
//			  $.each(data.responseJSON, function (key, value) {
//
//                var input = '#formlogin input[name=' + key + ']';
//		 console.log(input);
//		 
//                $('#error'+key).text(value);               
//
//            });
//
//            
//        });
//		        
//       
//
//    });
//
//})
//		$(function(){
//
//
//    $(document).on('submit', '#formlogin', function(e) {  
//        e.preventDefault();
//         
//        
//         
//        $.ajax({
//            method: $(this).attr('method'),
//            url: $(this).attr('action'),
//            data: $(this).serialize(),
//            dataType: "json"
//        })
//        .done(function(data) {
//					console.log('sucess'.data);
//        })
//        .fail(function(data) {
//            $.each(data.responseJSON, function (key, value) {
//                var input = '#formlogin input[name=' + key + ']';
//                $(input + '+small').text(value);
//                $(input).parent().addClass('has-error');
//            });
//        });
//    });
//
//})

</script>

@endsection
@section('styles')
body, html{
-webkit-touch-callout: none;
-webkit-user-select: none;
-khtml-user-select: none;
-moz-user-select: none;
-ms-user-select: none;
user-select: none;
background-color: transparent;
background-image: url("img/flou.jpg");
overflow: hidden;
}
input{
border: 0;
outline: 0;
background: transparent;
width: 200px;
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
position: absolute;
left: 225px;
opacity: 0.8;
width: 25px;
top: 60px;

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
.label::-webkit-input-placeholder {
font-size: 15px;
color: #ffffff;
font-weight: lighter;
opacity: 0.8;
}

.label:-moz-placeholder { /* Firefox 18- */
font-size: 15px;
color: #ffffff;
font-weight: lighter;
opacity: 0.8;
}

.label::-moz-placeholder {  /* Firefox 19+ */
font-size: 15px;
color: #ffffff;
font-weight: lighter;
opacity: 0.8;
}

.label:-ms-input-placeholder {  
font-size: 15px;
color: #ffffff;
font-weight: lighter;
opacity: 0.8;

}
@endsection