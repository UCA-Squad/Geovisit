<?php

namespace App\Http\Controllers\Admin;

use App\User;
use URL;
use DB;
use Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Html\HtmlBuilder;
use App\Http\Controllers\Controller;
use Request;
use Response;
use Validator;
use File;
use Auth;
use Image;
use Carbon\Carbon;

class UploadController extends Controller {

    public function uploads(Request $request) {
        $photo = "";
        $persopath = "";
        $path = "";
        $extension = "";
        $dossier = "";
        $filename = "";
        $externe = "";

        //SOURCE DE L'APPEL
        $depuis = $request::input('depuis');
        $type_contenu = $request::input('type_contenu');

        $specialchar_array = ['Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y'];

        if ($depuis == "editeur_qcm") {

            $photo = $request::file('file');
            $mime =  File::mimeType($photo);

            //VERIFIER EXISTENCE DOSSIER USER
            $persopath = public_path() . "/img/uploads/" . Auth::user()->userable_id;

            $persopath = strtr($persopath, $specialchar_array);
            
            if ($type_contenu == "photo") {
                $path = $persopath . '/img_editeur/qcm';
            } else if ($type_contenu == "video") {
                $path = $persopath . '/vid_editeur/qcm';
            }

            if (!is_dir($persopath)) {
                File::makeDirectory($persopath, 0775, true);
                if (!is_dir($path)) {
                    File::makeDirectory($path, 0775, true);
                    if (!is_dir($path)) {
                        File::makeDirectory($path, 0775, true);
                    }
                } else {
                    if (!is_dir($path)) {
                        File::makeDirectory($path, 0775, true);
                    }
                }
            } else {
                if (!is_dir($path)) {
                    File::makeDirectory($path, 0775, true);
                    if (!is_dir($path)) {
                        File::makeDirectory($path, 0775, true);
                    }
                } else {
                    if (!is_dir($path)) {
                        File::makeDirectory($path, 0775, true);
                    }
                }
            }

            $nom_fichier = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $photo->getClientOriginalExtension();
            $dossier = $path;
            $filename = time() . "_" . $nom_fichier . ".{$extension}";
        } else if ($depuis == "editeur_intro") {
            $photo = $request::file('file');
            $mime =  File::mimeType($photo);
            $persopath = public_path() . "/img/uploads/" . Auth::user()->userable_id;
            $persopath = strtr($persopath, $specialchar_array);

            if ($type_contenu == "photo") {
                $path = $persopath . '/img_editeur';
            } else if ($type_contenu == "video") {
                $path = $persopath . '/vid_editeur';
            }

            if (!is_dir($persopath)) {
                File::makeDirectory($persopath, 0775, true);
                if (!is_dir($path)) {
                    File::makeDirectory($path, 0775, true);
                    if (!is_dir($path . '/intro')) {
                        File::makeDirectory($path . '/intro', 0775, true);
                    }
                } else {
                    if (!is_dir($path . '/intro')) {
                        File::makeDirectory($path . '/intro', 0775, true);
                    }
                }
            } else {
                if (!is_dir($path)) {
                    File::makeDirectory($path, 0775, true);
                    if (!is_dir($path . '/intro')) {
                        File::makeDirectory($path . '/intro', 0775, true);
                    }
                } else {
                    if (!is_dir($path . '/intro')) {
                        File::makeDirectory($path . '/intro', 0775, true);
                    }
                }
            }

            $nom_fichier = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $photo->getClientOriginalExtension();
            $dossier = $path . '/intro';
            $filename = time() . "_" . $nom_fichier . ".{$extension}";
        } elseif ($depuis == "editeur_exercice") {
            $photo = $request::file('file');            
            $mime =  File::mimeType($photo);

            $persopath = public_path() . "/img/uploads/" . Auth::user()->userable_id;
            $persopath = strtr($persopath, $specialchar_array);

            if ($type_contenu == "photo") {
                $path = $persopath . '/img_editeur';
            } else if ($type_contenu == "video") {
                $path = $persopath . '/vid_editeur';
            }

            if (!is_dir($persopath)) {
                File::makeDirectory($persopath, 0775, true);
                if (!is_dir($path)) {
                    File::makeDirectory($path, 0775, true);
                    if (!is_dir($path . '/exercice')) {
                        File::makeDirectory($path . '/exercice', 0775, true);
                    }
                } else {
                    if (!is_dir($path . '/exercice')) {
                        File::makeDirectory($path . '/exercice', 0775, true);
                    }
                }
            } else {
                if (!is_dir($path)) {
                    File::makeDirectory($path, 0775, true);
                    if (!is_dir($path . '/exercice')) {
                        File::makeDirectory($path . '/exercice', 0775, true);
                    }
                } else {
                    if (!is_dir($path . '/exercice')) {
                        File::makeDirectory($path . '/exercice', 0775, true);
                    }
                }
            }

            $nom_fichier = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $photo->getClientOriginalExtension();
            $dossier = $path . '/exercice';
            $filename = time() . "_" . $nom_fichier . ".{$extension}";
        } elseif ($depuis == "profil") {
            $externe = $request::input('externe');
            
            $persopath = public_path() . "/img/uploads/" . Auth::user()->userable_id;
            $persopath = strtr($persopath, $specialchar_array);
            $path = $persopath . '/avatar';

            if (!is_dir($persopath)) {
                File::makeDirectory($persopath, 0775, true);
                if (!is_dir($path)) {
                    File::makeDirectory($path, 0775, true);
                }
            } else {
                if (!is_dir($path)) {
                    File::makeDirectory($path, 0775, true);
                }
            }
            
            if ($externe == "non") {
                $photo = $request::file('file');
                $mime =  File::mimeType($photo);
                $extension = $photo->getClientOriginalExtension();
                $dossier = $path;
                $filename = "avatar.{$extension}";
            } else if ($externe == "oui") {
                $photo = $request::input('file');
                $mime =  File::mimeType($photo);
                $url_arr = explode('/', $photo);
                $ct = count($url_arr);
                $name = $url_arr[$ct - 1];
                $name_div = explode('.', $name);
                $ct_dot = count($name_div);
                $extension = $name_div[$ct_dot - 1];
                $dossier = $path;
                $filename = "avatar.{$extension}";
            } else if ($externe == "dossier") {
                $photo = $request::input('file');
                $mime =  File::mimeType($photo);
                $url_arr = explode('/', $photo);
                $ct = count($url_arr);
                $name = $url_arr[$ct - 1];
                $name_div = explode('.', $name);
                $ct_dot = count($name_div);
                $extension = $name_div[$ct_dot - 1];
                $dossier = $path;
                $filename = "test.{$extension}";
            }
        } elseif ($depuis == "fichiers") {
            $photo = $request::file('file');            
            $mime =  File::mimeType($photo);

            $persopath = public_path() . "/img/uploads/" . Auth::user()->userable_id;
            $persopath = strtr($persopath, $specialchar_array);
            $path = $persopath;

            if (!is_dir($persopath)) {
                File::makeDirectory($persopath, 0775, true);
                if (!is_dir($path)) {
                    File::makeDirectory($path, 0775, true);
                }
            } else {
                if (!is_dir($path)) {
                    File::makeDirectory($path, 0775, true);
                }
            }

            $nom_fichier = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $photo->getClientOriginalExtension();
            $dossier = $path;
            $filename = time() . "_" . $nom_fichier . ".{$extension}";
        }

        if ($photo) {
            if ($depuis == "profil" && $externe == "oui") {
                $upload_success = file_put_contents($dossier . '/' . $filename, file_get_contents($photo));
            } else if ($depuis == "profil" && $externe == "dossier") {
                $upload_success = \File::copy($photo, $dossier . '/' . $filename);
            } else {
                $upload_success = $photo->move($dossier, $filename);
            }
        } else {
            $upload_success = false;
        }

        if ($upload_success) {
            $nouveau_path = $dossier . '/' . $filename;

            if ($depuis == "profil") {
                Image::make($nouveau_path)->resize(180, 181)->save($nouveau_path);
                $nouveau_path = str_replace(public_path(), '', $nouveau_path);

                //INSERT DB
                DB::table('users')
                        ->where('userable_id', Auth::user()->userable_id)
                        ->update(['avatar' => utf8_encode($nouveau_path)]);

                return Response::json(['msg' => $nouveau_path, 'de' => $depuis]);
            } else if ($depuis == "editeur_intro") {
                $nouveau_path = str_replace(public_path(), '', $nouveau_path);
            } else if ($depuis == "editeur_exercice") {
                $nouveau_path = str_replace(public_path(), '', $nouveau_path);
            } else if ($depuis == "editeur_qcm") {
                $nouveau_path = str_replace(public_path(), '', $nouveau_path);
            } else if ($depuis == "fichiers") {
                $nouveau_path = str_replace(public_path(), '', $nouveau_path);
            }
            return Response::json(['msg' => $nouveau_path, 'de' => $depuis, 'type' => $mime]);
        } else {
            return Response::json(['msg' => 'ERREUR', 'de' => $depuis]);
        }
    }

    public function fichiers(Request $request) {        
    }
}