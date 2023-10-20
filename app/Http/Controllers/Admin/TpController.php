<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tpn;
use App\Models\Site;
use App\Models\Atelier;
use App\Models\Atelier_tpn;
use App\Models\Classe_tpn;
use App\Models\Exercice;
use App\Models\Exercice_user;
use App\Models\Classe;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Session;
use App\Http\Controllers\Controller;
use Response;
use Auth;
use View;
use URL;
use Mail;
use Illuminate\Support\Facades\Input;
use MyfileClass;
use Illuminate\Http\Request;

class TpController extends Controller {

    protected $checkboxes_selection;
    protected $titre;
    protected $descr;
    protected $etat;
    protected $site_id;
    protected $etat_actuel;
    protected $liste_atelier;
    protected $liste_titres_ateliers;
    protected $liste_descr_ateliers;
    protected $intro_tp;

    public function upload_par_dossier_pour_exercice($num, $id) {
        ini_set('max_execution_time', 0);
        $contenu = '		<h1 class="etapes-titre">MES FICHIERS (' . (is_countable(MyfileClass::list_file(Auth::user()->userable_id)) ? count(MyfileClass::list_file(Auth::user()->userable_id)) : 0) . ')</h1>';
        if ((is_countable(MyfileClass::list_file(Auth::user()->userable_id)) ? count(MyfileClass::list_file(Auth::user()->userable_id)) : 0) != 0) {

            $contenu .= '<table class="etudiant">
							<tr>
  
								 <th></th>
								<th>NOM								
								</th>		
								<th>DATE DE TELECHARGEMENT
								</th>
								<th>TYPE
								</th>
								<th>TAILLE
								</th>
							</tr>';
            foreach (MyfileClass::list_file(Auth::user()->userable_id) as $fichier) {
                $contenu .= '<tr><td>';
                if (substr($fichier['type'], 0, 5) == 'image') {
                    [$width, $height] = getimagesize($fichier["file"]);
                    $ratio = $width / $height;
                    if ($width > 600) {
                        $width = 600;
                        $height = 600 / $ratio;
                    }
                    if ($height > 500) {
                        $height = 500;
                        $width = 500 * $ratio;
                    }


                    $contenu .= "<a href='#mydiv_exercice_" . $num . "_atelier_" . $id . "_" . $fichier['timestamp'] . "' class='photo' data-width=" . $width . " data-height=" . $height . "><img src='" . url('/') . "/img/uploads/" . $fichier["thumbnail"] . "'/></a>";
                } else {
                    $contenu .= "<a href='#mydiv_exercice_" . $num . "_atelier_" . $id . "_" . $fichier['timestamp'] . "' class='photo' data-width=600 data-height=450><img src='" . url('/') . "/img/play.png'/></a>";
                }
                $contenu .= '<div id="mydiv_exercice_' . $num . '_atelier_' . $id . '_' . $fichier['timestamp'] . '" style="display:none"><div id="media_exercice_' . $num . '_atelier_' . $id . '"> ';
                if (substr($fichier['type'], 0, 5) == 'image') {
                    $contenu .= "<img src='" . url('/') . '/' . $fichier["file"] . "'/>";
                } else {
                    $contenu .= '<video width="600" height="450" controls><source src="' . url('/') . '/' . $fichier["file"] . '" type="' . $fichier['type'] . '"></video>';
                }
                $contenu .= '</div> <div style="clear:both;"></div>
                                          </div></div>
                        </td>
                        <td>
                        ' . $fichier['nom'] . '
                        </td>
                        <td>' . $fichier['date'] . '</td>
                        <td>' . $fichier['type'] . '</td>
                        <td>' . $fichier['sizeh'] . '</td>
                        </tr>';
            }


            $contenu .= ' </table>';
        }
        return Response::json(['contenu' => $contenu]);
    }

    public function upload_par_dossier() {
        ini_set('max_execution_time', 0);
        $contenu = '<h1 class="etapes-titre">MES FICHIERS (' . (is_countable(MyfileClass::list_file(Auth::user()->userable_id)) ? count(MyfileClass::list_file(Auth::user()->userable_id)) : 0) . ')</h1>';
        if ((is_countable(MyfileClass::list_file(Auth::user()->userable_id)) ? count(MyfileClass::list_file(Auth::user()->userable_id)) : 0) != 0) {
            $contenu .= '<table class="etudiant">
<tr>
    <th>NOM</th>		
    <th>DATE DE TELECHARGEMENT</th>
    <th>TYPE</th>
    <th>TAILLE</th>
</tr>';
            foreach (MyfileClass::list_file(Auth::user()->userable_id) as $fichier) {
                $contenu .= '<tr><td>';
                if (substr($fichier['type'], 0, 5) == 'image') {
                    [$width, $height] = getimagesize($fichier["file"]);
                    $ratio = $width / $height;
                    if ($width > 600) {
                        $width = 600;
                        $height = 600 / $ratio;
                    }
                    if ($height > 500) {
                        $height = 500;
                        $width = 500 * $ratio;
                    }        
                    $contenu .= "<a href='#mydiv" . $fichier['timestamp'] . "' class='photo' data-width=" . $width . " data-height=" . $height . "><img src='" . url('/') . "/img/uploads/" . $fichier["thumbnail"] . "'/></a>";
                } else {
                    $contenu .= "<a href='#mydiv" . $fichier['timestamp'] . "' class='photo' data-width=600 data-height=450><img src='" . url('/') . "/img/play.png'/></a>";
                }
                $contenu .= ' <div id="mydiv' . $fichier['timestamp'] . '" style="display:none"><div id="media"> ';
                if (substr($fichier['type'], 0, 5) == 'image') {
                    $contenu .= "<img src='" . url('/') . '/' . $fichier["file"] . "'/>";
                } else {
                    $contenu .= '<video width="600" height="450" controls><source src="' . url('/') . '/' . $fichier["file"] . '" type="' . $fichier['type'] . '"></video>';
                }
                $contenu .= '</div>
                    <div style="clear:both;">
                </div>
            </div>
        </div>
    </td>
    <td>' . $fichier['nom'] . '</td>
    <td>' . $fichier['date'] . '</td>
    <td>' . $fichier['type'] . '</td>
    <td>' . $fichier['sizeh'] . '</td>
</tr>';
            }
            $contenu .= ' </table>';
        }
        return Response::json(['contenu' => $contenu]);
    }

