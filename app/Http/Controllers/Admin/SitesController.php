<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\TpnRepository;
use App\Models\Tpn;
use App\Models\Site;
use App\Models\Atelier;
use App\Models\Atelier_tpn;
use App\Models\Exercice_user;
use App\Models\Exercice;
use App\Models\Classe_tpn;
use App\Models\Question;
use App\Models\Reponse;
use App\Models\Reponse_user;
use App\Helpers\Common;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;
use Auth;

class SitesController extends Controller {

    protected $tpnRepository;
    protected $checkboxes_selection;
    protected $titre;
    protected $descr;
    //INPUT HIDDEN ETAT = 
    protected $etat;
    //ID SITE CHOISI
    protected $site_id;
    //INFOS BROUILLON
    protected $etat_actuel;
    //$liste_atelier = $this->checkboxes_selection;
    //LISTE DES ATELIERS CHOISIS (CHECKBOXES)
    protected $liste_atelier;
    //$liste_atelier = Request::input('selection_atelier');
    //INPUT ATELIERS
    protected $liste_titres_ateliers;
    protected $liste_descr_ateliers;
    //CONTENU INTRO
    protected $intro_tp;

    public function __construct() {
        $tpRepository = new TpnRepository;
        $this->tpnRepository = $tpRepository;
    }

    public function nouveau() {
        $this->setIntroSessionSite();

        if (Session::has('enmodification')) {
            Session::forget('enmodification');
        }

        $sites = Site::all();

        if (Session::has('etatBrouillonSite')) {
            $etat_actuel = Session::get('etatBrouillonSite');
        } else {
            $etat_actuel = "false";
        }

        $now = Carbon::now('Europe/Paris');

        $titre_tp = "";
        $descr_tp = "";
        $intro_tp = "";
        $etat = "";
        $id_session_site = "";
        $nom_site = "";
        $tag_site = "";
        $carte_site = "";
        $carte_sentier_site = "";
        $sommaire_video = "";
        $photo_site = "";

        return view('admin.sitenouveau', ['carte_sentier_site' => $carte_sentier_site, 'carte_site' => $carte_site, 'tag_site' => $tag_site, 'etat_actuel' => $etat_actuel, 'etat' => $etat, 'insereId' => "", 'date_creation' => $now, 'intro_tp' => $intro_tp, 'etat' => $etat, 'titre_tp' => $titre_tp, 'descr_tp' => $descr_tp, 'sites' => $sites, 'id_session_site' => $id_session_site, 'nom_site' => $nom_site, 'video_sommaire' => $sommaire_video, 'photo_site' => $photo_site]);
    }

