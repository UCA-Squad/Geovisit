{{ Html::style(asset('css/bootstrap/bootstrap.min.css')) }}

<script>
    var host = "{{URL::to('/')}}";
    var hst = "{{URL::to('/img/img_editeur')}}";
    var upload = "{{route('uploader')}}";
</script>

<script src="{{URL::asset('js/etapes_admin.js') }}" type="text/javascript"></script>
<script src="{{URL::asset('js/editeur_admin.js') }}" type="text/javascript"></script>
<script src="{{URL::asset('js/popups_admin.js') }}" type="text/javascript"></script>
<script src="{{URL::asset('js/geovisit_uploader.js') }}" type="text/javascript"></script>

<script src="{{URL::asset('js/bootstrap/bootstrap.min.js')}}" type="text/javascript"></script>

<div id="bloc_ateliers">
    <div id="contenu_ateliers">
        <div id="ateliers_exercices">
            <div id="ateliers_exercices_nombre"></div>
            <div>EXERCICES</div>
        </div>
        <svg id="cercleImg1" width="300px" height="300px">
        <defs>
        <pattern id="pattern_ateliers1" x="0%" y="0%" height="100%" width="100%" viewBox="0 0 300 300">
            <image id="img_ateliers1" x="0%" y="0%" width="300" height="300" xlink:href=""></image>
            </defs>
            <circle cx="50%" cy="50%" r="140px" fill="url(#pattern_ateliers1)" stroke="none" stroke-width="2px" stroke-opacity="0.7" />
            </svg>
            <svg id="cercleImg2" width="300px" height="300px">
            <defs>
            <pattern id="pattern_ateliers2" x="0%" y="0%" height="100%" width="100%" viewBox="0 0 300 300">
                <image id="img_ateliers2" x="0%" y="0%" width="300" height="300" xlink:href=""></image>
                </defs>
                <circle cx="50%" cy="50%" r="140px" fill="url(#pattern_ateliers2)" stroke="none" stroke-width="2px" stroke-opacity="0.7" />
                </svg>

                <svg id="cercleLigne" width="300px" height="300px">
                <circle id="cercleLignePasFait" cx="150" cy="150" r="148"fill="none" stroke="#ffffff" stroke-width="1" stroke-opacity="0.8" />
                <circle id="cercleLigneFait" cx="150" cy="150" r="148"fill="none" stroke="#fa7346" stroke-width="2" />
                </svg>
                <div id="ateliers_nom"></div>
                </div>
                </div>
                <div id="bloc_identifiants">

                    <div id="overlay_croix">
                        <div id="croix">
                            <span id="croix_label">FERMER</span>
                            <svg id="croix_forme" width="20" height="20">
                            <path stroke="#ffffff"  d="M10 10 L20 20"/>
                            <path stroke="#ffffff"  d="M10 20 L20 10"/>
                            </svg>
                        </div>
                    </div>
                    <div id="edit_annulation_bouton">
                        <img id="retour_img" width="20" height="20" src="{{URL::asset('img/retour.png')}}" />

                    </div>
                    <div id="overlay_selection">
                        <div id="selection">
                            <img id="selection_img" width="20" height="20" src="{{URL::asset('img/selection.png')}}" />
                            <span id="selection_label">SÉLECTION TPN</span>
                        </div>
                    </div>
                    <div id="overlay_deconnexion">
                        <div id="deconnexion">
                            <img id="deconnexion_img" width="20" height="20" src="{{URL::asset('img/deconnexion.png')}}" />
                            <span id="deconnexion_label">DÉCONNEXION</span>
                        </div>
                    </div>
                    <div id="contenu_identifiants">
                        <div id="bloc_img">

                            <img id="img_site" src="{{URL::asset(Auth::user()->avatar)}}" />
                            <a href="#" id="photo-profil-lien-front" style="z-index:3000; text-decoration:none; color:white;display:block;margin-left:41%; margin-top:10px; pointer-events: all;">Editer photo</a>
                        </div>
                        <div id="error"></div>
                        <div id="profil_login">
                            <svg id="profil_login_svg" width="500" height="65">
                            <rect id="profil_login_rect" x="25%" y="10" rx="22.5" ry="22.5" width="250" height="45" style="fill:white;stroke:none;stroke-width:1;fill-opacity:0.1;stroke-opacity:0.4"/>
                            </svg>	
                            <img id="profil_login_icon" src="{{URL::asset('img/icon_numero.png')}}"/>
                            <img id="profil_login_edit" src="{{URL::asset('img/icon_edit.png')}}"/>
                            <div class="profil_login_label" id="profil_login_texte">{{Auth::user()->prenom}} {{Auth::user()->nom}}</div>
                            <input class="profil_login_label" id="profil_login_input" type="text" name="texte" value="">
                        </div>
                        <div id="profil_mail_titre">ANCIENNE ADRESSE MAIL</div>
                        <div id="profil_mail">
                            <svg id="profil_mail_svg" width="500" height="65">
                            <rect id="profil_mail_rect" x="25%" y="10" rx="22.5" ry="22.5" width="250" height="45" style="fill:white;stroke:none;stroke-width:1;fill-opacity:0.1;stroke-opacity:0.4"/>
                            </svg>	
                            <img id="profil_mail_icon" src="{{URL::asset('img/icon_mail.png')}}"/>
                            <img id="profil_mail_edit" src="{{URL::asset('img/icon_edit.png')}}"/>
                            <div class="profil_mail_label" id="profil_mail_texte">{{Auth::user()->email}}</div>
                            <input class="profil_mail_label" id="profil_mail_input" type="text" name="texte" value="">
                        </div>
                        <div id="profil_mdp">
                            <svg id="profil_mdp_svg" width="500" height="65">
                            <rect id="profil_mdp_rect" x="25%" y="10" rx="22.5" ry="22.5" width="250" height="45" style="fill:white;stroke:none;stroke-width:1;fill-opacity:0.1;stroke-opacity:0.4"/>
                            </svg>	
                            <img id="profil_mdp_icon" src="{{URL::asset('img/icon_mdp.png')}}"/>
                            <img id="profil_mdp_edit" src="{{URL::asset('img/icon_edit.png')}}"/>
                            <div class="profil_mdp_label" id="profil_mdp_texte">••••••••</div>
                            <input class="profil_mdp_label" id="profil_mdp_input" type="text" name="texte" value="">
                        </div>
                        <form  action="{{ route('modprofilemail') }}" method="POST" id="formemail">
                            {!! csrf_field() !!}
                            <div id="edit_mail_titre">NOUVELLE ADRESSE MAIL</div>
                            <div id="edit_mail">
                                <svg id="edit_mail_svg" width="500" height="65">
                                <rect id="edit_mail_rect" x="25%" y="10" rx="22.5" ry="22.5" width="250" height="45" style="fill:white;stroke:none;stroke-width:1;fill-opacity:0.1;stroke-opacity:0.4"/>
                                </svg>	
                                <img id="edit_mail_icon" src="{{URL::asset('img/icon_mail.png')}}"/>
                                <div class="edit_mail_label" id="edit_mail_texte"></div>
                                <input class="edit_mail_label" id="edit_mail_input" type="text" name="email" value="">
                            </div>
                            <div id="edit_validation_titre">ENTREZ VOTRE MOT DE PASSE</div>
                            <div id="edit_validation">
                                <svg id="edit_validation_svg" width="500" height="65">
                                <rect id="edit_validation_rect" x="25%" y="10" rx="22.5" ry="22.5" width="250" height="45" style="fill:white;stroke:none;stroke-width:1;fill-opacity:0.1;stroke-opacity:0.4"/>
                                </svg>	
                                <img id="edit_validation_icon" src="{{URL::asset('img/icon_mdp.png')}}"/>
                                <div class="edit_validation_label" id="edit_validation_texte"></div>
                                <input class="edit_validation_label" id="edit_validation_input" type="password" name="password" value="">
                            </div>
                            <input type="submit" id="submitemail" style="display:none"/>
                        </form>
                        <form  action="{{ route('modprofilpassword') }}" method="POST" id="formmdp">
                            {!! csrf_field() !!}
                            <input  type="hidden" name="password" id="password" value="">

                            <div id="edit_mdp_titre">NOUVEAU MOT DE PASSE</div>
                            <div id="edit_mdp">
                                <svg id="edit_mdp_svg" width="500" height="65">
                                <rect id="edit_mdp_rect" x="25%" y="10" rx="22.5" ry="22.5" width="250" height="45" style="fill:white;stroke:none;stroke-width:1;fill-opacity:0.1;stroke-opacity:0.4"/>
                                </svg>	
                                <img id="edit_mdp_icon" src="{{URL::asset('img/icon_mdp.png')}}"/>
                                <div class="edit_mdp_label" id="edit_mdp_texte"></div>
                                <input class="edit_mdp_label" id="edit_mdp_input" type="password" name="new_password" value="">
                            </div>				
                            <div id="confirmation_mdp_titre">CONFIRMATION MOT DE PASSE</div>
                            <div id="confirmation_mdp">
                                <svg id="confirmation_mdp_svg" width="500" height="65">
                                <rect id="confirmation_mdp_rect" x="25%" y="10" rx="22.5" ry="22.5" width="250" height="45" style="fill:white;stroke:none;stroke-width:1;fill-opacity:0.1;stroke-opacity:0.4"/>
                                </svg>	
                                <img id="confirmation_mdp_icon" src="{{URL::asset('img/icon_mdp.png')}}"/>
                                <div class="confirmation_mdp_label" id="confirmation_mdp_texte"></div>
                                <input class="confirmation_mdp_label" id="confirmation_mdp_input" type="password" name="new_password_confirmation" value="">
                            </div>
                            <input type="submit" id="submitmdp" style="display:none"/>
                        </form>
                        <div id="edit_validation_bouton">
                            <svg id="edit_validation_bouton_svg" width="500" height="65">
                            <rect id="edit_validation_bouton_rect" x="25%" y="10" rx="22.5" ry="22.5" width="250" height="45" style="fill:none;stroke:white;stroke-width:1;fill-opacity:0.2;stroke-opacity:0.4"/>
                            </svg>		
                            <div id="edit_validation_bouton_label">VALIDER</div>
                        </div>

        <!--<svg id="edit_annulation_bouton_svg" width="200" height="65">
                <rect id="edit_annulation_bouton_rect" x="20%" y="10" rx="22.5" ry="22.5" width="125" height="45" style="fill:none;stroke:white;stroke-width:1;fill-opacity:0.2;stroke-opacity:0.4"/>
        </svg>		
        <div id="edit_annulation_bouton_label">ANNULER</div>