    public function nouveau() {
        $this->reset_session();
        $this->setIntroSession();

        if (Session::has('enmodification')) {
            Session::forget('enmodification');
        }

        $sites = Site::all();

        if (Session::has('siteChoisi')) {
            $id_session_site = Session::get('siteChoisi');
            $sites_session = Site::where('id', '=', $id_session_site)->get();
            foreach ($sites_session as $site) {
                $nom_site = ucfirst($site->titre);
            }
        } else {
            $id_session_site = "";
            $nom_site = "";
        }

        if (Session::has('etatBrouillon')) {
            $etat_actuel = Session::get('etatBrouillon');
        } else {
            $etat_actuel = "false";
        }

        if (Auth::user()->userable->classes()->count() > 0) {
            $groupes = Auth::user()->userable->classes()->orderBy('id', 'DESC')->get();
        } else {
            $groupes = [];
        }

        $now = Carbon::now('Europe/Paris');

        $titre_tp = "";
        $descr_tp = "";
        $intro_tp = "";
        $etat = "";
        $total_exercices = "";


        return view('admin.tpnouveau', ['groupes_selectionnes' => '', 'total_exercices' => $total_exercices, 'date_creation' => $now, 'intro_tp' => $intro_tp, 'groupes' => $groupes, 'etat' => $etat, 'titre_tp' => $titre_tp, 'descr_tp' => $descr_tp, 'etat_actuel' => $etat_actuel, 'insereId' => "", 'sites' => $sites, 'id_session_site' => $id_session_site, 'nom_site' => $nom_site]);
    }

    public function site($id) {
        return view('admin.final')->withSite(Site::find($id));
    }

    public function show360($id, $tpn) {
        $atelier = Atelier::find($id);
        $lien = [];
        $lien = explode('/', $atelier->lien_360);
        $end = end($lien);
        array_pop($lien);
        $url = implode('/', $lien);        

//        return view($end)->withUrl(URL::asset($atelier->site->dossier . '/' . end($lien)))->withAtelier($atelier)->withId($tpn);
        return view('admin.pannellum')->withUrl(url('/') . $url)->withAtelier($atelier)->withId($tpn);
    }

    public function gerer() {
        if (Session::has('rubrique')) {
            Session::forget('rubrique');
            Session::put('rubrique', 'gestion');
        } else {
            Session::put('rubrique', 'gestion');
        }

        if (Session::has('tpssrub')) {
            Session::forget('tpssrub');
            Session::put('tpssrub', 'gerer');
        } else {
            Session::put('tpssrub', 'gerer');
        }

        $this->reset_session();

        $tpns = Tpn::where('professeur_id', '=', Auth::user()->userable_id)->orderBy('id', 'desc')->get();
        $tp_sites = [];
        $nbexercices = [];
        $nbre_exercice = 0;
        $nbre_ateliers = [];
        $nbr_ex = [];
        //$nbexercices = "";
        if ($tpns->count() > 0) {
            foreach ($tpns as $tp) {
                $tp_sites[] = $tp->site_id;

                /* $nbexercices[$tp->site_id] = Atelier_tpn::where('tpn_id', '=', $tp->id)->get(); */
                $ateliers = Atelier::where('site_id', '=', $tp->site_id)->get();
                foreach ($ateliers as $at) {
                    $ateliers_tpn = Atelier_tpn::where('tpn_id', '=', $tp->id)->where('atelier_id', '=', $at->id)->get();
                    foreach ($ateliers_tpn as $at_tpn) {
                        if (isset($nbre_ateliers[$tp->id])) {
                            if (!in_array($at_tpn->atelier_id, $nbre_ateliers[$tp->id])) {
                                $nbre_ateliers[$tp->id][] = $at_tpn->atelier_id;
                            }
                        }

                        //COMPTER LES EXERCICES
                        $exercice_tpn = Exercice::where('atelier_tpn_id', '=', $at_tpn->id)->get();

                        foreach ($exercice_tpn as $exercice) {
                            $nbr_ex[$tp->id][] = $exercice->id;
                        }
                        $nbre_exercice += $at_tpn->exercices()->count();
                    }
                }
                $nbexercices[$tp->id] = $nbre_exercice;
            }

            $sites = Site::whereIn('id', $tp_sites)->get();
            $infos_sites = [];
            if ((is_countable($tpns) ? count($tpns) : 0) > 0) {
                foreach ($tpns as $tps) {
                    foreach ($sites as $site) {
                        if ($tps->site_id == $site->id) {
                            $infos_sites[$tps->id][$tps->site_id] = $site;
                        }
                    }
                }
            }
        } else {
            $infos_sites = [];
        }
        $nbtpns = Auth::user()->userable->tpns()->count();
        $liste_atelier = $this->checkboxes_selection;

        return view('admin.gerer', ['total_ateliers' => $nbre_ateliers, 
            'total_exercice' => $nbr_ex, 
            'liste' => $liste_atelier, 
            'tpns' => $tpns, 
            'compte' => $nbtpns, 
            'infos_sites' => $infos_sites, 
            'save' => 'rien']);
    }