    public function creerSite(Request $request) {

        if (Session::get('etapeActiveSite') === 'fieldsiteintro') {

            $rules = ['nom_site' => 'required|min:3|Regex:/^[0-9A-Za-z-éèàùêç\'\s]{3,}$/', 'tag_site' => 'required|min:3|max:15|Regex:/^[A-Za-z0-9_\-]{3,15}$/', 'photo_site' => 'required|file|image', 'video_sommaire' => 'required|file|max:204800', 'carte_sommaire' => 'required_if:type-carte,fixe|file|image', 'sentier_sommaire' => 'required_if:type-carte,fixe|file|image', 'map-latmin' => 'numeric|min:-90.0|max:90.0|required_if:type-carte,dynamic|lt:map-latmax', 'map-latmax' => 'numeric|min:-90.0|max:90.0|required_if:type-carte,dynamic|gt:map-latmin', 'map-lonmin' => 'numeric|min:-180.0|max:180.0|required_if:type-carte,dynamic|lt:map-lonmax', 'map-lonmax' => 'numeric|min:-180.0|max:180.0|required_if:type-carte,dynamic|gt:map-lonmin', 'audio-out-min' => 'array', 'audio-out-min.*' => 'numeric|min:-0.1|max:1.1', 'audio-in-min' => 'array', 'audio-in-min.*' => 'numeric|min:-0.1|max:1.1', 'audio-in-max' => 'array', 'audio-in-max.*' => 'numeric|min:-0.1|max:1.1', 'audio-out-max' => 'array', 'audio-out-max.*' => 'numeric|min:-0.1|max:1.1', 'audio-files' => 'array', 'audio-files.*' => 'file|mimes:mp3'];

            $this->validate($request, $rules);

            # Creation du dossier pour stocker tous les fichiers du site
            $short_path = DIRECTORY_SEPARATOR . 'final' . DIRECTORY_SEPARATOR . 'tpn' . DIRECTORY_SEPARATOR . filter_var($request->get('tag_site'), FILTER_SANITIZE_STRING);
            $base_path = public_path() . $short_path;

            if (!file_exists($base_path)) {
                $old_mask = umask(0);
                mkdir($base_path, 0775);
                umask($old_mask);
            }
            # Stockage de la vignette du site sur le serveur
            if ($request->file('photo_site')->isValid()) {
                do {
                    if ($request->file('photo_site')->move($base_path, filter_var($request->file('photo_site')->getClientOriginalName(), FILTER_SANITIZE_STRING))) {
                        break;
                    }
                } while (true);
            }

            # Stockage de la video sommaire sur le serveur
            if ($request->file('video_sommaire')->isValid()) {
                do {
                    if ($request->file('video_sommaire')->move($base_path, filter_var($request->file('video_sommaire')->getClientOriginalName(), FILTER_SANITIZE_STRING))) {
                        break;
                    }
                } while (true);
            }

            if ($request->input('type-carte') === 'fixe') {

                # Stockage de l'image de la carte du site sur le serveur
                if ($request->file('carte_sommaire')->isValid()) {
                    do {
                        if ($request->file('carte_sommaire')->move($base_path, filter_var($request->file('carte_sommaire')->getClientOriginalName(), FILTER_SANITIZE_STRING))) {
                            break;
                        }
                    } while (true);
                }

                # Stockage de l'image du sentier sur le serveur
                if ($request->file('sentier_sommaire')->isValid()) {
                    do {
                        if ($request->file('sentier_sommaire')->move($base_path, filter_var($request->file('sentier_sommaire')->getClientOriginalName(), FILTER_SANITIZE_STRING))) {
                            break;
                        }
                    } while (true);
                }
            }

            $sounds = [];

            # On passe en revue tous les sons
            if($request->file('audio-files') !== null) {
                foreach ($request->file('audio-files') as $key => $sound) {

                    $tmp = [];

                    if (is_null($sound)) {
                        continue;
                    }

                    # Creation du dossier pour les sons
                    if (!file_exists($base_path . DIRECTORY_SEPARATOR . 'snd')) {
                        $old_mask = umask(0);
                        mkdir($base_path . DIRECTORY_SEPARATOR . 'snd', 0777);
                        umask($old_mask);
                    }

                    # Stockage du son sur le serveur
                    if ($sound->isValid()) {
                        do {
                            if ($sound->move($base_path . DIRECTORY_SEPARATOR . 'snd', filter_var($sound->getClientOriginalName(), FILTER_SANITIZE_STRING))) {
                                break;
                            }
                        } while (TRUE);
                    }

                    $tmp['sound'] = ['tpn' . DIRECTORY_SEPARATOR . $request->get('tag_site') . DIRECTORY_SEPARATOR . 'snd' . DIRECTORY_SEPARATOR . filter_var($sound->getClientOriginalName(), FILTER_SANITIZE_STRING)];
                    $tmp['range'] = [floatval($request->get('audio-out-min')[$key]), floatval($request->get('audio-in-min')[$key]), floatval($request->get('audio-in-max')[$key]), floatval($request->get('audio-out-max')[$key])];

                    array_push($sounds, $tmp);
                }
            }

            $newSite = new Site();

            $newSite->titre = filter_var($request->get('nom_site'), FILTER_SANITIZE_STRING);
            $newSite->photo = $short_path . DIRECTORY_SEPARATOR . filter_var($request->file('photo_site')->getClientOriginalName(), FILTER_SANITIZE_STRING);
            $newSite->video = $short_path . DIRECTORY_SEPARATOR . filter_var($request->file('video_sommaire')->getClientOriginalName(), FILTER_SANITIZE_STRING);
            $newSite->img_mini_map = $request->get('type-carte') === 'fixe' ? $short_path . DIRECTORY_SEPARATOR . filter_var($request->file('carte_sommaire')->getClientOriginalName(), FILTER_SANITIZE_STRING) : '';
            $newSite->img_sentier = $request->get('type-carte') === 'fixe' ? $short_path . DIRECTORY_SEPARATOR . filter_var($request->file('sentier_sommaire')->getClientOriginalName(), FILTER_SANITIZE_STRING) : '';
            $newSite->dossier = $short_path;
            $newSite->sound = json_encode($sounds, JSON_THROW_ON_ERROR);
            $newSite->sig_map = $request->get('type-carte') === 'dynamic';
            $newSite->latmin = $request->get('type-carte') === 'dynamic' ? floatval($request->get('map-latmin')) : 0.0;
            $newSite->latmax = $request->get('type-carte') === 'dynamic' ? floatval($request->get('map-latmax')) : 0.0;
            $newSite->lonmin = $request->get('type-carte') === 'dynamic' ? floatval($request->get('map-lonmin')) : 0.0;
            $newSite->lonmax = $request->get('type-carte') === 'dynamic' ? floatval($request->get('map-lonmax')) : 0.0;

            if ($newSite->save()) {
                return redirect()->route('admin::site::atelier::get', ['id_site' => $newSite->id, 'id_atelier' => 'new']);
            }
        } else {
            return Response::json(['erreur' => 'problème']);
        }
    }

