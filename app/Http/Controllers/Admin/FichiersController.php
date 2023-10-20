<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;
use File;
use Image;
use SizeClass;
use Session;
use Illuminate\Support\Facades\URL;
use Response;
use App\Helpers\Common;

class FichiersController extends Controller {

    public function index() {
        if (Session::has('rubrique')) {
            Session::forget('rubrique');
            Session::put('rubrique', 'fichiers');
        } else {
            Session::put('rubrique', 'fichiers');
        }
        
        $fichiers = [];
        $f = [];
        
        if (File::exists('img/uploads/' . Auth::user()->userable_id . '/img_editeur')) {
            $fichiers = File::allFiles('img/uploads/' . Auth::user()->userable_id . '/img_editeur');
        }
        if (File::exists('img/uploads/' . Auth::user()->userable_id . '/img_qcm')) {
            array_merge($fichiers, File::allFiles('img/uploads/' . Auth::user()->userable_id . '/img_qcm'));
        }        
        $fichiers2 = Common::instance()->rglob('img/uploads/' . Auth::user()->userable_id . '/vid_editeur/{*.mp4,*.flv,*.mov,*.webm}', GLOB_BRACE);
        array_merge($fichiers2, Common::instance()->rglob('img/uploads/' . Auth::user()->userable_id . '/vid_qcm/{*.mp4,*.flv,*.mov,*.webm}', GLOB_BRACE));
        

        foreach ($fichiers as $file) {
            $f[] = ['nom' => pathinfo($file, PATHINFO_FILENAME), 'date' => strftime("%d %B %Y", File::lastModified($file)), 'type' => File::mimeType($file), 'size' => SizeClass::bytesToHuman(File::size($file)), 'url' => URL::to('/') . DIRECTORY_SEPARATOR . pathinfo($file, PATHINFO_DIRNAME) . DIRECTORY_SEPARATOR . pathinfo($file, PATHINFO_BASENAME)];
        }
        
        foreach ($fichiers2 as $file) {
            $f[] = ['nom' => pathinfo($file, PATHINFO_FILENAME), 'date' => strftime("%d %B %Y", File::lastModified($file)), 'type' => File::mimeType($file), 'size' => SizeClass::bytesToHuman(File::size($file)), 'url' => URL::to('/') . DIRECTORY_SEPARATOR . pathinfo($file, PATHINFO_DIRNAME) . DIRECTORY_SEPARATOR . pathinfo($file, PATHINFO_BASENAME)];            
        }

        return view('admin.fichiers')->withFichiers($f);
    }

    public function getFiles($type) {
        $fichiers = [];
        $f = [];

        switch ($type) {
            case 'img':
                if (File::exists('img/uploads/' . Auth::user()->userable_id . '/img_editeur')) {
                    $fichiers = File::allFiles('img/uploads/' . Auth::user()->userable_id . '/img_editeur');
                }
                if (File::exists('img/uploads/' . Auth::user()->userable_id . '/img_qcm')) {
                    array_merge($fichiers, File::allFiles('img/uploads/' . Auth::user()->userable_id . '/img_qcm'));
                }
                if (!File::exists('img/uploads/' . Auth::user()->userable_id . '/thumbnails')) {
                    File::makeDirectory('img/uploads/' . Auth::user()->userable_id . '/thumbnails');
                }
                break;
            case 'vid':
                $fichiers = Common::instance()->rglob('img/uploads/' . Auth::user()->userable_id . '/vid_editeur/{*.mp4,*.webm}', GLOB_BRACE);
                array_merge($fichiers, Common::instance()->rglob('img/uploads/' . Auth::user()->userable_id . '/vid_qcm/{*.mp4,*.webm}', GLOB_BRACE));
                break;
        }

        foreach ($fichiers as $file) {

            switch ($type) {
                case 'img':
                    // Création miniature si n'existe pas
                    if (!File::exists('img/uploads/' . Auth::user()->userable_id . '/thumbnails/thumbnails' . pathinfo($file, PATHINFO_BASENAME))) {
                        Image::make($file)->resize(60, 60)->save('img/uploads/' . Auth::user()->userable_id . '/thumbnails/thumbnails' . pathinfo($file, PATHINFO_BASENAME));
                    }
                    $f[] = ['thumbnails' => '<img src="' . URL::to('/') . '/img/uploads/' . Auth::user()->userable_id . '/thumbnails/thumbnails' . pathinfo($file, PATHINFO_BASENAME) . '" class="photo">', 'nom' => pathinfo($file, PATHINFO_FILENAME), 'date' => strftime("%d %B %Y", File::lastModified($file)), 'url' => URL::to('/') . DIRECTORY_SEPARATOR . pathinfo($file, PATHINFO_DIRNAME) . DIRECTORY_SEPARATOR . pathinfo($file, PATHINFO_BASENAME), 'type' => File::mimeType($file)];
                    break;
                case 'vid':
                    $f[] = ['thumbnails' => null, 'nom' => pathinfo($file, PATHINFO_FILENAME), 'date' => strftime("%d %B %Y", File::lastModified($file)), 'url' => URL::to('/') . DIRECTORY_SEPARATOR . pathinfo($file, PATHINFO_DIRNAME) . DIRECTORY_SEPARATOR . pathinfo($file, PATHINFO_BASENAME), 'type' => File::mimeType($file)];
                    break;
            }
        }

        return Response::json($f);
    }

