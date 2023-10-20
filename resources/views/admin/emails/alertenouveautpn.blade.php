<body>
    <div style="color:#606161; padding:10px" align="center">
        En cas de problème pour afficher ou ouvrir le lien, veuillez vérifier les critères de sécurité de votre boite de réception et/ou rendez vous sur {{url('/')}} avec votre identifiant et votre mot de passe habituels.<br/>
        <br/>
    </div> 
    <div style="background-color:#ebecec; padding:30px 0 150px 0;font-family: 'Lato', sans-serif;">
        <div align="center" >
            <img src="{{$message->embed('img/logo_email.png')}}" />
            <br/>
            <h1 style="font-weight:400;color:#000">Et un nouveau TPN !</h1>
            <div style="color:#606161;font-size:15px">  <?php setlocale(LC_TIME, 'fr_FR.utf8', 'fra'); ?>              
                {{  strftime("%d %B %Y")}}<br/><br/><br/>
            </div>
            <div style="width:500px; background-color:white; ">
                <img src="{{ URL::asset($tpn->site->photo) }}" style="max-width:500px" />
                <div style="padding:70px">
                    <h3 style="color:#000">Bonjour {{$user->prenom}},</h3>
                    <div  style="color:#606161;line-height:30px; height:100%">
                        Le TPN <strong><span style="color:#fa7615">‘{{$tpn->titre_tpns}}’</span></strong> a été ajouté à votre  compte par le professeur <strong><span style="color:#fa7615">{{Auth::user()->prenom}} {{Auth::user()->nom}}</span></strong>. Pour le découvrir, cliquez simplement sur le bouton ci-dessous. <br/><br/>
                    </div>
                    <div><a  style="border-radius: 50px;margin: auto;text-decoration: none;padding: 15px;display:block;border: 1px;font-weight: bold;width: 200px;background-color: #f96332;position:relative;top:-40px;left: 22px; color:white;text-decoration:none;font-size:10px" href="{{ url('/final/'.$tpn->id)}}" > VOIR MON NOUVEAU TPN </a></div>

                    <div align="right" style="margin-top:50px; color:#606161">A très bientôt sur notre site,<br/>
                        - L’équipe GeoVisit</div>
                </div>
            </div>

            <div style="width:420px;color:#606161; padding:10px" align="left"> Si vous n'êtes pas à l'origine de cette demande, vous pouvez ignorer ce message et le supprimer.
                <br/>
                <br/>
            </div>
            <div ><a href="{{url('/')}}" style="color:#000;">{{url('/')}}</a></div>
        </div>
    </div>
</body>