    public function gerer() {
        if (Session::has('rubrique')) {
            Session::forget('rubrique');
            Session::put('rubrique', 'gestionsite');
        } else {
            Session::put('rubrique', 'gestionsite');
        }

        if (Session::has('sitessrub')) {
            Session::forget('sitessrub');
            Session::put('sitessrub', 'gerer');
        } else {
            Session::put('sitessrub', 'gerer');
        }

        $this->reset_session();

        $infosSites = Site::getShortInfos();

        if ((is_countable($infosSites) ? count($infosSites) : 0) === 0) {
            $this->setIntroSessionSite();

            if (Session::has('enmodification')) {
                Session::forget('enmodification');
            }

            $sites = Site::all();

            if (Session::has('etatBrouillonSite')) {
                $etat_actuel = Session::get('etatBrouillonSite');
            } else {
                $etat_actuel = "false";
            }

            $now = Carbon::now('Europe/Paris');

            $titre_tp = "";
            $descr_tp = "";
            $intro_tp = "";
            $etat = "";
            $id_session_site = "";
            $nom_site = "";
            $tag_site = "";
            $carte_site = "";
            $carte_sentier_site = "";
            $sommaire_video = "";
            $photo_site = "";

            return view('admin.sitenouveau', ['carte_sentier_site' => $carte_sentier_site, 'carte_site' => $carte_site, 'tag_site' => $tag_site, 'etat_actuel' => $etat_actuel, 'etat' => $etat, 'insereId' => "", 'date_creation' => $now, 'intro_tp' => $intro_tp, 'etat' => $etat, 'titre_tp' => $titre_tp, 'descr_tp' => $descr_tp, 'sites' => $sites, 'id_session_site' => $id_session_site, 'nom_site' => $nom_site, 'video_sommaire' => $sommaire_video, 'photo_site' => $photo_site]);
        } else {
            return view('admin.gerersite', ['infos_sites' => $infosSites]);
        }
    }