    public function suppression($id) {

        $tp = Tpn::find($id);

        $classes = Classe_tpn::where('tpn_id', $id)->get();
        foreach ($classes as $classe) {
            $classe->delete();
        }
        $ateliers = Atelier_tpn::where('tpn_id', $id)->get();
        foreach ($ateliers as $atelier) {
            $exercices = Exercice::where('atelier_tpn_id', $atelier->id)->get();


            foreach ($exercices as $exercice) {
                $exercices_user = Exercice_user::where('exercice_id', $exercice->id)->get();
                foreach ($exercices_user as $user_exercices) {
                    $user_exercices->delete();
                }
                $exercice->delete();
            }


            $atelier->delete();
        }

        $tp->delete();

        return redirect()->route('gerertp');
    }

    public function setEtapeActive(Request $request) {
        $active = $request->get('active');
        if (Session::has('etapeActive')) {
            Session::forget('etapeActive');
            Session::put('etapeActive', $active);
        } else {
            Session::put('etapeActive', $active);
        }
        Session::save();
        return Response::json(['msg' => Session::get('etapeActive')]);
    }

    protected function envoyeremail($user, $tpn) {
        Mail::send('admin.emails.alertenouveautpn', ['user' => $user, 'tpn' => $tpn], function ($m) use ($user) {
            $m->from('geovisit@uca.fr', 'Géovisit');

            $m->to($user->email, $user->prenom)->subject('Et un nouveau TPN !');
        });
    }

    public function brouillon($id, $change, Request $request) {
        ini_set('max_execution_time', 0);
        
        $id_exercices = [];
        $now = Carbon::now('Europe/Paris');
        $arraymatch = ['id_site' => 'site_id', 'titre_tp' => 'titre_tpns', 'descr_tp' => 'description_tpn', 'intro_tp' => 'contenu', 'intro_tp_contenu_admin' => 'contenu_admin'];
        $achanger = explode("+", $change);
        $id_ateliers_tpn = [];

        // Création d'un nouveau tp ou récupération d'un brouillon existant
        if ($id == 0) {
            $tpn = new Tpn;
            $tpn->professeur_id = Auth::user()->userable_id;
            $tpn->publie = '0';
            $tpn->created_at = $now;
            $tpn->updated_at = $now;
        } else {
            $tpn = Tpn::find($id);
            $tpn->updated_at = $now;
        }
        
        if (!in_array("numero_exercice", $achanger)) {
            foreach ($achanger as $nom_input) {	
                if ($nom_input == 'selection_atelier' || $nom_input == 'titres_ateliers' || $nom_input == 'description_ateliers') {
                    continue;
                }
                if ($nom_input == 'intro_tp') {
                    $tpn->{$arraymatch[$nom_input]} = $this->formate_contenu($request->get($nom_input), "intro");
                } else {
                    $tpn->{$arraymatch[$nom_input]} = $request->get($nom_input);
                }
            }
        }
        
        if ($id == 0 || !in_array("selection_atelier", $achanger)) {
            $tpn->save();
        }
        
        if ($id == 0) {
            if (Session::has('id_brouillon')) {
                Session::forget('id_brouillon');
                Session::put('id_brouillon', $tpn->id);
            } else {
                Session::put('id_brouillon', $tpn->id);
            }
        }
        
        if (in_array("selection_atelier", $achanger)) {
            
            //brouillon d'exercices
            if (in_array("numero_exercice", $achanger)) {
                //CREATION D'EXERCICE
                $ateliers = $request->get('selection_atelier');
                foreach ($ateliers as $key => $atelier) {
                    foreach ($atelier as $exercice) {//return Response::json(['id'=>$atelier['type_exercice'],'key'=>$key	]);
                        if (array_key_exists('type_exercice', $exercice)) {
                            $type = $exercice['type_exercice'];
                            $idex = $exercice['id_exercice'];
                            $contenu = $exercice['contenu_exercice'];
                            $coordonnees = $exercice['coord'];
                            $contenu_admin = $exercice['contenu_admin_exercice'];

                            if (isset($coordonnees)) {
                                $coords = explode(",", $coordonnees);
                                if (isset($coords[0])) {
                                    $coord_x = $coords[0];
                                } else {
                                    $coord_x = "0";
                                }
                                if (isset($coords[1])) {
                                    $coord_y = $coords[1];
                                } else {
                                    $coord_y = "0";
                                }
                            } else {
                                $coord_x = "0";
                                $coord_y = "0";
                            }
                            $retour = $this->ajout_exercice($type, $key, $contenu, $contenu_admin, $coord_x, $coord_y, $idex);
                            $id_exercices[$exercice['id_exercice_retour']] = ($retour);
                        }
                    }
                }
            } else {
                //CREATION D'UN NOUVEL ATELIER-TPN POUR CHAQUE ATELIER SELECTIONNE
                $ateliers = Atelier::whereIn('id', $request->get('selection_atelier'))->get();
                foreach ($ateliers as $atelier) {
                    $nouveau = false;
                    $atelier_tpn = Atelier_tpn::firstOrNew(['tpn_id' => $tpn->id, 'atelier_id' => $atelier->id]);
                    if (!$atelier_tpn->exists) {
                        $atelier_tpn->tpn_id = $tpn->id;
                        $atelier_tpn->atelier_id = $atelier->id;
                        $nouveau = true;
                    }
                    $liste_titres_ateliers = $request->get('titres_ateliers');
                    $liste_descr_ateliers = $request->get('description_ateliers');
                    $atelier_tpn->description_atelier = $liste_descr_ateliers[$atelier->id];
                    $atelier_tpn->titre_atelier = $liste_titres_ateliers[$atelier->id];
                    $atelier_tpn->save();
                    if ($nouveau) {
                        $id_ateliers_tpn[$atelier->id] = $atelier_tpn->id;
                    }
                }
            }
        }
        
        return Response::json(['id' => $tpn->id, 'id_ateliers_tpn' => $id_ateliers_tpn, 'id_exercices' => $id_exercices]);
    }

