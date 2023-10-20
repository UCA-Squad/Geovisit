<body>

    <div style="background-color:#ebecec; padding:30px 0 150px 0;font-family: 'Lato', sans-serif;">
        <div align="center" >

            <img src="{{$message->embed('img/logo_email.png')}}" />

            <br/>
            <h1 style="font-weight:400;color:#000">Bienvenue sur GeoVisit</h1>
            <div style="color:#606161;font-size:15px">  <?php setlocale(LC_TIME, 'fr_FR.utf8', 'fra'); ?>              
                {{  strftime("%d %B %Y")}}<br/><br/><br/></div>
            <div style="width:300px; background-color:white; padding:70px">
                <h3 style="color:#000">Bonjour {{$user->prenom}},</h3>
                <div align="center" style="color:#606161;line-height:30px">

                    Nous sommes heureux de vous confirmer l’ouverture de votre compte <strong><span style="color:#fa7615">GeoVisit</span></strong>. <br/><br/>
                </div>
                <div style="background-color:#ebecec; margin-bottom:50px; padding:20px;line-height:30px" >
                    <div style="color:#000;font-weight:500; font-size:18px">Vos codes d’accès</div>
                    <div align="left"><strong>Login :</strong> {{$user->username}} <br/>

                        <strong>Mot de passe :</strong>  {{ $password }}</div>
                </div>

                <div style="margin-bottom:50px;color:#606161">
                    Conservez-les précieusement ! Ils vous seront utiles à chaque connexion.

                </div>



                <div><a  style="border-radius: 50px;margin: auto;text-decoration: none;padding: 15px;display:block;border: 1px;font-weight: bold;width: 200px;background-color: #f96332;position:relative;top:-40px;left: 22px; color:white;text-decoration:none;font-size:10px" href="{{ url('/')}}" > SE CONNECTER </a></div>

                <div align="right" style="margin-top:50px; color:#606161">A très bientôt sur notre site,<br/>
                    - L’équipe GeoVisit</div>
            </div>
            <div style="width:420px;color:#606161; padding:10px" align="left"> Si vous n'êtes pas à l'origine de cette demande, vous pouvez ignorer ce message et le supprimer.
                <br/>
                <br/>
            </div>
            <div ><a href="{{url('/')}}" style="color:#000;">{{url('/')}}</a></div>



        </div>
    </div>

</body>