    public function suppression($id) {
        $site = Site::find($id);

        $tpns = Tpn::where('site_id', $id)->get();
        foreach ($tpns as $tpn) {
            $classes = Classe_tpn::where('tpn_id', $tpn->id)->get();
            foreach ($classes as $classe) {
                $classe->delete();
            }

            $ateliers_tpn = Atelier_tpn::where('tpn_id', $tpn->id)->get();
            foreach ($ateliers_tpn as $atelier_tpn) {

                $exercices = Exercice::where('atelier_tpn_id', $atelier_tpn->id)->get();
                foreach ($exercices as $exercice) {

                    $exercice_users = Exercice_user::where('exercice_id', $exercice->id)->get();
                    foreach ($exercice_users as $exercice_user) {
                        $exercice_user->delete();
                    }

                    $questions = Question::where('exercice_id', $exercice->id)->get();
                    foreach ($questions as $question) {

                        $reponses = Reponse::where('question_id', $question->id)->get();
                        foreach ($reponses as $reponse) {
                            $reponse->delete();
                        }

                        $reponse_users = Reponse_user::where('question_id', $question->id)->get();
                        foreach ($reponse_users as $reponse_user) {
                            $reponse_user->delete();
                        }

                        $question->delete();
                    }

                    $exercice->delete();
                }

                $atelier_tpn->delete();
            }

            $tpn->delete();
        }

        $ateliers = Atelier::where('site_id', $id)->get();
        foreach ($ateliers as $atelier) {
            $atelier->delete();
        }

        if (file_exists(public_path() . $site->photo)) {
            unlink(public_path() . $site->photo);
        }
        if (file_exists(public_path() . $site->img_mini_map)) {
            unlink(public_path() . $site->img_mini_map);
        }
        if (file_exists(public_path() . $site->img_sentier)) {
            unlink(public_path() . $site->img_sentier);
        }
        if (count(explode('sound:', $site->sound)) >= 2) {
            $sounds = json_decode(explode(', range', explode('sound:', $site->sound)[1])[0], TRUE, 512, JSON_THROW_ON_ERROR);
            foreach ($sounds as $sound) {
                if (file_exists(public_path() . DIRECTORY_SEPARATOR . 'final' . DIRECTORY_SEPARATOR . $sound)) {
                    unlink(public_path() . DIRECTORY_SEPARATOR . 'final' . DIRECTORY_SEPARATOR . $sound);
                }
            }
        }

        Common::instance()->deleteDirectory(public_path() . $site->dossier);

        $site->delete();

        return redirect()->route('admin::site::edit');
    }

    public function setEtapeActiveSite(Request $request) {

        $active = Input::get('active');
        if (Session::has('etapeActiveSite')) {
            Session::forget('etapeActiveSite');
            Session::put('etapeActiveSite', $active);
        } else {
            Session::put('etapeActiveSite', $active);
        }
        Session::save();
        return Response::json(['msg' => Session::get('etapeActiveSite')]);
    }

    public function reset_session() {
        if (Session::has('siteChoisi')) {
            Session::forget('siteChoisi');
        }

        if (Session::has('etatBrouillon')) {
            Session::forget('etatBrouillon');
        }

        if (Session::has('etapeActive')) {
            Session::forget('etapeActive');
        }

        if (Session::has('selectionCheckboxesAteliers')) {
            Session::forget('selectionCheckboxesAteliers');
        }

        if (Session::has('listeAtelierAmodifier')) {
            Session::forget('listeAtelierAmodifier');
        }

        if (Session::has('nbexercicesParType')) {
            Session::forget('nbexercicesParType');
        }

        if (Session::has('nbexercicesTotal')) {
            Session::forget('nbexercicesTotal');
        }

        if (Session::has('selectionCheckboxesgroupes')) {
            Session::forget('selectionCheckboxesgroupes');
        }

        if (Session::has('siteChoisiImage')) {
            Session::forget('siteChoisiImage');
        }
    }

    public function setIntroSessionSite() {
        if (Session::has('rubrique')) {
            Session::forget('rubrique');
            Session::put('rubrique', 'site');
        } else {
            Session::put('rubrique', 'site');
        }

        if (Session::has('sitessrub')) {
            Session::forget('sitessrub');
            Session::put('sitessrub', 'nouveau');

            if (Session::has('etapeActiveSite')) {
                Session::forget('etapeActiveSite');
                Session::put('etapeActiveSite', 'fieldsiteintro');
            } else {
                Session::put('etapeActiveSite', 'fieldsiteintro');
            }
        } else {
            Session::put('sitessrub', 'nouveau');
            if (Session::has('etapeActiveSite')) {
                Session::forget('etapeActiveSite');
                Session::put('etapeActiveSite', 'fieldsiteintro');
            } else {
                Session::put('etapeActiveSite', 'fieldsiteintro');
            }
        }
    }

    public function visu($site_id) {
        $site = Site::getShortInfosFromSiteId($site_id)[0];
        return view('admin.sites.visualisation', ['site' => $site]);
    }

    public function editSommaire($id) {
        $site = Site::find($id);
        return view('admin.sites.editSommaire', ['site' => $site, 'alert' => FALSE]);
    }