</div>-->

                    </div>

                    <!-- POPUPS UPLOADS -->

                    <div id="popup_sites_upload" class="dialog_operations popupparent">

                        <div id="contenus_popup_upload" class="contenu-cacher">
                            <div id="popup_upload_photo" class="content_popup_admin">
                                <a href="#" id="close_sites_upload" class="fermerpopup" style="font-family: 'Lato', sans-serif;
                                   font-weight: 300;
                                   color:grey;
                                   font-size:20px; float:right; padding:10px; pointer-events: all;">&times;</a>
                                <div class="row" style="padding:10%;">
                                    <!-- {{  Form::open(array('files' => true, 'id' => 'chx-upload-photo-exercice')) }} -->
                                    <form id="chx-upload-photo-exercice" action="#">
                                        <div class="row">
                                            <div  style="padding-left: 60px; padding-right: 60px;">
                                                <div class="row"><img src="{{ URL::asset('css/img/ICON_POPUP_UPLOAD_DOWNLOAD.png') }}" align="middle"></div>
                                                <div class="row"><h1>UPLOAD</h1></div>
                                                <div class="row"><p>Telechargez votre fichier depuis votre ordinateur</p></div>
                                                <div class="row">
                                                    <div class="bloc-boutons-submits"><input type="submit" name="chx_afficher_upload_intro" id="chx_afficher_photo_upload_intro" class="submit action-button" value="Continuer" style="pointer-events: all;" /></div>
                                                </div>
                                            </div>

                                        </div>

                                    </form>
                                    <!-- {{  Form::close() }} -->
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- LIENS  -->
                    <div id="popup_sites_over_liensupload" class="dialog_operations_over">
                        <div id="contenus_popup_over_liensupload" class="contenu-cacher">

                            <!-- POPUP DRAG'N'DROP UPLOADS -->

                            <div id="popup_liensload_photo" class="content_popup_admin">
                                <a href="#" class="fleche_gauche_site fermerpopup_over" style="float:left; position:absolute; border:none; margin-top:300px; width:84px;pointer-events: all;"><div class="fleche_gauche_site_img"></div></a>
                                <div class="row" style="padding:10%;">

                                    <!-- <form id="chx-upload-photo-exercice" action="{{ route('uploader') }}"> -->
                                    <div class="row">

                                        <div class="row" style="margin-bottom:60px;"><h1>LIENS</h1></div>


                                        <div class="row">

                                            <img id="iconliensupload" class="iconliensupload" src="{{ URL::asset('css/img/ICON_POPUP_UPLOAD_LIENS.png') }}" align="middle" style="margin-bottom:50px;">

                                            <div id="instruction" class="zone-message"><h1>COLLEZ LE LIEN EXTERNE CI-DESSOUS</h1></div><br>

                                            <div class="row" style="margin-left:auto; margin-right:auto;">
                                                <div class="row" style="margin:auto; text-align:center;">
                                                    <input type="text" id="input_lien_upload" name="input_lien_upload" style="width:500px; border:1px solid #ccc; z-index:600; pointer-events: all;">
                                                </div>


                                                <div id="bouton_liens_intro" class="row bouton_upload">
                                                    <br><br>
                                                    <div class="bloc-boutons-submits"><a href="#" id="submit_lienupload" class="lancer_liens fermerpopup_over submit" style="height:60px; width: 50%; display:block; text-decoration: none; padding-top: 20px;
                                                                                         margin: auto; pointer-events: all; pointer-events: all;">TERMINER</a></div>

                                                </div>
                                            </div>

                                        </div>





                                    </div>


                                </div>




                            </div>
                        </div>


                    </div>


                </div>

                <!-- FIN LIENS -->

                <!-- DRAGUPLOAD -->

                <div id="popup_sites_over_dragupload" class="dialog_operations_over">
                    <div id="contenus_popup_over_dragupload" class="contenu-cacher">

                        <!-- POPUP DRAG'N'DROP UPLOADS -->

                        <div id="popup_dragupload_photo" class="content_popup_admin">
                            <a href="#" class="fleche_gauche_site fermerpopup_over" style="float:left; position:absolute; border:none; margin-top:300px; width:84px; pointer-events: all;"><div class="fleche_gauche_site_img"></div></a>
                            <div class="row" style="padding:10%;">

                                <!-- <form id="chx-upload-photo-exercice" action="{{ route('uploader') }}"> -->
                                <div class="row">

                                    <div class="row" style="margin-bottom:60px;"><h1>UPLOAD</h1></div>


                                    <div class="row">
                                        <div id="upload_dropzone_intro" class="upload_dropzone" style="margin:auto;">
                                            <img id="icondragupload" class="icondragupload" src="{{ URL::asset('css/img/ICON_POPUP_UPLOAD_DOWNLOAD_DRAG.png') }}" align="middle" style="margin-bottom:50px;">

                                            <div id="instruction" class="zone-message"><h1>DEPOSEZ VOTRE FICHIER ICI</h1></br>50Mo Maximum</div>

                                            <div class="row">
                                                <div class="zone-image-preview" style="margin-left:auto; margin-right:auto;"></div>
                                                <div class="zone-image-infos" style="margin-left:auto; margin-right:auto;"></div>
                                                <div style="width:10%; display:inline; float:left;">

                                                    <button id="enlever" class="enlever" style="color:black; background:#fff; font-size: 16px; width:20px; height:60px; border-radius:50%; border:none; box-shadow:none; display:none; pointer-events: all;">
                                                        <span class="glyphicon glyphicon-refresh"></span>								          
                                                    </button>


    <!-- <div class="dz-success-mark lancer row"><span style="background:#f96332; color:white; border-radius: 50%; height:100px; width:1050px;">✔</span></div>
        <div class="dz-error-mark row"><span>✘</span></div> -->
                                                </div>


                                            </div>


                                            <div id="bouton_upload_intro" class="row bouton_upload" style="display:none;">
                                                <br><br>
                                                <div class="bloc-boutons-submits"><a href="#" id="close_sites_dragupload" class="lancer fermerpopup_over submit" style="height:60px; width: 100%; display:block; text-decoration: none; padding-top: 20px;
                                                                                     margin: auto; pointer-events: all;">TERMINER</a></div>

                                            </div>
                                        </div>

                                    </div>



                                </div>

                                <!--							<div class="row bloc-upload-manuel" style="text-align:center; padding:auto;">
                                                                                                {{  Form::open(array('route' => 'uploader', 'files' => true, 'id' => 'chx-upload-photo-intro')) }}
                                                                                                        <div style="width:50%; display:inline; float:left; padding-top:20px; text-align:right;">ou télécharger depuis votre ordinateur </div><div style="width:20%; display:inline; float:left;"><div class="fichier" style="width:100%;"><input type="file" onchange="upload_manuel(this.id, this.form.id);" name="chx_photo_intro" id="chx_photo_intro" accept="image/*" style="pointer-events: all;"/><span>UPLOAD</span></div></div>
                                                                                                {{  Form::close() }}	
                                                                                        </div>-->

                            </div>


                        </div>




                    </div>
                </div>




                <!-- FIN POPUP DRAG'N'DROP UPLOADS -->

                </div>


                </div>

                <!-- POPUP UPLOAD QCM -->






                <script>
                    $('.popupparent').each(function ()
                    {

                        $(this).click(function ()
                        {


                            $(this).removeClass('active').addClass('dialog_operations');
                            $(this).children().removeClass('active').addClass('contenu-cacher');


                        });
                    });


                    $('.fermerpopup').each(function ()
                    {

                        $(this).click(function ()
                        {
                            //$("#contenus_popup").hide();
                            /*$("#contenus_popup").empty().append('');*/
                            $(this).parent(".active").removeClass("active").addClass('contenu-cacher');
                            $(this).parent().parent().parent(".active").removeClass("active").addClass('dialog_operations');


                            //$(this).parent(".dialog_operations").toggleClass("active");
                            //$(this).parent(".content_popup_admin").toggle();
                            return false;
                        });

                    });

                    $('.fermerpopup_sites').each(function ()
                    {

                        $(this).click(function ()
                        {
                            //$("#contenus_popup").hide();
                            /*$("#contenus_popup").empty().append('');*/
                            $(this).next(".active").removeClass("active").addClass('contenu-cacher');
                            $(this).parent(".active").removeClass("active").addClass('dialog_operations');


                            //$(this).parent(".dialog_operations").toggleClass("active");
                            //$(this).parent(".content_popup_admin").toggle();
                            return false;
                        });

                    });

                    $('.fermerpopup_over').each(function ()
                    {

                        $(this).click(function ()
                        {
                            //$("#contenus_popup").hide();
                            /*$("#contenus_popup_over").empty().append('');*/
                            $(this).closest(".active_over").removeClass("active_over").addClass('contenu-cacher');
                            $(this).parent(".active_over").removeClass("active_over").addClass('dialog_operations_over');
                            return false;
                        });

                    });

                    $('#photo-profil-lien-front').click(function ()
                    {
                        //alert('cliqué');
                        var type = "photo";

                        $("#popup_sites_upload").removeClass('dialog_operations').addClass('active');
                        $("#contenus_popup_upload").removeClass('contenu-cacher').addClass('active');

                        $('#chx_afficher_photo_upload_intro').click(function () {

                            $("#popup_sites_over_dragupload").removeClass('dialog_operations_over').addClass('active_over');
                            $("#contenus_popup_over_dragupload").removeClass('contenu-cacher').addClass('active');
                            var zone_drop_profil = new GeovisitUploader(host + '/admin/uploader', "profil", "#popup_sites_upload", "#contenus_popup_upload", "#popup_sites_over_dragupload", "#contenus_popup_over_dragupload", '#container_intro', type, "");
                            zone_drop_profil.initialise();

                            delete zone_drop_profil;
                            return false;

                        });

                        $('#chx_afficher_photo_externe_intro').click(function ()
                        {
                            $('#popup_sites_over_liensupload').removeClass('dialog_operations_over').addClass('active_over');
                            $("#contenus_popup_over_liensupload").removeClass('contenu-cacher').addClass('active');

                            $('#submit_lienupload').click(function ()
                            {
                                var input_lien = $("#contenus_popup_over_liensupload").find('input[name="input_lien_upload"]');
                                var val_input_lien = input_lien.val();

                                if (val_input_lien != "")
                                {
                                    alert(val_input_lien);
                                    //'#container_intro'
                                    $("#popup_sites_upload").removeClass('active').addClass('dialog_operations');
                                    $("#contenus_popup_upload").removeClass('active').addClass('contenu-cacher');

                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });


                                    var formData = new FormData();
                                    formData.append('file', val_input_lien); //f
                                    formData.append('type_contenu', 'photo');
                                    formData.append('depuis', 'profil');
                                    formData.append('externe', 'oui');

                                    /*{'file': f, 'type_contenu': this.type_contenu, 'depuis': this.vient_de, '_token': _token}*/

                                    $.ajax({
                                        type: 'POST',
                                        url: host + '/admin/uploader', //host+'/admin/uploader'					               
                                        data: formData, //.serialize()
                                        processData: false,
                                        contentType: false,
                                        dataType: 'json',
                                        success: function (response) {

                                            var resultat = response.msg;
                                            var depuislebloc = response.de;

                                            if (resultat != "ERREUR")
                                            {
                                                location.reload();
                                            }
                                        }
                                    });

                                } else
                                {
                                    alert("Le champs est vide");
                                }
                                return false;
                            });
                            return false;
                        });


                        $('#chx_afficher_photo_dossier_intro').click(function ()
                        {
                            $("#popup_over_dossier").removeClass('dialog_operations_over').addClass('active_over');
                            $("#contenus_popup_over_dossier").removeClass('contenu-cacher').addClass('active');
                            $(".photo").click(function () {

                                var contenu = $($(this).attr('href')).html();
                                $("#popup_dossier_apercu").empty();
                                $("#popup_dossier_apercu").html(contenu + '<div id="bouton_upload_intro" class="row bouton_upload"><br/><br/><div class="bloc-boutons-submits"><a href="#" id="submit_dossierupload" class="lancer fermerpopup submit" style="height:60px; width: 50%; display:block; text-decoration: none; padding-top: 20px;margin: auto;">TERMINER</a></div></div>');
                                $("#popup_dossier_contenu").addClass('contenu-cacher');
                                $("#popup_dossier_apercu").removeClass('contenu-cacher').addClass('active');
                                $(".fleche_gauche_dossier").click(function () {
                                    $("#popup_dossier_apercu").removeClass('active').addClass('contenu-cacher');
                                    $("#popup_dossier_contenu").removeClass('contenu-cacher').addClass('active');
                                });
                                $('#submit_dossierupload').click(function ()
                                {
                                    var lien_upload = $("#media").html();
                                    $("#popup_over_dossier").removeClass('active_over').addClass('dialog_operations_over');
                                    $("#contenus_popup_over_dossier").removeClass('active').addClass('contenu-cacher');

                                    $.ajaxSetup({
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                        }
                                    });


                                    lien_upload = lien_upload.replace('<img src="', '');
                                    lien_upload = lien_upload.replace('">', '');
                                    alert(lien_upload);
                                    var formData = new FormData();
                                    formData.append('file', lien_upload); //f
                                    formData.append('type_contenu', 'photo');
                                    formData.append('depuis', 'profil');
                                    formData.append('externe', 'dossier');

                                    /*{'file': f, 'type_contenu': this.type_contenu, 'depuis': this.vient_de, '_token': _token}*/

                                    $.ajax({
                                        type: 'POST',
                                        url: host + '/admin/uploader', //host+'/admin/uploader'					               
                                        data: formData, //.serialize()
                                        processData: false,
                                        contentType: false,
                                        dataType: 'json',
                                        success: function (response) {

                                            var resultat = response.msg;
                                            var depuislebloc = response.de;

                                            if (resultat != "ERREUR")
                                            {
                                                $("#popup_dossier_apercu").removeClass('active').addClass('contenu-cacher');
                                                $("#popup_dossier_contenu").removeClass('contenu-cacher').addClass('active');
                                                $("#popup_sites_upload").removeClass('active').addClass('dialog_operations');
                                                $("#contenus_popup_upload").removeClass('active').addClass('contenu-cacher');

                                                location.reload();
                                            }
                                        }
                                    });



                                });
                                return false;
                            });

                            return false;
                        });
                        return false;
                    });


                    /*FIN FONCTIONS POPUPS*/


                    $("#profil_login").mouseover(function () {
                        $("#profil_login_rect").css({"stroke": "white"});
                    });
                    $("#profil_login").mouseleave(function () {
                        $("#profil_login_rect").css({"stroke": "none"});
                    });

                    $("#profil_mail").mouseover(function () {
                        if ($("#edit_validation_bouton").height() == 0) {
                            TweenLite.to($("#profil_mail_edit"), 0.3, {autoAlpha: 0.8});
                        }
                        $("#profil_mail_rect").css({"stroke": "white"});
                    });
                    $("#profil_mail").mouseleave(function () {
                        TweenLite.to($("#profil_mail_edit"), 0.3, {autoAlpha: 0});
                        $("#profil_mail_rect").css({"stroke": "none"});
                    });

                    $("#profil_mdp").mouseover(function () {
                        if ($("#edit_validation_bouton").height() == 0) {
                            TweenLite.to($("#profil_mdp_edit"), 0.3, {autoAlpha: 0.8});
                        }
                        if ($("#edit_annulation_bouton").height() == 0) {
                            TweenLite.to($("#profil_mdp_edit"), 0.3, {autoAlpha: 0.8});
                        }
                        $("#profil_mdp_rect").css({"stroke": "white"});
                    });
                    $("#profil_mdp").mouseleave(function () {
                        TweenLite.to($("#profil_mdp_edit"), 0.3, {autoAlpha: 0});
                        $("#profil_mdp_rect").css({"stroke": "none"});
                    });

                    $("#edit_mail").mouseover(function () {
                        $("#edit_mail_rect").css({"stroke": "white"});
                    });
                    $("#edit_mail").mouseleave(function () {
                        $("#edit_mail_rect").css({"stroke": "none"});
                    });

                    $("#edit_mdp").mouseover(function () {
                        $("#edit_mdp_rect").css({"stroke": "white"});
                    });
                    $("#edit_mdp").mouseleave(function () {
                        $("#edit_mdp_rect").css({"stroke": "none"});
                    });

                    $("#confirmation_mdp").mouseover(function () {
                        $("#confirmation_mdp_rect").css({"stroke": "white"});
                    });
                    $("#confirmation_mdp").mouseleave(function () {
                        $("#confirmation_mdp_rect").css({"stroke": "none"});
                    });

                    $("#edit_mail").mouseover(function () {
                        $("#edit_mail_rect").css({"stroke": "white"});
                    });
                    $("#edit_mail").mouseleave(function () {
                        $("#edit_mail_rect").css({"stroke": "none"});
                    });

                    $("#edit_validation").mouseover(function () {
                        $("#edit_validation_rect").css({"stroke": "white"});
                    });
                    $("#edit_validation").mouseleave(function () {
                        $("#edit_validation_rect").css({"stroke": "none"});
                    });
                    $("#edit_validation_bouton").mouseover(function () {
                        $("#edit_validation_bouton_rect").css({"stroke-opacity": "0.8"});
                    });
                    $("#edit_validation_bouton").mouseleave(function () {
                        $("#edit_validation_bouton_rect").css({"stroke-opacity": "0.4"});
                    });
                    $("#edit_annulation_bouton").mouseover(function () {
                        $("#edit_annulation_bouton_rect").css({"stroke-opacity": "0.8"});
                    });
                    $("#edit_annulation_bouton").mouseleave(function () {
                        $("#edit_annulation_bouton_rect").css({"stroke-opacity": "0.4"});
                    });
                    $("#profil_mail_edit").click(function () {
                        var tl = new TimelineLite();
                        tl.to($('#profil_login'), 0.3, {css: {height: 0}}, "cacher");
                        tl.to($('#profil_mdp'), 0.3, {css: {height: 0}}, "cacher");
                        tl.to($("#profil_mail_edit"), 0.3, {autoAlpha: 0}, "cacher");
                        $("#edit_mail_input").val("");
                        $("#edit_validation_input").val("");
                        $("#edit_validation_titre").empty().append("ENTREZ VOTRE MOT DE PASSE");
                        tl.to($('#edit_mail'), 0.3, {css: {height: "65px"}}, "afficher");
                        tl.to($('#edit_validation'), 0.3, {css: {height: "65px"}}, "afficher");
                        tl.to($('#edit_mail_titre'), 0.3, {css: {height: "20px"}}, "afficher");
                        tl.to($('#edit_validation_titre'), 0.3, {css: {height: "20px"}}, "afficher");
                        tl.to($('#profil_mail_titre'), 0.3, {css: {height: "20px"}}, "afficher");
                        tl.to($("#edit_validation_bouton"), 0.3, {css: {height: "70px"}}, "afficher");
                        tl.to($("#edit_annulation_bouton"), 0.3, {css: {height: "70px"}}, "afficher");


                    });
                    $("#profil_mdp_edit").click(function () {
                        var tl = new TimelineLite();
                        tl.to($('#profil_login'), 0.3, {css: {height: 0}}, "cacher");
                        tl.to($('#profil_mdp'), 0.3, {css: {height: 0}}, "cacher");
                        tl.to($('#profil_mail'), 0.3, {css: {height: 0}}, "cacher");
                        tl.to($("#profil_mdp_edit"), 0.3, {autoAlpha: 0}, "cacher");
                        $("#edit_mail_input").val("");
                        $("#edit_validation_input").val("");
                        $("#edit_validation_titre").empty().append("ANCIEN MOT DE PASSE");
                        tl.to($('#edit_mdp'), 0.3, {css: {height: "65px"}}, "afficher");
                        tl.to($('#confirmation_mdp'), 0.3, {css: {height: "65px"}}, "afficher");
                        tl.to($('#edit_validation'), 0.3, {css: {height: "65px"}}, "afficher");
                        tl.to($('#edit_mdp_titre'), 0.3, {css: {height: "20px"}}, "afficher");
                        tl.to($('#edit_validation_titre'), 0.3, {css: {height: "20px"}}, "afficher");
                        tl.to($('#confirmation_mdp_titre'), 0.3, {css: {height: "20px"}}, "afficher");
                        tl.to($("#edit_validation_bouton"), 0.3, {css: {height: "70px"}}, "afficher");
                        tl.to($("#edit_annulation_bouton"), 0.3, {css: {height: "70px"}}, "afficher");
                        $("#profil_mdp_input").css({"pointer-events": "all"});
                    });
                    $("#edit_validation_bouton").click(function () {
                        var tl = new TimelineLite();

                        if ($("#edit_mdp").height() > 0) {
                            //tl.to($('#edit_validation'), 0.3, {css:{height:0}}, "cacher");
                            //tl.to($('#edit_validation_titre'), 0.3, {css:{height:0}}, "cacher");
                            //tl.to($('#edit_mdp'), 0.3, {css:{height:0}}, "cacher");
                            //tl.to($('#edit_mdp_titre'), 0.3, {css:{height:0}}, "cacher");
                            //tl.to($('#confirmation_mdp'), 0.3, {css:{height:0}}, "cacher");
                            //tl.to($('#confirmation_mdp_titre'), 0.3, {css:{height:0}}, "cacher");
                            //tl.to($("#edit_validation_bouton"), 0.3, {css:{height:0}}, "cacher");
                            //
                            //tl.to($('#profil_login'), 0.3, {css:{height:"65px"}}, "afficher");
                            //tl.to($('#profil_mdp'), 0.3, {css:{height:"65px"}}, "afficher");
                            //tl.to($('#profil_mail'), 0.3, {css:{height:"65px"}}, "afficher");
                            //	
                            //tl.to($('#profil_mdp_texte'), 0.3, {autoAlpha:0, onComplete:function(){
                            //	//if mdp correct et nouveau mdp valide
                            //	$("#edit_mdp_input").val("");
                            //	$("#confirmation_mdp_input").val("");
                            //}});
                            //tl.to($('#profil_mdp_texte'), 0.3, {autoAlpha:0.8});
                            //$("#profil_mdp_input").css({"pointer-events":"none"});
                            //ajout de submit form
                            $("#password").val($("#edit_validation_input").val());
                            $("#submitmdp").click();
                        }

                        if ($("#edit_mail").height() > 0) {
                            /*	tl.to($('#edit_mail'), 0.3, {css:{height:0}}, "cacher");
                             tl.to($('#edit_validation'), 0.3, {css:{height:0}}, "cacher");
                             tl.to($('#edit_mail_titre'), 0.3, {css:{height:0}}, "cacher");
                             tl.to($('#edit_validation_titre'), 0.3, {css:{height:0}}, "cacher");
                             tl.to($('#profil_mail_titre'), 0.3, {css:{height:0}}, "cacher");
                             tl.to($("#edit_validation_bouton"), 0.3, {css:{height:0}}, "cacher");
             
                             tl.to($('#profil_login'), 0.3, {css:{height:"65px"}}, "afficher");
                             tl.to($('#profil_mdp'), 0.3, {css:{height:"65px"}}, "afficher");
                             tl.to($('#profil_mail'), 0.3, {css:{height:"65px"}}, "afficher"); */

                            //tl.to($('#profil_mail_texte'), 0.3, {autoAlpha:0, onComplete:function(){
                            //	//if mdp correct et adresse mail valide
                            //	$("#profil_mail_texte").empty().append($("#edit_mail_input").val());
                            //	$("#edit_mail_input").val("");
                            //	$("#edit_validation_input").val("");
                            //}});
                            //tl.to($('#profil_mail_texte'), 0.3, {autoAlpha:0.8});

                            //ajout de submit form
                            $("#submitemail").click();
                        }
                    });
                    $("#edit_annulation_bouton").click(function () {
                        var tl = new TimelineLite();
                        $('#error').empty();
                        if ($("#edit_mdp").height() > 0) {
                            tl.to($('#edit_validation'), 0.3, {css: {height: 0}}, "cacher");
                            tl.to($('#edit_validation_titre'), 0.3, {css: {height: 0}}, "cacher");
                            tl.to($('#edit_mdp'), 0.3, {css: {height: 0}}, "cacher");
                            tl.to($('#edit_mdp_titre'), 0.3, {css: {height: 0}}, "cacher");
                            tl.to($('#confirmation_mdp'), 0.3, {css: {height: 0}}, "cacher");
                            tl.to($('#confirmation_mdp_titre'), 0.3, {css: {height: 0}}, "cacher");
                            tl.to($("#edit_validation_bouton"), 0.3, {css: {height: 0}}, "cacher");
                            tl.to($("#edit_annulation_bouton"), 0.3, {css: {height: 0}}, "cacher");
                            tl.to($('#profil_login'), 0.3, {css: {height: "65px"}}, "afficher");
                            tl.to($('#profil_mdp'), 0.3, {css: {height: "65px"}}, "afficher");
                            tl.to($('#profil_mail'), 0.3, {css: {height: "65px"}}, "afficher");


                            tl.to($('#profil_mdp_texte'), 0.3, {autoAlpha: 0.8});
                            $("#profil_mdp_input").css({"pointer-events": "none"});

                        }

                        if ($("#edit_mail").height() > 0) {
                            tl.to($('#edit_mail'), 0.3, {css: {height: 0}}, "cacher");
                            tl.to($('#edit_validation'), 0.3, {css: {height: 0}}, "cacher");
                            tl.to($('#edit_mail_titre'), 0.3, {css: {height: 0}}, "cacher");
                            tl.to($('#edit_validation_titre'), 0.3, {css: {height: 0}}, "cacher");
                            tl.to($('#profil_mail_titre'), 0.3, {css: {height: 0}}, "cacher");
                            tl.to($("#edit_validation_bouton"), 0.3, {css: {height: 0}}, "cacher");
                            tl.to($("#edit_annulation_bouton"), 0.3, {css: {height: 0}}, "cacher");
                            tl.to($('#profil_login'), 0.3, {css: {height: "65px"}}, "afficher");
                            tl.to($('#profil_mdp'), 0.3, {css: {height: "65px"}}, "afficher");
                            tl.to($('#profil_mail'), 0.3, {css: {height: "65px"}}, "afficher");


                            tl.to($('#profil_mail_texte'), 0.3, {autoAlpha: 0.8});


                        }
                    });

                    $("#overlay_selection").click(function () {
                        window.location = '{{url("/choix")}}';
                    });
                    $("#overlay_deconnexion").click(function () {
                        window.location = '{{url("/logout")}}';
                    });
                    var rayonCercle = 2 * Math.PI * 148;
                    var zoomCercle1 = new TimelineMax();
                    var zoomCercle2 = new TimelineMax();
                    $("#formemail").on('submit', function (e) {
                        e.preventDefault();

                        $.ajax({
                            method: $(this).attr('method'),
                            url: $(this).attr('action'),
                            data: $(this).serialize(),
                            dataType: "json"})

                                .done(function (data) {
                                    $("#error").html(data['sucess']);
                                    var tl = new TimelineLite();
                                    tl.to($('#edit_mail'), 0.3, {css: {height: 0}}, "cacher");
                                    tl.to($('#edit_validation'), 0.3, {css: {height: 0}}, "cacher");
                                    tl.to($('#edit_mail_titre'), 0.3, {css: {height: 0}}, "cacher");
                                    tl.to($('#edit_validation_titre'), 0.3, {css: {height: 0}}, "cacher");
                                    tl.to($('#profil_mail_titre'), 0.3, {css: {height: 0}}, "cacher");
                                    tl.to($("#edit_validation_bouton"), 0.3, {css: {height: 0}}, "cacher");
                                    tl.to($("#edit_annulation_bouton"), 0.3, {css: {height: 0}}, "cacher");
                                    tl.to($('#profil_login'), 0.3, {css: {height: "65px"}}, "afficher");
                                    tl.to($('#profil_mdp'), 0.3, {css: {height: "65px"}}, "afficher");
                                    tl.to($('#profil_mail'), 0.3, {css: {height: "65px"}}, "afficher");
                                    tl.to($('#profil_mail_texte'), 0.3, {autoAlpha: 0, onComplete: function () {
                                            //if mdp correct et adresse mail valide
                                            $("#profil_mail_texte").empty().append($("#edit_mail_input").val());
                                            $("#edit_mail_input").val("");
                                            $("#edit_validation_input").val("");
                                        }});
                                    tl.to($('#profil_mail_texte'), 0.3, {autoAlpha: 0.8});
                                })
                                .fail(function (data) {
                                    var input = '';
                                    $('#error').empty();
                                    $.each(data.responseJSON.error, function (key, value) {

                                        input += '<div>' + value + '</div>';


                                    });
                                    $('#error').html(input);

                                    //$("#profil_mail_edit").click();

                                });



                    });
                    $("#formmdp").on('submit', function (e) {
                        e.preventDefault();

                        $.ajax({
                            method: $(this).attr('method'),
                            url: $(this).attr('action'),
                            data: $(this).serialize(),
                            dataType: "json"})

                                .done(function (data) {
                                    $("#error").html(data['sucess']);
                                    var tl = new TimelineLite();
                                    tl.to($('#edit_validation'), 0.3, {css: {height: 0}}, "cacher");
                                    tl.to($('#edit_validation_titre'), 0.3, {css: {height: 0}}, "cacher");
                                    tl.to($('#edit_mdp'), 0.3, {css: {height: 0}}, "cacher");
                                    tl.to($('#edit_mdp_titre'), 0.3, {css: {height: 0}}, "cacher");
                                    tl.to($('#confirmation_mdp'), 0.3, {css: {height: 0}}, "cacher");
                                    tl.to($('#confirmation_mdp_titre'), 0.3, {css: {height: 0}}, "cacher");
                                    tl.to($("#edit_validation_bouton"), 0.3, {css: {height: 0}}, "cacher");
                                    tl.to($("#edit_annulation_bouton"), 0.3, {css: {height: 0}}, "cacher");
                                    tl.to($('#profil_login'), 0.3, {css: {height: "65px"}}, "afficher");
                                    tl.to($('#profil_mdp'), 0.3, {css: {height: "65px"}}, "afficher");
                                    tl.to($('#profil_mail'), 0.3, {css: {height: "65px"}}, "afficher");

                                    tl.to($('#profil_mdp_texte'), 0.3, {autoAlpha: 0, onComplete: function () {
                                            //if mdp correct et nouveau mdp valide
                                            $("#edit_mdp_input").val("");
                                            $("#confirmation_mdp_input").val("");
                                        }});
                                    tl.to($('#profil_mdp_texte'), 0.3, {autoAlpha: 0.8});
                                    $("#profil_mdp_input").css({"pointer-events": "none"});
                                })
                                .fail(function (data) {
                                    var input = '';
                                    $('#error').empty();
                                    $.each(data.responseJSON.error, function (key, value) {

                                        input += '<div>' + value + '</div>';

                                    });
                                    $('#error').html(input);

                                    //$("#profil_mail_edit").click();

                                });



                    });
                    /* function animCercles(){
                     for(i=0;i<interets.length;i++){
                     document.getElementById("cercleAtelier"+(i)).addEventListener("mouseover", function(){
                     majCercle();
                     });
                     }
                     } */



                    /*$(document).ready(function()
                     {
     
                     $('#photo-profil-lien-front').click(function()
                     {
                     alert('cliqué');
     
                     return false;
                     });
     
     
                     });*/
                //FONCTIONS LIEN PROFIL AVATAR



                </script>
                <style>

                    /*STYLES POPUPS*/
                    .fichier
                    {
                        /*height:10%;*/
                        width: 20%;
                        background: white;
                        font-weight: bold;
                        color: white;
                        border: 0 none;
                        border-radius: 50px;
                        background: #f96332;
                        cursor: pointer;
                        padding: 10px 5px;
                        margin: 10px 5px;
                        font-family: 'Lato', sans-serif;
                        font-weight: 400;
                    }

                    .fichier:hover
                    {background: #FA6B3B;}

                    .fichier input {
                        position: absolute;
                        z-index: 2;
                        opacity: 0;
                        width:20%;
                        /*height:100%;*/
                        pointer-events: all;
                    }

                    .fleche_gauche_site_img
                    {
                        width:58px;/**/
                        height:168px;
                        margin: 0 40px 0 0;
                        background: #fff url("{{URL::asset('css/img/POPUP-SITES_ARROW_GAUCHE.png')}}") no-repeat;
                        pointer-events: all;

                    }
                    .dialog_operations
                    {
                        /*z-index:3000; width:100%; height:100%; position: fixed; top: 0; left: 0; background-color: rgba(0,0,0,0.95);*/
                        display:none;
                    }

                    .dialog_operations_over
                    {
                        /*z-index:3000; width:100%; height:100%; position: fixed; top: 0; left: 0; background-color: rgba(0,0,0,0.95);*/
                        display:none;
                    }

                    .contenu-cacher
                    {
                        display:none;
                    }

                    #popup_sites_over_dragupload.active_over, .popup_over_dragupload_exercices.active_over, #popup_over_dossier.active_over, #popup_sites_over_liensupload.active_over {

                        z-index:3000; width:100%; height:100%; padding:auto; position: fixed; top: 0; left: 0; background-color: rgba(0,0,0,0);
                        display: block;
                    }

                    #popup_sites.active, #popup_sites_chx.active, #popup_sites_over_dragupload.active, .popup_exercice_upload.active, #popup_sites_upload.active {

                        z-index:3000; width:100%; height:100%; position: fixed; top: 0; left: 0; background-color: rgba(0,0,0,0.25);
                        display: block;padding:auto; 
                    }

                    #popup_sites_intro.active
                    {
                        z-index:3000; width:100%; height:100%; position: fixed; top: 0; left: 0; background-color: rgba(0,0,0,0.95);
                        display: block;
                    }

                    #contenus_popup_sites, #contenus_popup_sites_chx, #contenus_popup_over_dragupload, #contenus_popup_over_liensupload, .contenus_popup_upload_exercice, .contenus_popup_over_dragupload_exercices, #contenus_popup_upload, #popup_intro
                    {
                        display:none;
                    }

                    #contenus_popup_sites.active, #contenus_popup_sites_chx.active, #contenus_popup_over_dragupload.active, #contenus_popup_over_liensupload.active, #contenus_popup_upload.active, .contenus_popup_upload_exercice.active, .contenus_popup_over_dragupload_exercices.active_over, .contenus_popup_over_dragupload_exercices.active, #popup_intro.active, #contenus_popup_over_dossier.active
                    {
                        display:block;
                    }

                    .content_popup_admin
                    {
                        width:1086px;
                        height:586px;
                        margin:auto;
                        padding:30px;
                        margin-top: 200px;
                        background:white;
                        /*display:none;*/


                    }

                    .bloc-boutons-submits
                    {
                        padding-top: 30px;
                        padding-right:auto; 
                        padding-left:auto; 
                        width:100%; 
                        text-align:center;
                    }

                    #popup_dossier .action-button {
                        height:60px;
                        width: 200px;
                        background: white;
                        font-weight: bold;
                        color: grey;
                        border: 0 none;
                        border-radius: 50px;
                        border: 1px;
                        border-style:solid;
                        border-color:grey;
                        cursor: pointer;
                        padding: 10px 5px;
                        margin: 10px 5px;
                        font-family: 'Lato', sans-serif;
                        font-weight: 400;
                    }

                    #popup_upload, #popup_upload_photo, #popup_dragupload_photo, #popup_dragupload_qcm, #popup_dossier, #popup_liensload_photo, .popup_dragupload_exercices, .popup_upload_photo_exercice
                    {
                        font-family: 'Lato', sans-serif;
                        color:grey;
                        height:800px;
                    }

                    #popup_upload .submit, #popup_upload_photo .submit, #popup_dragupload_photo .submit, #popup_dossier .submit, #popup_liensload_photo .submit
                    {
                        width: 100%;
                        height:60px;
                        background: white;
                        font-weight: bold;
                        color: white;
                        border: 0 none;
                        border-radius: 50px;
                        background: #f96332;
                        cursor: pointer;
                        padding: 5px 5px;
                        margin: 10px 5px;
                        font-family: 'Lato', sans-serif;
                        font-weight: 400;
                    }
                    #popup_upload .submit:hover, #popup_upload_photo .submit:hover, #popup_dragupload_photo .submit:hover, #popup_dossier .submit:hover, #popup_liensload_photo .submit:hover
                    {
                        background: #FA6B3B;
                    }

                    #popup_upload h1, #popup_upload_photo h1, #popup_dragupload_photo h1, #popup_dragupload_qcm h1, #popup_liensload_photo h1, #popup_dossier h1, .popup_exercice_upload h1, .popup_dragupload_exercices h1, .popup_upload_photo_exercice h1
                    {

                        font-weight: 700;
                        text-transform: uppercase;
                        text-align: center;

                    }

                    #popup_upload img, #popup_upload_photo img, #popup_liensload_photo img, .popup_exercice_upload img
                    {
                        margin-right: auto;
                        margin-left: auto;
                        margin-bottom: 120px;
                        display: block;


                    }

                    #popup_upload p, #popup_upload_photo p, #popup_dragupload_photo p, #popup_dragupload_qcm p, #popup_liensload_photo p, #popup_dossier p, .popup_exercice_upload p
                    {

                        font-weight: 300;

                        text-align: center;

                    }

                    /*DRAGUPLOAD*/
                    .upload_dropzone
                    {
                        border: 2px dotted #f96332;
                        width:658px;
                        height:361px;
                        padding:50px;
                        text-align: center;



                    }
                    .upload_dropzone img
                    {
                        margin-right: auto;
                        margin-left: auto;
                        margin-bottom: 0px;
                        display: block;
                    }


                    /*FIN STYLES POPUPS*/
                    body, html{
                        -webkit-touch-callout: none;
                        -webkit-user-select: none;
                        -khtml-user-select: none;
                        -moz-user-select: none;
                        -ms-user-select: none;
                        user-select: none;
                        background-color: transparent;
                        overflow: hidden;
                        font-family: 'Lato', sans-serif;
                        cursor: default;
                    }
                    input{
                        border: 0;
                        outline: 0;
                        background: transparent;
                        width: 165px;
                        font-family: 'Lato', sans-serif;
                    }
                    #bloc_ateliers{
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 55%;
                        height: 100%;
                        background-color: black;
                        opacity: 0.85;
                    }
                    #contenu_ateliers{
                        position: relative;
                        width: 500px;
                        height: 500px;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                    }
                    #bloc_identifiants{
                        position: absolute;
                        top: 0;
                        right: 0;
                        width: 45%;
                        height: 100%;
                        background-color: #fa7346;
                    }
                    #bloc_img_ateliers{
                        width: 100%;
                        height: 100%;
                    }
                    #ateliers_exercices{
                        position: relative;
                        top: 0;
                        font-family: 'Lato', sans-serif;
                        font-size: 10.5px;
                        color: #ffffff;
                        font-weight: 300;
                        text-align: center;
                    }
                    #ateliers_exercices_nombre{
                        font-size: 15px;
                    }
                    #ateliers_nom{
                        position: absolute;
                        bottom: 0;
                        width: 500px;
                        left: 50%;
                        font-family: 'Lato', sans-serif;
                        font-size: 15px;
                        color: #ffffff;
                        font-weight: 300;
                        text-align: center;
                        transform: translate(-50%, 0%);
                    }
                    #cercleLigne{
                        position: absolute;
                        width: 300px;
                        height: 300px;
                        top: 50%;
                        left: 50%;
                        transform-origin: 50% 50%;
                        transform: translate(-50%, -50%) rotate(270deg);
                    }
                    #cercleImg1, #cercleImg2{
                        position: absolute;
                        width: 300px;
                        height: 300px;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                    }
                    #cercleImg2{
                        opacity: 0;
                    }
                    .cercleStyle{
                        position: absolute;
                        width: 20px;
                        height: 20px;
                        top: 50%;
                        left: 50%;
                        text-align: center;
                    }


                    #contenu_identifiants{
                        position: fixed;
                        width: 500px;
                        top: 50%;
                        left: 76%;
                        transform: translate(-50%, -50%);
                        pointer-events: none;
                    }
                    #bloc_img{
                        width: 100%;
                        height: 100%;
                        margin-bottom: 60px;
                    }
                    #img_site{
                        position: relative;
                        width: 120px;
                        height: 120px;
                        border-radius: 90px;
                        -webkit-border-radius: 90px;
                        -moz-border-radius: 90px;
                        left: 50%;
                        transform: translate(-50%, 0%);
                        pointer-events: all;
                    }
                    #profil_login, #profil_mail, #profil_mdp, #edit_mail, #edit_validation, #edit_mdp, #confirmation_mdp{
                        position: relative;
                        overflow: hidden;
                        z-index: 31;
                        pointer-events: all;
                    }
                    #profil_login_icon, #profil_mail_icon, #profil_mdp_icon, #edit_mail_icon, #edit_validation_icon, #edit_mdp_icon, #confirmation_mdp_icon{
                        position: absolute;
                        left: 140px;
                        opacity: 0.8;
                        width: 18px;
                        top: 32.5px;

                        transform: translate(0%, -50%);
                    }
                    #profil_login_edit, #profil_mail_edit, #profil_mdp_edit{
                        position: absolute;
                        left: 340px;
                        opacity: 0;
                        width: 18px;
                        top: 32.5px;

                        transform: translate(0%, -50%);
                    }
                    .profil_login_label, .profil_mail_label, .profil_mdp_label, .edit_mail_label, .edit_validation_label, .edit_mdp_label, .confirmation_mdp_label{
                        position: absolute;
                        font-size: 10.5px;
                        color: #ffffff;
                        font-weight: 300;
                        left: 170px;
                        opacity: 0.8;
                        pointer-events: none;
                        top: 32.5px;

                        transform: translate(0%, -50%);
                    }
                    #profil_mail_titre, #edit_mail_titre, #edit_validation_titre, #edit_mdp_titre, #confirmation_mdp_titre{
                        position: relative;
                        top: 0;
                        left: 50%;
                        width: 500px;
                        height: 0;
                        opacity: 0.8;
                        text-align: center;
                        font-size: 14px;
                        color: #ffffff;
                        font-weight: 300;
                        overflow: hidden;

                        transform: translate(-50%, 0%);
                    }
                    #profil_login_texte, #profil_mail_texte, #profil_mdp_texte, #edit_mail_texte, #edit_validation_texte, #edit_mdp_texte, #confirmation_mdp_texte{
                        width: 165px;
                        overflow: hidden;
                    }
                    #edit_mail, #edit_validation, #edit_mdp, #confirmation_mdp{
                        height: 0;
                    }
                    #edit_mail_input, #edit_validation_input, #edit_mdp_input, #confirmation_mdp_input, #edit_validation_bouton, #edit_annulation_bouton{
                        pointer-events: all;
                    }
                    #edit_validation_bouton{
                        position: relative;
                        height: 0;
                        margin-top: 33px;
                        overflow: hidden;
                        /*	float:left;
                                        width:150px;
                                        left:25%*/
                    }
                    #edit_annulation_bouton{
                        margin:20px 0 0 25px;
                        height: 0;
                        overflow: hidden;

                    }
                    #retour_img{pointer-events: none;}
                    #edit_validation_bouton_svg{
                        position: absolute;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                        pointer-events: none;
                    }


                    #edit_validation_bouton_label{
                        position: absolute;
                        top: 50%;
                        left: 50%;
                        font-weight: 300;
                        font-size: 15px;
                        color: #ffffff;
                        opacity: 0.8;
                        pointer-events: none;
                        transform: translate(-50%, -50%);
                    }

                    #error{color:#ffffff; font-weight: 700; text-align:center; padding: 10px; }
                    #profil_login_svg, #profil_mail_svg, #profil_mdp_svg, #edit_mail_svg, #edit_validation_svg, #edit_mdp_svg, #confirmation_mdp_svg, #edit_validation_bouton_svg{
                        pointer-events: none;
                    }
                    #overlay_croix{
                        position: absolute;
                        top: 0;
                        right: 0;
                        width: 200px;
                        height: 50px;
                        color: white;
                        font-family: 'Lato', sans-serif; 
                        font-weight: 400;
                        font-size: 15px;
                        text-align: center;
                        pointer-events: all;
                    }
                    #croix{
                        position: fixed;
                        top: 3%;
                        left: 93%;
                        transform: translate(-50%, -50%);
                    }
                    #overlay_selection{
                        position: absolute;
                        bottom: 0;
                        left: 0;
                        width: 210px;
                        height: 50px;
                        color: white;
                        font-family: 'Lato', sans-serif; 
                        font-weight: 400;
                        font-size: 15px;
                        text-align: center;
                        pointer-events: all;
                    }
                    #selection{
                        position: relative;
                        height: 30px;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                    }
                    #overlay_deconnexion{
                        position: absolute;
                        bottom: 0;
                        right: 0;
                        width: 210px;
                        height: 50px;
                        color: white;
                        font-family: 'Lato', sans-serif; 
                        font-weight: 400;
                        font-size: 15px;
                        text-align: center;
                        pointer-events: all;
                    }
                    #deconnexion{
                        position: relative;
                        height: 30px;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                    }
                    #deconnexion_label, #selection_label{
                        margin-left: 10px;
                    }
                    #deconnexion_img, #selection_img{
                        position: relative;
                        top: 50%;
                        transform: translate(0, -50%);
                    }
                </style>