    public function creernouveau(Request $request) {
        $etat = $request->get('etat');
        $liste_groupes = Session::get('selectionCheckboxesgroupes');	
        $now = Carbon::now('Europe/Paris');
        $num = [];
        
        if ($etat == "asubmit") {
            $tpn = Tpn::find($request->get('id_brouillon2'));
            $tpn->updated_at = $now;	
            $tpn->publie = '1';
            $tpn->save();
            
            if ($liste_groupes != null) {
                ini_set('max_execution_time', 0);
                $classes = Classe_tpn::whereTpn_id($tpn->id)->get(['classe_id']);
                foreach ($classes as $c) {
                    if (!in_array($c->classe_id, $liste_groupes)) {
                        $tpn->classes()->detach($c->classe_id);
                    }
                }
                    
                foreach ($liste_groupes as $groupe) {
                    $classe = Classe_tpn::whereClasse_id(intval($groupe))->whereTpn_id($tpn->id)->count();
                    if ($classe > 0) {
                        $tpn->classes()->detach($groupe);
                        $tpn->classes()->attach($groupe);
                    }  else {
                        $tpn->classes()->attach($groupe);
                        foreach (Classe::find($groupe)->etudiants()->get() as $etudiant) {
                            foreach ($etudiant->user()->get() as $etudiantdetail) {
                                $this->envoyeremail($etudiantdetail, $tpn);
                            }
                        }
                    }
                }
            } else {
                $tpn->classes()->detach();
            }        

            $this->reset_session();

            $total_exercice = ['numeros_exercices' => $num];
            
            return redirect()->route('gerertp')->withTotal_exercice($num);
        } else if ($etat == "asubmitplustard") {
            $tpn = Tpn::find($request->get('id_brouillon2'));
            $tpn->updated_at = $now;	
            $tpn->publie = '0';
            $tpn->save();
            
            if ($liste_groupes != null) {
                ini_set('max_execution_time', 0);
                $classes = Classe_tpn::whereTpn_id($tpn->id)->get(['classe_id']);
                foreach ($classes as $c) {
                    if (!in_array($c->classe_id, $liste_groupes)) {
                        $tpn->classes()->detach($c->classe_id);
                    }
                }
                
                foreach ($liste_groupes as $groupe) {
                    $classe = Classe_tpn::whereClasse_id(intval($groupe))->whereTpn_id($tpn->id)->count();
                    if ($classe > 0) {
                        $tpn->classes()->detach($groupe);
                    }
                    $tpn->classes()->attach($groupe);
                }
            } else {
                $tpn->classes()->detach();
            }

            $this->reset_session();
            $total_exercice = ['numeros_exercices' => $num];
            return redirect()->route('gerertp')->withTotal_exercice($num);
        }
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
        
        if (Session::has('gardeAteliersInputs')) {
            Session::forget('gardeAteliersInputs');
        }
    }

    public function ajout_exercice($type, $insereIdAteliertpn, $contenu_exercices, $contenu_admin, $coord_x, $coord_y, $idexercice) {
        $contenu_exercices_formate = $this->formate_contenu($contenu_exercices, "exercice");

        $now = Carbon::now('Europe/Paris');

        //id 	created_at 	updated_at 	point 	type 	atelier_tpn_id 	contenu
        if ($idexercice == "0")
            $exercice_tpn = new Exercice;
        else
            $exercice_tpn = Exercice::find($idexercice);
        if ($exercice_tpn !== null || !$exercice_tpn->exists) {
            $exercice_tpn->created_at = $now;
            $exercice_tpn->type = $type;
            $exercice_tpn->atelier_tpn_id = $insereIdAteliertpn;
        }
        $exercice_tpn->updated_at = $now;

        $exercice_tpn->x = $coord_x;
        $exercice_tpn->y = $coord_y;

        $exercice_tpn->contenu = $contenu_exercices_formate;
        $exercice_tpn->contenu_admin = $contenu_admin;

        $exercice_tpn->save();

        return $exercice_tpn->id;
    }

