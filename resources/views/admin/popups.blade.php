
<div id="popup_sites_intro" class="dialog_operations">
    <a href="#" id="close_sites_intros" class="fermerpopup" style="font-family: 'Lato', sans-serif;font-weight: 300;color:white;font-size:30px; float:right; padding:20px;">FERMER X</a>
    <div id="popup_intro" class="content_popup_front contenu-cacher"></div>
</div>

<!-- UPLOADS -->
<div id="popup_sites_upload" class="dialog_operations popupparent">
    <div id="contenus_popup_upload" class="contenu-cacher">
        <div id="popup_upload_photo" class="content_popup_admin">
            <a href="#" id="close_sites_upload" class="fermerpopup" style="font-family: 'Lato', sans-serif;font-weight: 300;color:grey;font-size:20px;float:right;padding:10px; ">&times;</a>
            <div class="row" style="padding:50px">
                <form id="chx-upload-photo-exercice" action="#">
                    <div class="row" >
                        @if($chxrubrique == 'tp')
                        <div class="col-lg-4" style="border-right: 1px solid #ccc; padding-left: 60px; padding-right: 60px;">
                            @endif
                            <div class="row"><img src="{{ URL::asset('css/img/ICON_POPUP_UPLOAD_DOWNLOAD.png') }}" align="middle"></div>
                            <div class="row"><h1>UPLOAD</h1></div>
                            <div class="row"><p>Telechargez votre fichier depuis votre ordinateur</p></div>
                            <div class="row">
                                <div class="bloc-boutons-submits"><input type="submit" name="chx_afficher_upload_intro" id="chx_afficher_photo_upload_intro" class="submit action-button" value="Continuer" /></div>
                            </div>
                            @if($chxrubrique == 'tp')
                        </div>
                        @endif
                        @if($chxrubrique == 'tp')
                        <div class="col-lg-4" style="border-right: 1px solid #ccc; padding-left: 60px; padding-right: 60px;">
                            <div class="row"><img src="{{ URL::asset('css/img/ICON_POPUP_UPLOAD_LIENS.png') }}"></div>
                            <div class="row"><h1>LIENS</h1></div>
                            <div class="row"><p>Importez votre fichiers depuis une source externe</p></div>
                            <div class="row">
                                <div class="bloc-boutons-submits"><input type="submit" name="chx_photo_externe_intro" id="chx_afficher_photo_externe_intro"  class="submit action-button" value="Continuer" /></div>
                            </div>
                        </div>
                        @endif
                        @if($chxrubrique == 'tp')
                        <div class="col-lg-4" style="padding-left: 60px; padding-right: 60px;">
                            <div class="row"><img src="{{ URL::asset('css/img/ICON_POPUP_UPLOAD_FICHIERS.png') }}"></div>
                            <div class="row"><h1>FICHIERS</h1></div>
                            <div class="row"><p>Choisissez votre fichier depuis votre dossier personnel</p></div>
                            <div class="row">
                                <div class="bloc-boutons-submits"><input type="submit" name="chx_photo_dossier_intro" id="chx_afficher_photo_dossier_intro"  class="submit action-button" value="Continuer"/></div>
                            </div>
                        </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- LIENS  -->
