<?php

/*
 * 
 * Observatoire de Physique du Globe de Clermont-Ferrand
 * Campus Universitaire des Cezeaux
 * 4 Avenue Blaise Pascal
 * TSA 60026 - CS 60026
 * 63178 AUBIERE CEDEX FRANCE
 * 
 * Author: Yannick Guehenneux
 *         y.guehenneux [at] opgc.fr
 * 
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\Atelier;
use App\Models\Atelier_tpn;
use App\Models\Exercice;
use App\Models\Exercice_user;
use App\Models\Question;
use App\Models\Reponse;
use App\Models\Reponse_user;
use App\Models\Site;
use App\Helpers\Common;

class AteliersController extends Controller {

    public function displayAtelierEdit($id_site) {
        $ateliers = Atelier::where('site_id', $id_site)->orderBy('id')->get();

        $selectAteliers = [];
        $selectAteliers['new'] = 'CREER UN NOUVEL ATELIER';
        $idx = 1;
        foreach ($ateliers as $atelr) {
            $selectAteliers[$atelr->id] = 'ATELIER ' . ($idx);
            $idx++;
        }
        $site = Site::find($id_site);
        return view('admin.sites.gererAtelier')->with(['atelier' => $ateliers->get(0), 'site' => $site, 'selectAteliers' => $selectAteliers]);
    }

    public function selectAtelier(Request $request, $id_site) {
        $rules = ['atelier-selected' => 'required|alpha_num'];

        $this->validate($request, $rules);

        $ateliers = Atelier::where('site_id', $id_site)->orderBy('id')->get();

        $selectAteliers = [];
        $selectAteliers['new'] = 'CREER UN NOUVEL ATELIER';
        $idx = 1;
        foreach ($ateliers as $atelr) {
            $selectAteliers[$atelr->id] = 'ATELIER ' . ($idx);
            $idx++;
        }
        $site = Site::find($id_site);

        return view('admin.sites.gererAtelier')->with(['atelier' => $request->get('atelier-selected') === 'new' ? NULL : $ateliers->find($request->get('atelier-selected')), 'site' => $site, 'selectAteliers' => $selectAteliers]);
    }

    public function getAtelier($id_site, $id_atelier) {
        $ateliers = Atelier::where('site_id', $id_site)->orderBy('id')->get();

        $selectAteliers = [];
        $selectAteliers['new'] = 'CREER UN NOUVEL ATELIER';
        $idx = 1;
        foreach ($ateliers as $atelr) {
            $selectAteliers[$atelr->id] = 'ATELIER ' . ($idx);
            $idx++;
        }
        $site = Site::find($id_site);

        return view('admin.sites.gererAtelier')->with(['atelier' => $id_atelier === 'new' ? NULL : $ateliers->find($id_atelier), 'site' => $site, 'selectAteliers' => $selectAteliers]);
    }

    public function updateAtelier(Request $request, $id_site, $id_atelier) {
        $firstRules = ['atelier_id' => 'required|numeric|exists:ateliers,id|min:' . $id_atelier . '|max:' . $id_atelier, 'site_id' => 'required|numeric|exists:sites,id|exists:ateliers,site_id|min:' . $id_site . '|max:' . $id_site];

        $this->validate($request, $firstRules);

        $site = Site::find($request->get('site_id'));
        $getID3 = new \getID3();
        $video = $getID3->analyze(public_path() . $site->video);

        $rules = ['timestamp' => 'required|numeric|min:0|max:' . $video['playtime_seconds'], 'x_sommaire' => 'required|numeric|min:0|max:100', 'y_sommaire' => 'required|numeric|min:0|max:100', 'x_carte' => 'required|numeric|minif:sig_map,0,-180.0|maxif:sig_map,100,180.0', 'y_carte' => 'required|numeric|minif:sig_map,0,-90|maxif:sig_map,100,90.0', 'image' => 'file|image', 'rayon' => 'required|numeric|min:1', 'audio' => 'file|mimes:mp3', 'lien_360' => 'file|image', 'haov' => 'required|numeric|min:0|max:360', 'vaov' => 'required|numeric|min:0|max:180', 'voffset' => 'required|numeric|min:-90|max:90'];

        $this->validate($request, $rules);
        
        $atelier = Atelier::find($request->get('atelier_id'));
        
        $shortPath = explode('/loyasite1', $atelier->lien_360)[0];
        $longPath = public_path() . $shortPath; 
        
        if (!is_null($request->file('image'))) {
            if ($request->file('image')->isValid()) {
                unlink(public_path() . $atelier->image);
                do {
                    if ($request->file('image')->move($longPath, 'vignette.' . $request->file('image')->getClientOriginalExtension())) {
                        break;
                    }
                } while(TRUE);
                $atelier->image = $shortPath . DIRECTORY_SEPARATOR . 'vignette.' . $request->file('image')->getClientOriginalExtension();
            }
        }
        
        if (!is_null($request->file('audio'))) {
            if ($request->file('audio')->isValid()) {
                unlink(public_path() . $atelier->audio);
                do {
                    if ($request->file('audio')->move($longPath, 'snd.mp3')) {
                        break;
                    }
                } while (TRUE);
                $atelier->audio = $shortPath . DIRECTORY_SEPARATOR . 'snd.mp3';
            }            
        }
        
        if (!is_null($request->file('lien_360'))) {
            if ($request->file('lien_360')->isValid()) {
                Common::instance()->deleteDirectoryContent($longPath, [$atelier->image, $atelier->audio]);
                do {
                    if ($request->file('lien_360')->move($longPath, 'pano.jpg')) {
                        break;
                    }
                } while (TRUE);
                $atelier->lien_360 = $shortPath . DIRECTORY_SEPARATOR . 'loyasite1';
            }
        }
        
        $atelier->timeline = floatval($request->get('timestamp'));
        $atelier->x_sommaire = floatval($request->get('x_sommaire'));
        $atelier->y_sommaire = floatval($request->get('y_sommaire'));
        $atelier->x_carte = floatval($request->get('x_carte'));
        $atelier->y_carte = floatval($request->get('y_carte'));
        $atelier->rayon = floatval($request->get('rayon'));
        $atelier->haov = floatval($request->get('haov'));
        $atelier->vaov = floatval($request->get('vaov'));
        $atelier->vOffset = floatval($request->get('voffset'));
        
        if ($atelier->save()) {
            if (!is_null($request->get('valider_voir'))) {
                $lien = explode('/', $atelier->lien_360);
                array_pop($lien);
                $url = implode('/', $lien); 
                return view('admin.pannellum')->withUrl(url('/') . $url)->withAtelier($atelier)->withId(0);
            } else {
                return redirect()->route('admin::site::atelier::get', ['id_site' => $id_site, 'id_atelier' => $atelier->id]);
            }
        }
    }

    public function newAtelier(Request $request, $id_site) {

        function incrementName($name, $path) {
            if (!array_search($name, scandir($path))) {
                return $name;
            } else {
                $baseName = splitLast($name, '-')[0];
                $num = intval(splitLast($name, '-')[1]) + 1;
                return incrementName($baseName . '-' . $num, $path);
            }
        }

        function splitLast($string, $delim) {
            $parts = explode($delim, $string);

            if (!$parts || count($parts) === 1) {
                $before = $string;
                $after = '';
            } else {
                $before = $parts[0];
                $after = $parts[1];
            }

            return [$before, $after];
        }

        $site = Site::find($id_site);
        $base = public_path() . $site->dossier . DIRECTORY_SEPARATOR;
        $site_name = incrementName('site', $base);
        $atelier_path = $base . $site_name;
        $short_atelier = $site->dossier . DIRECTORY_SEPARATOR . $site_name;
             
        $getID3 = new \getID3();
        $video = $getID3->analyze(public_path() . $site->video);
        
        $rules = ['timestamp' => 'required|numeric|min:0|max:' . $video['playtime_seconds'], 'x_sommaire' => 'required|numeric|min:0|max:100', 'y_sommaire' => 'required|numeric|min:0|max:100', 'x_carte' => 'required|numeric|minif:sig_map,0,-180.0|maxif:sig_map,100,180.0', 'y_carte' => 'required|numeric|minif:sig_map,0,-90|maxif:sig_map,100,90.0', 'image' => 'required|file|image', 'rayon' => 'required|numeric|min:1', 'audio' => 'required|file|mimes:mp3', 'lien_360' => 'required|file|image', 'haov' => 'required|numeric|min:0|max:360', 'vaov' => 'required|numeric|min:0|max:180', 'voffset' => 'required|numeric|min:-90|max:90'];
        
        $this->validate($request, $rules);

        $old_mask = umask(0);
        mkdir($atelier_path);
        umask($old_mask);

        if ($request->file('image')->isValid()) {
            do {
                if ($request->file('image')->move($atelier_path, 'vignette.' . $request->file('image')->getClientOriginalExtension())) {
                    break;
                }
            } while (true);
        }

        if ($request->file('audio')) {
            if ($request->file('audio')->isValid()) {
                do {
                    if ($request->file('audio')->move($atelier_path, 'snd.mp3')) {
                        break;
                    }
                } while (true);
            }
        }

        if ($request->file('lien_360')->isValid()) {
            do {
                if ($request->file('lien_360')->move($atelier_path, 'pano.jpg')) {
                    break;
                }
            } while (true);
        }
        
        $newAtelier = new Atelier();
        
        $newAtelier->site_id = $id_site;
        $newAtelier->x_sommaire = floatval($request->get('x_sommaire'));
        $newAtelier->y_sommaire = floatval($request->get('y_sommaire'));
        $newAtelier->x_carte = floatval($request->get('x_carte'));
        $newAtelier->y_carte = floatval($request->get('y_carte'));
        $newAtelier->image = $short_atelier . DIRECTORY_SEPARATOR . 'vignette.' . $request->file('image')->getClientOriginalExtension();
        $newAtelier->timeline = floatval($request->get('timestamp'));
        $newAtelier->image_deplie = $short_atelier. DIRECTORY_SEPARATOR . 'pano.jpg';
        $newAtelier->lien_360 = $short_atelier. DIRECTORY_SEPARATOR . 'loyasite1';
        $newAtelier->rayon = floatval($request->get('rayon'));
        $newAtelier->audio = $short_atelier . DIRECTORY_SEPARATOR . 'snd.mp3';
        
        if ($newAtelier->save()) {
            return redirect()->route('admin::site::atelier::get', ['id_site' => $id_site, 'id_atelier' => $newAtelier->id]);
        }
    }
    
    public function delete($id_site, $id_atelier) {
        $atelier = Atelier::find($id_atelier);
        
        $ateliers_tpn = Atelier_tpn::where('atelier_id', $atelier->id)->get();
        foreach ($ateliers_tpn as $atelier_tpn) {
            
            $exercices = Exercice::where('atelier_tpn_id', $atelier_tpn->id)->get();
            foreach ($exercices as $exercice) {
                
                $exercices_user = Exercice_user::where('exercice_id', $exercice->id)->get();
                foreach ($exercices_user as $exercice_user) {
                    $exercice_user->delete();
                }
                
                $questions = Question::where('exercice_id', $exercice->id)->get();
                foreach ($questions as $question) {
                    
                    $reponses = Reponse::where('question_id', $question->id)->get();
                    foreach ($reponses as $reponse) {
                        $reponse->delete();
                    }
                    
                    $reponses_user = Reponse_user::where('question_id', $question->id)->get();
                    foreach ($reponses_user as $reponse_user) {
                        $reponse_user->delete();
                    }
                    
                    $question->delete();
                }
                
                $exercice->delete();
            }
            
            $atelier_tpn->delete();
        }
        
        $path = public_path() . explode('/loyasite1', $atelier->lien_360)[0];
        Common::instance()->deleteDirectory($path);
        
        $atelier->delete();
        
        return redirect()->route('admin::site::atelier::index', ['id_site' => $id_site]);
    }

}
