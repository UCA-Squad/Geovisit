<body>

    <div style="background-color:#ebecec; padding:30px 0 150px 0;font-family: 'Lato', sans-serif;">
        <div align="center" >

            <img src="{{$message->embed('img/logo_email.png')}}" />

            <br/><br/><br/>
            <h1 style="font-weight:400;color:#000">Besoin d'un nouveau mot de passe?</h1>
            <div style="color:#606161;font-size:15px">  <?php setlocale(LC_TIME, 'fr_FR.utf8', 'fra'); ?>              
                {{  strftime("%d %B %Y")}}<br/><br/><br/></div>
            <div style="width:400px; background-color:white; padding:50px">
                <h3 style="color:#000">Bonjour {{App\Models\User::where('email', $user->getEmailForPasswordReset())->first()->prenom}},</h3>
                <div align="center" style="color:#606161;line-height:30px">
                    Vous nous avez demandé de réinitialiser le mot de passe de votre compte <strong><span style="color:#fa7615">GeoVisit</span></strong>. Si vous voulez toujours le faire, cliquez simplement sur le bouton ci-dessous.<br/><br/><br/>
                </div>

                <div><br/>




                    <div><a  style="border-radius: 50px;margin: auto;text-decoration: none;padding: 15px;display:block;border: 1px;font-weight: bold;width: 300px;background-color: #f96332;position:relative;top:-40px;left: 22px; color:white;text-decoration:none;font-size:10px" href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}" class="bt"> RENITIALISER MON MOT DE PASSE </a></div>
                </div>
                <div align="right" style="margin-top:50px; color:#606161">A très bientôt sur notre site,<br/>
                    - L’équipe GeoVisit</div>
            </div>
            <div style="width:480px;color:#606161; padding:10px" align="left"> Si vous n'êtes pas à l'origine de cette demande, vous pouvez ignorer ce message et le supprimer.
                <br/>
                <br/>
            </div>
            <div ><a href="{{url('/')}}" style="color:#000;">{{url('/')}}</a></div>



        </div>
    </div>

</body>