<div id="popup_sites_over_liensupload" class="dialog_operations_over">
    <div id="contenus_popup_over_liensupload" class="contenu-cacher">
        <div id="popup_liensload_photo" class="content_popup_admin">
            <a href="#" class="fleche_gauche_site fermerpopup_over" style="float:left; position:absolute; border:none; margin-top:300px; width:84px;">
                <div class="fleche_gauche_site_img"></div>
            </a>
            <div class="row">
                <div class="row">
                    <div class="row" style="margin-bottom:60px;"><h1>LIENS</h1></div>
                    <div class="row">
                        <img id="iconliensupload" class="iconliensupload" src="{{ URL::asset('css/img/ICON_POPUP_UPLOAD_LIENS.png') }}" align="middle" style="margin-bottom:50px;">
                        <div id="instruction" class="zone-message"><h1>COLLEZ LE LIEN EXTERNE CI-DESSOUS</h1></div><br>
                        <div class="row" style="margin-left:auto; margin-right:auto;">
                            <div class="row" style="margin:auto; text-align:center;">
                                <input type="text" id="input_lien_upload" name="input_lien_upload" style="width:500px;">
                            </div>
                            <div id="bouton_liens_intro" class="row bouton_upload">
                                <br><br>
                                <div class="bloc-boutons-submits">
                                    <a href="#" id="submit_lienupload" class="lancer_liens fermerpopup_over submit" style="height:60px; width: 50%; display:block; text-decoration: none; padding-top: 20px;margin: auto;">TERMINER</a>
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
        <div id="popup_dragupload_photo" class="content_popup_admin">
            <a href="#" class="fleche_gauche_site fermerpopup_over" style="float:left; position:absolute; border:none; margin-top:300px; width:84px;">
                <div class="fleche_gauche_site_img"></div>
            </a>
            <div class="row">                
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
                                    <button id="enlever" class="enlever" style="color:black; background:#fff; font-size: 16px; width:20px; height:60px; border-radius:50%; border:none; box-shadow:none; display:none;">
                                        <span class="glyphicon glyphicon-refresh"></span>								          
                                    </button>
                                </div>
                            </div>
                            <div id="bouton_upload_intro" class="row bouton_upload" style="display:none;">
                                <br><br>
                                <div class="bloc-boutons-submits">
                                    <a href="#" id="close_sites_dragupload" class="lancer fermerpopup_over submit" style="height:60px; width: 100%; display:block; text-decoration: none; padding-top: 20px; margin: auto;">TERMINER</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(Session::has('rubrique'))
                <?php $chxrubrique = Session::get('rubrique') ?>
                @if($chxrubrique  == 'profil')
                <div class="row bloc-upload-manuel" style="text-align:center; padding:auto;">
                    {{  Form::open(array('route' => 'uploader', 'files' => true, 'id' => 'chx-upload-photo-intro')) }}
                    <div style="width:50%; display:inline; float:left; padding-top:20px; text-align:right;">ou télécharger depuis votre ordinateur </div>
                    <div style="width:20%; display:inline; float:left;">
                        <div class="fichier" style="width:100%;">
                            <input type="file" onchange="upload_manuel_profil(this.id, this.form.id);" name="chx_photo_intro" id="chx_photo_intro" accept="image/*"/>
                            <span>UPLOAD</span>
                        </div>
                    </div>
                    {{  Form::close() }}	
                </div>
                @else
                <div class="row bloc-upload-manuel" style="text-align:center; padding:auto;">
                    {{  Form::open(array('route' => 'uploader', 'files' => true, 'id' => 'chx-upload-photo-intro')) }}
                    <div style="width:50%; display:inline; float:left; padding-top:20px; text-align:right;">ou télécharger depuis votre ordinateur </div>
                    <div style="width:20%; display:inline; float:left;">
                        <div class="fichier" style="width:100%;">
                            <input type="file" onchange="upload_manuel(this.id, this.form.id);" name="chx_photo_intro" id="chx_photo_intro" accept="image/*"/>
                            <span>UPLOAD</span>
                        </div>
                    </div>
                    {{  Form::close() }}	
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
</div>
<!-- FIN POPUP DRAG'N'DROP UPLOADS -->

<!-- POPUP DOSSIER -->
@if($chxrubrique == 'tp' )
<div id="popup_over_dossier" class="dialog_operations_over">
    <div id="contenus_popup_over_dossier" class="contenu-cacher">
        <div id="popup_dossier" class="content_popup_admin">
            <a href="#" class="fleche_gauche_dossier" style="float:left; position:absolute; border:none; margin-top:300px;"><div class="fleche_gauche_site_img"></div></a>
            <div class="row" style="padding:50px">
                <div class="row" id="popup_dossier_apercu" class="contenu-cacher"></div>
                <div class="row" id="popup_dossier_contenu">
                    <div class="table-responsive" style="width: 100%;height: 520px;overflow: hidden;">
                        <table id="files_table" class="table table-striped table-bordered compact">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<!-- FIN POPUPS -->