    public function formate_contenu($contenu, $depuis) {

        $suffixe = "";
        if ($depuis == "exercice") {
            $suffixe = "_exercice";
        } else if ($depuis == "intro") {
            $suffixe = "_sommaire";
        }

        $temp = $contenu;
        //ENLEVER erasemove
        if ($temp != "") {

            if (strpos($temp, "input_titre" . $suffixe . " sortable") !== false) {
                $pattern = "input_titre" . $suffixe . " sortable";

                $temp = str_replace($pattern, "oc_titre", $temp);
            }
            if (strpos($temp, "input_soustitre" . $suffixe . " sortable") !== false) {
                $pattern = "input_soustitre" . $suffixe . " sortable";
                $temp = str_replace($pattern, "oc_soustitre", $temp);
            }
            if (strpos($temp, "input_texte" . $suffixe . " sortable") !== false) {

                $pattern = "input_texte" . $suffixe . " sortable";
                $temp = str_replace($pattern, "oc_texte", $temp);
            }
            $temp = str_replace("border: dashed green", "border:none", $temp);
            $temp = str_replace("border: dashed #f96332", "border:none", $temp);
            $temp = str_replace("border: dashed blue", "border:none", $temp);
            $temp = str_replace("border: dashed black", "border:none", $temp);
            $temp = str_replace("border: dashed yellow", "border:none", $temp);
            $temp = str_replace(['\n', '\r', CHR(10), CHR(13), PHP_EOL], "", $temp);
            $patterns = ['style="width:90%; border:none; margin-left:auto; margin-right:auto; text-align:center;" align="middle"', 'contentEditable="true"', 'class="sortable"'];
            preg_replace('~<span id="liensinputs_([^\"]+)" class="erasemove" style="display:none"><div class="moveicon"></div><br><a href="#" id="liensup_([^\"]+)" onclick="javascript:supprContainer(\'([^)]+)\', \'#liensinputs_([^)]+)\'); return false;"><div class="suppricon"></div></a></span>~i', "", $temp);

            return $temp;
        } else {
            return "";
        }
    }
    
    public function choixgroupes(Request $request) {
        $liste_id = $request->get('choix');


        $groupes = Classe::whereIn('id', $liste_id)->get();

        if (Session::has('selectionCheckboxesgroupes')) {
            Session::forget('selectionCheckboxesgroupes');
            Session::put('selectionCheckboxesgroupes', $liste_id);
        } else {

            Session::put('selectionCheckboxesgroupes', $liste_id);
        }

        $vue = View::make('admin.bloc_groupes', ['liste_groupe' => $liste_id, 'groupes' => $groupes])->render();
        //$creaGroupe_vue = View::make('admin.groupes.bloc-groupe', ['groupes'=>$groupes, 'groupe_noms'=>$groupe_noms])->render();
        return Response::json(['msg' => 'ok', 'maquettes' => $vue, 'nbre' => is_countable(Session::get('selectionCheckboxesgroupes')) ? count(Session::get('selectionCheckboxesgroupes')) : 0 /* , 'crea_groupe'=> $creaGroupe_vue */]);
    }

    public function bloc_atelier(Request $request) {

        $id_atelier_choisi = $request->get('id_atelier_choisi');
        if ($request->get('etat') == 'noncoche') {

            if (!empty($request->get('id_atelier_tpn'))) {
                $exercices = Exercice::where('atelier_tpn_id', $request->get('id_atelier_tpn'));
                foreach ($exercices as $exercice) {
                    $exercice->users()->detach();
                }
                Exercice::where('atelier_tpn_id', $request->get('id_atelier_tpn'))->delete();
                Atelier_tpn::destroy($request->get('id_atelier_tpn'));
            }
            return Response::json(['msg' => 'ok']);
        } else {

            $atelier_nom = $request->get('atelier_nom');



            $atelier = Atelier::find($id_atelier_choisi);
            $atelier_tpn = Atelier_tpn::find($request->get('id_atelier_tpn'));



            $titre_atelier = $request->get('titres_ateliers');
            $description_atelier = $request->get('description_ateliers');
            
            $vue = View::make('admin.bloc_ateliers_ajax', ['id_atelier_choisi' => $id_atelier_choisi, 'titre_atelier' => $titre_atelier, 'description_atelier' => $description_atelier, 'atelier' => $atelier, 'atelier_nom' => $atelier_nom])->render();
            $creaAtelier_vue = View::make('admin.ateliers.bloc-atelier_ajax', ['id_atelier_choisi' => $id_atelier_choisi, 'titre_atelier' => $titre_atelier, 'description_atelier' => $description_atelier, 'atelier' => $atelier, 'atelier_nom' => $atelier_nom, 'atelier_tpn' => $atelier_tpn])->render();
            
            return Response::json(['msg' => 'ok', 'maquettes' => $vue, 'crea_atelier' => $creaAtelier_vue]);
        }
    }