    public function indextrie($cletri) {
        if (Session::has('rubrique')) {
            Session::forget('rubrique');
            Session::put('rubrique', 'fichiers');
        } else {
            Session::put('rubrique', 'fichiers');
        }

        /* @if(Session::has('rubrique'))
          {{ Session::get('rubrique') }}
          @endif */

        $rubrique = Session::get('rubrique');

        $fichiers = [];
        $f = [];
        if (File::exists('img/uploads/' . Auth::user()->userable_id . '/img_editeur')) {
            $fichiers = File::allFiles('img/uploads/' . Auth::user()->userable_id . '/img_editeur');
        }
        if (File::exists('img/uploads/' . Auth::user()->userable_id . '/img_qcm')) {
            array_merge($fichiers, File::allFiles('img/uploads/' . Auth::user()->userable_id . '/img_qcm'));
        }
        if (File::exists('img/uploads/' . Auth::user()->userable_id . '/vid_editeur')) {
            array_merge($fichiers, File::allFiles('img/uploads/' . Auth::user()->userable_id . '/vid_editeur'));
        }
        if (File::exists('img/uploads/' . Auth::user()->userable_id . '/vid_qcm')) {
            array_merge($fichiers, File::allFiles('img/uploads/' . Auth::user()->userable_id . '/vid_qcm'));
        }
        if (!File::exists('img/uploads/' . Auth::user()->userable_id . '/thumbnails')) {
            File::makeDirectory('img/uploads/' . Auth::user()->userable_id . '/thumbnails');
        }
        setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
        foreach ($fichiers as $file) {
            $thumbnail = '';
            $recup = explode('_', pathinfo($file, PATHINFO_FILENAME));
            array_shift($recup);
            $nom = implode('_', $recup);
            if (substr(File::mimeType($file), 0, 5) == 'image') {
                if (!File::exists(pathinfo($file, PATHINFO_DIRNAME) . '/thumbnail' . pathinfo($file, PATHINFO_BASENAME))) {
                    $thumbnail = Image::make($file)->resize(60, 60)->save('img/uploads/' . Auth::user()->userable_id . '/thumbnails/thumbnail' . pathinfo($file, PATHINFO_BASENAME));
                }
                $thumbnail = Auth::user()->userable_id . "/thumbnails/thumbnail" . pathinfo($file, PATHINFO_BASENAME);
            }

            $date = strftime("%d %B %Y", File::lastModified($file));
            $timestamp = File::lastModified($file);
            $type = File::mimeType($file);
            $sizeh = SizeClass::bytesToHuman(File::size($file));
            $size = File::size($file);
            $f[] = ['nom' => $nom, 'thumbnail' => $thumbnail, 'date' => $date, 'type' => $type, 'size' => $size, 'sizeh' => $sizeh, 'timestamp' => $timestamp, 'file' => $file];
        }

        // if (Session::has('order')) {
        switch (Session::get('order')) {
            case 'asc':
                Session::put('order', 'desc');
                usort($f, fn($a, $b) => strnatcmp($a[$cletri], $b[$cletri]));
                break;
            case 'desc':
                Session::put('order', 'asc');
                usort($f, fn($a, $b) => strnatcmp($b[$cletri], $a[$cletri]));
                break;
            default:
                Session::put('order', 'asc');
        }
        // }


        return view('admin.fichiers')->withFichiers($f);
    }

}
