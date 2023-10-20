<!-- POPUPS UPLOAD EXERCICES -->
<div id="popup_exercice_upload" class="popup_exercice_upload dialog_operations popupparent_exercices">
    <a href="#" id="close_sites_upload_exercices" class="fermerpopup_exercices" style="font-family: 'Lato', sans-serif;font-weight: 300;color:white;font-size:30px; float:right; padding:20px;">FERMER X</a>
    <div id="contenus_popup_upload_exercice" class="contenus_popup_upload_exercice contenu-cacher">
        <div id="popup_upload_photo" class="popup_upload_photo_exercice content_popup_admin">
            <div class="row" style="padding:10%;">
                <div class="row">
                    <div class="col-lg-4" style="border-right: 1px solid #ccc; padding-left: 60px; padding-right: 60px;">
                        <div class="row"><img src="{{ URL::asset('css/img/ICON_POPUP_UPLOAD_DOWNLOAD.png') }}" align="middle"></div>
                        <div class="row"><h1>UPLOAD</h1></div>
                        <div class="row"><p>Telechargez votre fichier depuis votre ordinateur</p><br></div>
                        <div class="row">
                            <div class="bloc-boutons-submits">
                                {{ Form::submit('Continuer', ['name' => 'chx_afficher_upload_exercice', 'id' => 'chx_afficher_photo_upload_exercice', 'class' => 'submit action-button', 'style' => 'width: 100%;']) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4" style="border-right: 1px solid #ccc; padding-left: 60px; padding-right: 60px;">
                        <div class="row"><img src="{{ URL::asset('css/img/ICON_POPUP_UPLOAD_LIENS.png') }}"></div>
                        <div class="row"><h1>LIENS</h1></div>
                        <div class="row"><p>Importez votre fichiers depuis une source externe</p></div>
                        <div class="row">
                            <div class="bloc-boutons-submits">
                                {{ Form::submit('Continuer', ['name' => 'chx_photo_externe_exercice', 'id' => 'chx_afficher_photo_externe_exercice', 'class' => 'submit action-button', 'style' => 'width: 100%;']) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4" style="padding-left: 60px; padding-right: 60px;">
                        <div class="row"><img src="{{ URL::asset('css/img/ICON_POPUP_UPLOAD_FICHIERS.png') }}"></div>
                        <div class="row"><h1>FICHIERS</h1></div>
                        <div class="row"><p>Choisissez votre fichier depuis votre dossier personnel</p></div>
                        <div class="row">
                            <div class="bloc-boutons-submits ">
                                {{ Form::submit('Continuer', ['name' => 'chx_afficher_photo_dossier_exercice', 'id' => 'chx_afficher_photo_dossier_exercice', 'class' => 'submit action-button', 'style' => 'width: 100%;']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- POPUP DRAG'N'DROP UPLOADS EXERCICES -->
<div id="popup_exercices_over_dragupload" class="popup_over_dragupload_exercices dialog_operations_over">
    <div id="contenus_popup_over_dragupload_exercices" class="contenus_popup_over_dragupload_exercices contenu-cacher"> 
        <div id="popup_dragupload_exercices" class="popup_dragupload_exercices content_popup_admin">
            <div class="fleche_gauche_exercices fermerpopup_over_exercices" style="float:left; position:absolute; border:none; margin-top:300px; width:84px;"><div class="fleche_gauche_site_img"></div></div>
            <div class="row">
                <div class="row">
                    <div class="row" style="margin-bottom:60px;"><h1>UPLOAD</h1></div>
                    <div class="row">
                        <div id="upload_dropzone_intro_exercices" class="upload_dropzone" style="margin:auto;">
                            <img id="icondragupload_exercices" class="icondragupload" src="{{ URL::asset('css/img/ICON_POPUP_UPLOAD_DOWNLOAD_DRAG.png') }}" align="middle" style="margin-bottom:50px;">
                            <div id="instruction_exercices" class="zone-message"><h1>DEPOSEZ VOTRE FICHIER ICI</h1></br>500Mo Maximum</div>
                            <div class="row">
                                <div class="zone-image-preview" style="margin-left:auto; margin-right:auto;"></div>
                                <div class="zone-image-infos" style="margin-left:auto; margin-right:auto;"></div>
                                <div style="width:10%; display:inline; float:left;">
                                    <button id="enlever" class="enlever" style="color:black; background:#fff; font-size: 16px; width:20px; height:60px; border-radius:50%; border:none; box-shadow:none; display:none;">
                                        <span class="glyphicon glyphicon-refresh"></span>								          
                                    </button>
                                </div>
                            </div>
                            <div id="bouton_upload_exercices" class="row bouton_upload" style="display:none;">
                                <br><br>
                                <div class="bloc-boutons-submits">
                                    <a href="#" id="close_sites_dragupload_exercices" class="lancer fermerpopup_over submit" style="height:60px; width: 100%; display:block; text-decoration: none; padding-top: 20px;margin: auto;">TERMINER</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br><br>
                <div id="container-form-direct-upload-exercice" class="row bloc-upload-manuel" style="text-align:center; padding:auto;">
                    {{  Form::open(array('route' => 'uploader', 'files' => true, 'id' => 'chx-upload-photo-exercice-direct')) }}
                    <div style="width:50%; display:inline; float:left; padding-top:20px; text-align:right;">ou télécharger depuis votre ordinateur </div>
                    <div style="width:20%; display:inline; float:left;">
                        <div class="fichier" style="width:100%;">
                            {{ Form::file('file', ['id' => 'chx_photo_exercices', 'accept' => '.png, .jpg']) }}
                            {{ Form::hidden('depuis', 'editeur_exercice') }}
                            {{ Form::hidden('type_contenu', '', ['id' => 'chx_photo_exercices_type']) }}
                            {{ Form::submit('', ['id' => 'chx_photo_exercices_submit', 'style' => 'display: none;']) }}
                            <span>UPLOAD</span>
                        </div>
                    </div>
                    {{  Form::close() }}	
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIN POPUP DRAG'N'DROP UPLOADS EXERCICES -->

<!-- POPUP LIENS EXERCICES -->
<div id="popup_exercices_over_liensupload" class="popup_over_liensupload_exercices popup_exercice_upload dialog_operations_over">
    <div id="contenus_popup_over_liensupload_exercices" class="contenus_popup_over_dragupload_exercices contenu-cacher">
        <div id="popup_liensload_photo_exercices" class="content_popup_admin">
            <div class="fleche_gauche_exercices fermerpopup_over_exercices" style="float: left;position: absolute;border: none;margin-top: 300px;width: 84px;">
                <div class="fleche_gauche_site_img"></div>
            </div>
            <div class="row" style="margin-top: 30px;">
                <div class="row">
                    <div class="row" style="margin-bottom: 60px;"><h1>LIENS</h1></div>
                    <div class="row">
                        <img id="iconliensupload_exercices" class="iconliensupload" src="{{ URL::asset('css/img/ICON_POPUP_UPLOAD_LIENS.png') }}" align="middle" style="margin-bottom: 50px;">
                        <div id="instruction_liens_exercices" class="zone-message"><h1>COLLEZ LE LIEN EXTERNE CI-DESSOUS</h1></div>
                        <div class="row" style="margin-left: auto;margin-right: auto">
                            <div class="row" style="margin: auto;text-align: center;">
                                {{ Form::text('input_lien_upload_exercices', '', ['id' => 'input_lien_upload_exercices', 'style' => 'width: 500px;']) }}
                            </div>
                        </div>
                        <div id="boutons_liens_exercices" class="row bouton_upload" style="margin-bottom: 130px;">
                            <br><br>
                            <div class="bloc-boutons-submits">
                                <a href="#" id="submit_lienupload_exercices" class="lancer_liens fermerpopup_over submit" style="height: 60px;width: 50%;display: block;text-decoration: none;padding-top: 20px;margin: auto">TERMINER</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIN POPUP LIENS EXERCICES -->

<!-- POPUP DOSSIER EXERCICES -->
<div id="popup_over_dossier_exercice" class="popup_over_dragupload_exercices dialog_operations_over">
    <div id="contenus_popup_over_dossier_exercice" class="contenus_popup_over_dragupload_exercices contenu-cacher">
        <div id="popup_dossier_exercice" class="popup_dragupload_exercices content_popup_admin">
            <div class="fleche_gauche_exercices fermerpopup_over_exercices fleche_gauche_table" style="float:left; position:absolute; border:none; margin-top:300px;"><div class="fleche_gauche_site_img"></div></div>
            <div class="row" style="padding: 50px 35px 50px 65px;">
                <div class="row">
                    <div class="row contenu-cacher" id="popup_dossier_apercu_exercice"></div>
                    <div class="row" id="popup_dossier_contenu_exercice">	
                        <div class="table-responsive" style="width: 100%;height: 520px;overflow: hidden;">
                            <table id="files_table_exercices" class="table table-striped table-bordered compact"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIN POPUP DOSSIER EXERCICES -->