    public function injecterAteliersSite(Request $request) {

        $dest = $request->get('destination');
        $nom = "";
        $image = "";
        if ($dest == "slider") {

            $id_site = $request->get('id_site');

            if (Session::has('siteChoisi')) {
                Session::forget('siteChoisi');
                Session::put('siteChoisi', $id_site);
            } else {
                Session::put('siteChoisi', $id_site);
            }

            $sites = Site::where('id', '=', $id_site)->get();
            foreach ($sites as $site) {
                $nom = ucfirst($site->titre);
                $image = $site->photo;
            }
            if (Session::has('siteChoisiImage')) {
                Session::forget('siteChoisiImage');
                Session::put('siteChoisiImage', $image);
            } else {
                Session::put('siteChoisi', $id_site);
            }

            $ateliers = Atelier::where('site_id', '=', $id_site)->get();

            $vue = View::make('admin.slider_atelier', ['ateliers' => $ateliers])->render();
            return Response::json(['msg' => 'ok', 'maquette' => $vue, 'nom_site' => $nom, 'image_site' => '/' . $image]);
        } else if ($dest == "receptacle") {
            $liste_id = $request->get('selection_atelier');

            $this->checkboxes_selection = $liste_id;


            if (Session::has('selectionCheckboxesAteliers')) {
                Session::forget('selectionCheckboxesAteliers');
                Session::put('selectionCheckboxesAteliers', $liste_id);
            } else {

                Session::put('selectionCheckboxesAteliers', $liste_id);
            }

            $id_atelier_choisi = $request->get('id_atelier_choisi');
            $atelier_noms = $request->get('atelier_nom');
            $ateliers = Atelier::whereIn('id', $liste_id)->get();

            //MEMOIRE TITRES/DESCRIPTIONS ATELIERS
            $ateliersInputs = [];

            $titre_atelier = json_decode($request->get('titres_ateliers'), null, 512, JSON_THROW_ON_ERROR);
            $description_ateliers = json_decode($request->get('description_ateliers'), null, 512, JSON_THROW_ON_ERROR);

            if ((is_countable($liste_id) ? count($liste_id) : 0) > 0) {
                foreach ($liste_id as $ids) {
                    foreach ($titre_atelier as $key => $titre) {
                        foreach ($description_ateliers as $name => $descr) {

                            if (stripos($key, (string) $ids)) {
                                $ateliersInputs['titre'][$ids] = $titre;
                            }

                            if (stripos($name, (string) $ids)) {
                                $ateliersInputs['description'][$ids] = $descr;
                            }
                        }
                    }
                }
            }


            //CREER SESSION TITRES ET DESCRIPTIONS ATELIERS
            if (Session::has('gardeAteliersInputs')) {
                Session::put('gardeAteliersInputs', $ateliersInputs);
            } else {

                Session::put('gardeAteliersInputs', $ateliersInputs);
            }

            //FIN MEMOIRE TITRES/DESCRIPTIONS ATELIERS

            $vue = View::make('admin.bloc_ateliers', ['id_atelier_choisi' => $id_atelier_choisi, 'var_ateliers_inputs' => $ateliersInputs, 'titres_ateliers' => "", 'description_ateliers' => "", 'liste_atelier' => $this->checkboxes_selection, 'ateliers' => $ateliers, 'atelier_noms' => $atelier_noms])->render();
            return Response::json(['msg' => 'ok', 'maquettes' => $vue, 'nbre' => is_countable(Session::get('selectionCheckboxesAteliers')) ? count(Session::get('selectionCheckboxesAteliers')) : 0]);
        }
    }

    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerExceptionInterface
     */
    public function injecterAteliersExercices(Request $request) {
        $nbexercicesParType = [];
        $typecree = $request->get('typecree');
        $nom_atelier = $request->get('nom_atelier');
        $idatelier = $request->get('idatelier');
        $nbCree = $request->get('nb_exercice');
        $nbdutypeexercice = $request->get('nbdutypeexercice');

        if (session()->has('nbexercicesTotal')) {
            $nbActuel = session()->get('nbexercicesTotal');
            session()->forget('nbexercicesTotal');
            session(['nbexercicesTotal' =>  $nbActuel+1]);
        } else {
            $nbActuel = 1;
            session()->put('nbexercicesTotal', $nbActuel);
        }

        if (session()->has('nbexercicesParType')) {
            $temp = session()->get('nbexercicesParType');
            if (isset($temp[$idatelier][$typecree])) {
                $nbexercicesParType[$idatelier][$typecree] = $temp[$idatelier][$typecree] + 1;
            } else {
                $nbexercicesParType = [];
                $nbexercicesParType[$idatelier][$typecree] = 1;
            }
            session()->forget('nbexercicesParType');
            session()->put('nbexercicesParType', $nbexercicesParType);
        } else {
            $nbexercicesParType = [];
            $nbexercicesParType[$idatelier][$typecree] = 1;
            session()->put('nbexercicesParType', $nbexercicesParType);
        }

        $vue = View::make('admin.ateliers.bloc-exercice', ['nbdutypeexercice' => $nbdutypeexercice, 'numero' => $nbCree, 'exercice' => $typecree, 'id' => $idatelier, 'atelier_nom' => $nom_atelier])->render();

        return new JsonResponse(['msg' => 'ok', 'maquettes' => $vue, 'nbre' => session()->get('nbexercicesTotal'), 'type'  => $typecree]);
    }

    public function efface_exercice(Request $request) {
        
        if ($request->get('id_exercice') != 0) {
            Exercice::destroy($request->get('id_exercice'));
        }

        $idatelier = $request->get('idatelier');
        $typecree = $request->get('numero_exercice');

        $temp = Session::get('nbexercicesParType');

        if (isset($temp[$idatelier][$typecree])){
            $temp[$idatelier][$typecree] -= 1;
        }
        
        if (Session::has('nbexercicesTotal')) {

            $nbActuel = Session::get('nbexercicesTotal');
            if ($nbActuel > 0) {
                Session::forget('nbexercicesTotal');
                Session::put('nbexercicesTotal', $nbActuel - 1);
            } else {
                Session::forget('nbexercicesTotal');
                Session::put('nbexercicesTotal', 0);
            }
        }
        
        Session::forget('nbexercicesParType');
        Session::put('nbexercicesParType', $temp);

        return Response::json(['msg' => 'ok', 'nbre' => Session::get('nbexercicesTotal')]);
    }