    public function updateSommaire(Request $request, $id) {

        $rules = ['nom_site' => 'min:3|Regex:/^[A-Za-z-éèàùêç\'\s]{3,}$/', 'photo_site' => 'file|image', 'video_sommaire' => 'file|max:204800', 'carte_sommaire' => 'file|image', 'sentier_sommaire' => 'file|image', 'map-latmin' => 'numeric|min:-90.0|max:90.0|required_if:type-carte,dynamic|lt:map-latmax', 'map-latmax' => 'numeric|min:-90.0|max:90.0|required_if:type-carte,dynamic|gt:map-latmin', 'map-lonmin' => 'numeric|min:-180.0|max:180.0|required_if:type-carte,dynamic|lt:map-lonmax', 'map-lonmax' => 'numeric|min:-180.0|max:180.0|required_if:type-carte,dynamic|gt:map-lonmin', 'audio-out-min' => 'array', 'audio-out-min.*' => 'numeric|min:-0.1|max:1.1', 'audio-in-min' => 'array', 'audio-in-min.*' => 'numeric|min:-0.1|max:1.1', 'audio-in-max' => 'array', 'audio-in-max.*' => 'numeric|min:-0.1|max:1.1', 'audio-out-max' => 'array', 'audio-out-max.*' => 'numeric|min:-0.1|max:1.1', 'audio-files' => 'array', 'audio-files.*' => 'file|mimes:mp3'];

        $this->validate($request, $rules);

        $alert = FALSE;

        $site = Site::find($id);
        $base_path = public_path() . $site->dossier;

        if ($request->hasFile('photo_site')) {
            unlink(public_path() . $site->photo);
            if ($request->file('photo_site')->isValid()) {
                do {
                    if ($request->file('photo_site')->move($base_path, filter_var($request->file('photo_site')->getClientOriginalName(), FILTER_SANITIZE_STRING))) {
                        break;
                    }
                } while (true);
            }
            $site->photo = $site->dossier . DIRECTORY_SEPARATOR . filter_var($request->file('photo_site')->getClientOriginalName(), FILTER_SANITIZE_STRING);
        }

        if ($request->hasFile('video_sommaire')) {
            $alert = TRUE;
            unlink(public_path() . $site->video);
            if ($request->file('video_sommaire')->isValid()) {
                do {
                    if ($request->file('video_sommaire')->move($base_path, filter_var($request->file('video_sommaire')->getClientOriginalName(), FILTER_SANITIZE_STRING))) {
                        break;
                    }
                } while (true);
            }
            $site->video = $site->dossier . DIRECTORY_SEPARATOR . filter_var($request->file('video_sommaire')->getClientOriginalName(), FILTER_SANITIZE_STRING);
        }

        if ($request->input('type-carte') === 'fixe') {
            if ($request->hasFile('carte_sommaire')) {
                unlink(public_path() . $site->img_mini_map);
                if ($request->file('carte_sommaire')->isValid()) {
                    do {
                        if ($request->file('carte_sommaire')->move($base_path, filter_var($request->file('carte_sommaire')->getClientOriginalName(), FILTER_SANITIZE_STRING))) {
                            break;
                        }
                    } while (true);
                }
                $site->img_mini_map = $site->dossier . DIRECTORY_SEPARATOR . filter_var($request->file('carte_sommaire')->getClientOriginalName(), FILTER_SANITIZE_STRING);
            }
            if ($request->hasFile('sentier_sommaire')) {
                unlink(public_path() . $site->img_sentier);
                if ($request->file('sentier_sommaire')->isValid()) {
                    do {
                        if ($request->file('sentier_sommaire')->move($base_path, filter_var($request->file('sentier_sommaire')->getClientOriginalName(), FILTER_SANITIZE_STRING))) {
                            break;
                        }
                    } while (true);
                }
                $site->img_sentier = $site->dossier . DIRECTORY_SEPARATOR . filter_var($request->file('sentier_sommaire')->getClientOriginalName(), FILTER_SANITIZE_STRING);
            }
        }

        $site->sig_map = $request->get('type-carte') === 'dynamic';
        $site->latmin = $request->get('type-carte') === 'dynamic' ? floatval($request->get('map-latmin')) : NULL;
        $site->latmax = $request->get('type-carte') === 'dynamic' ? floatval($request->get('map-latmax')) : NULL;
        $site->lonmin = $request->get('type-carte') === 'dynamic' ? floatval($request->get('map-lonmin')) : NULL;
        $site->lonmax = $request->get('type-carte') === 'dynamic' ? floatval($request->get('map-lonmax')) : NULL;

        $sounds = [];

        foreach (json_decode($site->sound, TRUE, 512, JSON_THROW_ON_ERROR) as $key => $snd) {
            if ($request->hasFile('old-audio-files-' . $key)) {
                unlink(public_path() . DIRECTORY_SEPARATOR . 'final' . DIRECTORY_SEPARATOR . $snd['sound'][0]);
                if ($request->file('old-audio-files-' . $key)->isValid()) {
                    do {
                        if ($request->file('old-audio-files-' . $key)->move($base_path . DIRECTORY_SEPARATOR . 'snd',
                                        filter_var($request->file('old-audio-files-' . $key)->getClientOriginalName(), FILTER_SANITIZE_STRING))) {
                            break;
                        }
                    } while (true);
                }

                $snd['sound'] = [str_replace('/final', '', $site->dossier) . DIRECTORY_SEPARATOR . 'snd' . DIRECTORY_SEPARATOR . filter_var($request->file('old-audio-files-' . $key)->getClientOriginalName(), FILTER_SANITIZE_STRING)];
            }

            $snd['range'] = [floatval($request->get('old-audio-out-min-' . $key)), floatval($request->get('old-audio-in-min-' . $key)), floatval($request->get('old-audio-in-max-' . $key)), floatval($request->get('old-audio-out-max-' . $key))];

            array_push($sounds, $snd);
        }

        if ($request->file('audio-files')) {
            if ((is_countable($request->file('audio-files')) ? count($request->file('audio-files')) : 0) > 0) {

                foreach ($request->file('audio-files') as $key => $sound) {

                    $tmp = [];

                    if (is_null($sound)) {
                        continue;
                    }

                    # Creation du dossier pour les sons 
                    if (!file_exists($base_path . DIRECTORY_SEPARATOR . 'snd')) {
                        $old_mask = umask(0);
                        mkdir($base_path . DIRECTORY_SEPARATOR . 'snd', 0777);
                        umask($old_mask);
                    }

                    # Stockage du son sur le serveur
                    if ($sound->isValid()) {
                        do {
                            if ($sound->move($base_path . DIRECTORY_SEPARATOR . 'snd', filter_var($sound->getClientOriginalName(), FILTER_SANITIZE_STRING))) {
                                break;
                            }
                        } while (TRUE);
                    }

                    $tmp['sound'] = [str_replace('/final/', '', $site->dossier) . DIRECTORY_SEPARATOR . 'snd' . DIRECTORY_SEPARATOR . filter_var($sound->getClientOriginalName(), FILTER_SANITIZE_STRING)];
                    $tmp['range'] = [floatval($request->get('audio-out-min')[$key]), floatval($request->get('audio-in-min')[$key]), floatval($request->get('audio-in-max')[$key]), floatval($request->get('audio-out-max')[$key])];

                    array_push($sounds, $tmp);
                }
            }
        }

        $site->sound = json_encode($sounds, JSON_THROW_ON_ERROR);

        $site->save();

        return view('admin.sites.editSommaire', ['site' => $site, 'alert' => $alert]);
    }

    public function removeSound($site_id, $sound_id) {
        $site = Site::findOrFail($site_id);
        $sounds = json_decode($site->sound, TRUE, 512, JSON_THROW_ON_ERROR);

        $base_path = public_path() . DIRECTORY_SEPARATOR . 'final' . DIRECTORY_SEPARATOR;

        $sound = $sounds[$sound_id];
        if (file_exists($base_path . $sound['sound'][0])) {
            unlink($base_path . $sound['sound'][0]);
        }
        array_splice($sounds, $sound_id, 1);
        $site->sound = json_encode($sounds, JSON_THROW_ON_ERROR);
        $site->save();

        return Response::json();
    }

}

?>