    public function setIntroSession() {
        if (Session::has('rubrique')) {
            Session::forget('rubrique');
            Session::put('rubrique', 'tp');
        } else {
            Session::put('rubrique', 'tp');
        }

        if (Session::has('tpssrub')) {
            Session::forget('tpssrub');
            Session::put('tpssrub', 'nouveau');

            if (Session::has('etapeActive')) {
                Session::forget('etapeActive');
                Session::put('etapeActive', 'fieldintro');
            } else {
                Session::put('etapeActive', 'fieldintro');
            }
        } else {
            Session::put('tpssrub', 'nouveau');
            if (Session::has('etapeActive')) {
                Session::forget('etapeActive');
                Session::put('etapeActive', 'fieldintro');
            } else {
                Session::put('etapeActive', 'fieldintro');
            }
        }
    }

    public function modifier($id) {

        $this->setIntroSession();

        $sites = Site::all();


        $tp_a_changer = Tpn::where('id', '=', $id)->first();

        //RECUP INFOS TPN CORRESPONDANT

        $id_site = $tp_a_changer->site_id;
        $titre_tp = $tp_a_changer->titre_tpns;
        $descr_tp = $tp_a_changer->description_tpn;
        $intro_tp = $tp_a_changer->contenu_admin;
        $date_creation = $tp_a_changer->created_at;


        $ateliers_selection_a_changer = [];

        //RECUP ATELIERS DU SITE ID
        $a_changer_ateliers_selection = Atelier_tpn::where('tpn_id', '=', $id)->get();


        $a_ateliers = Atelier::where('site_id', '=', $id_site)->get();
        foreach ($a_ateliers as $atelier_site) {
            $ateliers_selection_a_changer['ids'][] = $atelier_site->id;
            $ateliers_selection_a_changer['images'][$atelier_site->id] = $atelier_site->image;
            $ateliers_selection_a_changer['vmin'][$atelier_site->id] = $atelier_site->vmin;
            $ateliers_selection_a_changer['hmin'][$atelier_site->id] = $atelier_site->hmin;
            $ateliers_selection_a_changer['vmax'][$atelier_site->id] = $atelier_site->vmax;
            $ateliers_selection_a_changer['hmax'][$atelier_site->id] = $atelier_site->hmax;
        }

        //RECUP ATELIERS CHOISIS ID
        $total_exercices = 0;
        $arrayNbParType = [];
        foreach ($a_changer_ateliers_selection as $ateliers) {
            $ateliers_selection_a_changer['id_choisis'][] = $ateliers->atelier_id;
            $a_changer_ateliers_images = Atelier::find($ateliers->atelier_id);
            $ateliers_selection_a_changer['images_choisies'][] = $a_changer_ateliers_images->image;
            $ateliers_selection_a_changer['deplie_choisis'][$ateliers->atelier_id] = $a_changer_ateliers_images->image_deplie;
            $ateliers_selection_a_changer['id_tpn'][$ateliers->atelier_id] = $ateliers->id;
            $a_exercices = Exercice::where('atelier_tpn_id', '=', $ateliers->id)->get();
            $nbExerciceTexte = Exercice::where('atelier_tpn_id', '=', $ateliers->id)->where('type', '=', 'texte')->count();
            $nbExercicePhoto = Exercice::where('atelier_tpn_id', '=', $ateliers->id)->where('type', '=', 'photo')->count();
            $nbExerciceVideo = Exercice::where('atelier_tpn_id', '=', $ateliers->id)->where('type', '=', 'video')->count();
            $nbExerciceQcm = Exercice::where('atelier_tpn_id', '=', $ateliers->id)->where('type', '=', 'qcm')->count();

            $arrayNbParType[$ateliers->atelier_id]["texte"] = $nbExerciceTexte;
            $arrayNbParType[$ateliers->atelier_id]["photo"] = $nbExercicePhoto;
            $arrayNbParType[$ateliers->atelier_id]["video"] = $nbExerciceVideo;
            $arrayNbParType[$ateliers->atelier_id]["qcm"] = $nbExerciceQcm;

            $nbExercices = is_countable($a_exercices) ? count($a_exercices) : 0;
            $ateliers_selection_a_changer['nbrexercices'][$ateliers->atelier_id] = $nbExercices;
            $ateliers_selection_a_changer['exercices'][$ateliers->atelier_id] = $a_exercices;
            $total_exercices += is_countable($a_exercices) ? count($a_exercices) : 0;
        }

        $ateliers_selection_a_changer['ateliers_cree_infos'] = $a_changer_ateliers_selection;
        $ateliers_selection_a_changer['exercices_nb_types'] = $arrayNbParType;

        //GROUPES
        $a_changer_groupes_selection = $tp_a_changer->getClasses();

        //AJOUTER PAR LES GROUPES ASSIGNES
        if (Auth::user()->userable->classes()->count() > 0) {
            $groupes = Auth::user()->userable->classes()->orderBy('id', 'DESC')->get();            
        }
        
        //RECUP SITE CORRESPONDANT
        $sites_session = Site::where('id', '=', $id_site)->get();
        foreach ($sites_session as $site) {
            $nom_site = ucfirst($site->titre);
        }
        
        if (Session::has('enmodification')) {
            Session::forget('enmodification');
            Session::put('enmodification', 'oui');
            if (Session::has('listeAtelierAmodifier')) {
                Session::forget('listeAtelierAmodifier');
                Session::put('listeAtelierAmodifier', $ateliers_selection_a_changer);
            } else {
                Session::put('listeAtelierAmodifier', $ateliers_selection_a_changer);
            }

            $nbActuel = $total_exercices;

            //Session::forget('nbexercicesTotal');
            Session::put('nbexercicesTotal', $nbActuel);
            if (Session::has('etapeActive')) {
                Session::forget('etapeActive');
                Session::put('etapeActive', 'fieldintro');
            } else {
                Session::put('etapeActive', 'fieldintro');
            }
        } else {
            Session::put('enmodification', 'oui');
            if (Session::has('listeAtelierAmodifier')) {
                Session::forget('listeAtelierAmodifier');
                Session::put('listeAtelierAmodifier', $ateliers_selection_a_changer);
            } else {
                Session::put('listeAtelierAmodifier', $ateliers_selection_a_changer);
            }

            $nbActuel = $total_exercices;

            Session::put('nbexercicesTotal', $nbActuel);
            if (Session::has('etapeActive')) {
                Session::forget('etapeActive');
                Session::put('etapeActive', 'fieldintro');
            } else {
                Session::put('etapeActive', 'fieldintro');
            }
        }

        Session::forget('selectionCheckboxesAteliers');

        $string = <<<HTML
$intro_tp
HTML;
//        return view('admin.test', ['groupes' => $a_changer_groupes_selection]);
        return view('admin.tpmodifier', ['groupes_selectionnes' => $a_changer_groupes_selection, 'date_creation' => $date_creation, 'groupes' => $groupes, 'titre_tp' => $titre_tp, 'descr_tp' => $descr_tp, 'intro_tp' => $string, 'insereId' => $id, 'sites' => $sites, 'id_session_site' => $id_site, 'nom_site' => $nom_site, 'ateliers_selection_a_changer' => $ateliers_selection_a_changer, 'ateliers' => $a_ateliers, 'etat' => '']); //'intro_tp'=>$intro_tp
    }

    public function voirpano($id, $exercices_v, $exercices_h) {
        //$id = $request->get('id_atelier');
        $atelier = Atelier::find($id);
        $url = $atelier->lien_360;
        $data = ['url_pano' => $url, 'v' => $exercices_v, 'h' => $exercices_h, 'url_img_point' => ''];
        return view('admin.ateliers.voir_pano')->with($data);
    }

    public function voirsite($id) {
        return view('admin.voir_site')->with('url_site', $id);
    }
    
    public function changerpublication(Request $request) {

        $id_modifier = $request->get('id_modifier');
        $etat_publication = $request->get('etat_publication');

        $nouvel_etat = "";

        if ($etat_publication == "1") {
            $nouvel_etat = "0";
        } elseif ($etat_publication == "0") {
            $nouvel_etat = "1";
        }

        $tpn = Tpn::find($id_modifier);
        $tpn->publie = $nouvel_etat;
        $tpn->save();
        //return redirect()->route('gerertp');
        return Response::json(['msg' => 'ok']);
    }

    public function voir($id) {
        if (Session::has('rubrique')) {
            Session::forget('rubrique');
            Session::put('rubrique', 'gestion');
        } else {
            Session::put('rubrique', 'gestion');
        }

        if (Session::has('tpssrub')) {
            Session::forget('tpssrub');
            Session::put('tpssrub', 'gerer');
        } else {
            Session::put('tpssrub', 'gerer');
        }

        $this->reset_session();

        $tpns = Tpn::where('id', '=', $id)->get();
        $tp_sites = [];
        $nbexercices = [];
        $nbre_exercice = 0;
        $nbre_ateliers = [];
        
        if ($tpns->count() > 0) {
            foreach ($tpns as $tp) {
                $tp_sites[] = $tp->site_id;

                $ateliers = Atelier::where('site_id', '=', $tp->site_id)->get();
                foreach ($ateliers as $at) {
                    $ateliers_tpn = Atelier_tpn::where('tpn_id', '=', $tp->id)->where('atelier_id', '=', $at->id)->get();
                    foreach ($ateliers_tpn as $at_tpn) {
                        if (isset($nbre_ateliers[$tp->id])) {
                            if (!in_array($at_tpn->atelier_id, $nbre_ateliers[$tp->id])) {
                                $nbre_ateliers[$tp->id][] = $at_tpn->atelier_id;
                            }
                        }
                        $nbre_exercice += $at_tpn->exercices()->count();
                    }
                }

                $nbexercices[$tp->id] = $nbre_exercice;
            }




            $sites = Site::whereIn('id', $tp_sites)->get();
            $infos_sites = [];
            foreach ($tpns as $tps) {
                foreach ($sites as $site) {
                    if ($tps->site_id == $site->id) {
                        $infos_sites[$tps->id][$tps->site_id] = $site;
                    }
                }
            }
        }

        $classe_tpn = Classe_tpn::where('tpn_id', '=', $id)->get();

        $liste_id_tpn = [];

        foreach ($classe_tpn as $class) {
            $liste_id_tpn[] = $class->classe_id;
        }

        $groupes = Classe::whereIn('id', $liste_id_tpn)->get();

        $nbtpns = Auth::user()->userable->tpns()->count();
        
        $liste_atelier = $this->checkboxes_selection;
        return view('admin.gerer_voir', ['groupes' => $groupes, 'total_ateliers' => $nbre_ateliers, 'total_exercice' => $nbexercices, 'liste' => $liste_atelier, 'tpns' => $tpns, 'compte' => $nbtpns, 'infos_sites' => $infos_sites]);
    }
    
    public function modifposition(Request $request) {
        
        $exercice = Exercice::find($request->get('id_exercice'));
        $exercice->x = $request->get('posx');
        $exercice->y = $request->get('posy');
        
        if ($exercice->save()) {
            return Response::json(['saved' => TRUE]);
        } else {
            return Response::json(['saved' => FALSE]);
        }
        
    }

}
