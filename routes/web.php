<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();
//Route::get('/app', function () {
//    return view('layouts.app');
//});
//Route::get('/', function () {
//    return view('intro');
//});

Route::view('/', 'intro');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

//
//Route::get('/test', function () {
//    return view('test.qcm');
//});

Route::group(['middleware' => 'auth'], function () {

    Route::resource('classe', 'ClasseController');
    Route::resource('professeur', 'ProfesseurController');
    Route::resource('etudiant', 'EtudiantController');
    Route::resource('tpn', 'TpnController');
    Route::resource('exercice', 'ExerciceController');
    Route::resource('atelier', 'AtelierController');
    Route::resource('classe_etudiant', 'Classe_etudiantController');
    Route::resource('atelier_tpn', 'Atelier_tpnController');
    Route::resource('question', 'QuestionController');
    Route::resource('reponse', 'ReponseController');
    Route::resource('statistique', 'StatistiqueController');
    Route::resource('exercice_user', 'Exercice_userController');
    Route::resource('classe_tpn', 'Classe_tpnController');
    Route::resource('reponse_user', 'Reponse_userController');
    Route::resource('site', 'SiteController');
    Route::resource('user', 'UserController');
    Route::resource('choix', 'ChoixController');

    Route::get('/intro', ['uses' => 'FinalController@indexintro', 'as' => 'frontintro']);
    Route::get('/choix', ['uses' => 'ChoixController@index']);
    Route::get('/carte/{id}', ['uses' => 'FinalController@carte']);
    Route::get('/tutoriel', ['uses' => 'FinalController@tutoriel']);

    Route::get('/final/{tpn}', ['uses' => 'FinalController@index', 'as' => 'front']);
    Route::get('/overlay', ['uses' => 'FinalController@overlay']);
    Route::get('/exercice', ['uses' => 'FinalController@exercice']);
    Route::get('/360/{id}/{id_tpn}', ['uses' => 'FinalController@show360'])->where(['id' => '[0-9]+', 'id_tpn' => '[0-9]+']);
    Route::get('/site/{id}/visu', ['uses' => 'Admin\TpController@site', 'as' => 'showsite'])->where(['id' => '[0-9]+']);
    Route::get('/demo/{id}/{id_tpn}', ['uses' => 'Admin\TpController@show360'])->where(['id' => '[0-9]+', 'id_tpn' => '[0-9]+']);

    Route::group(['prefix' => 'qcm', 'as' => 'qcm::'], function () {
        Route::get('/{id}', ['uses' => 'QcmController@get', 'as' => 'show'])->where(['id' => '[0-9]+']);
        Route::post('/submit/{id}', ['uses' => 'QcmController@submit', 'as' => 'submit'])->where(['id' => '[0-9]+']);
    });

    Route::group(['prefix' => 'profil'], function () {
        Route::get('/', ['uses' => 'FinalController@profil']);
        Route::post('/email', ['uses' => 'FinalController@updateemailProfil', 'as' => 'modprofilemail']);
        Route::post('/password', ['uses' => 'FinalController@updatepasswordProfil', 'as' => 'modprofilpassword']);
    });
});

Route::group(['middleware' => ['auth', 'admin']], function () {

    Route::get('/getdata', ['uses' => 'Admin\GroupesController@autocomplete']);

    # /admin
    Route::group(['prefix' => 'admin'], function () {

        Route::get('/', ['uses' => 'Admin\ProfilController@showProfil', 'as' => 'accueiladmin']);
        Route::get('/espace', ['uses' => 'Admin\ProfilController@showProfil']);
        Route::post('/upload', ['uses' => 'Admin\TpController@upload_par_dossier']);
        Route::post('/uploadexercice/{num}/{id}', ['uses' => 'Admin\TpController@upload_par_dossier_pour_exercice'])->where(['num' => '[0-9]+', 'id' => '[0-9]+']);
        Route::post('/uploader', ['uses' => 'Admin\UploadController@uploads', 'as' => 'uploader']);
        Route::post('/setactive', ['uses' => 'Admin\TpController@setEtapeActive', 'as' => 'setactive']);
        Route::post('/choisirsite', ['uses' => 'Admin\TpController@injecterAteliersSite', 'as' => 'choisirsite']);
        Route::post('/ajoutatelier', ['uses' => 'Admin\TpController@bloc_atelier', 'as' => 'ajoutatelier']);
        Route::post('/creerateliers', ['uses' => 'Admin\TpController@injecterAteliersExercices', 'as' => 'creerateliers']);
        Route::post('/exercicefface', ['uses' => 'Admin\TpController@efface_exercice', 'as' => 'exercicefface']);
        Route::post('/injecter_exercices', ['uses' => 'Admin\TpController@inject_exercices_modifications', 'as' => 'injecter_exercices']);
        Route::post('/changerpublication', ['uses' => 'Admin\TpController@changerpublication', 'as' => 'changerpublication']);

        /* --------------------- PROFIL ---------------------- */
        # /admin/profil
        Route::group(['prefix' => 'profil'], function () {
            Route::get('/', ['uses' => 'Admin\ProfilController@showProfil', 'as' => 'profil']);
            Route::post('/info', ['uses' => 'Admin\ProfilController@updateinfoProfil', 'as' => 'infoprofil']);
            Route::post('/connexion', ['uses' => 'Admin\ProfilController@updateinfoConnexion', 'as' => 'infoconnexion']);
        });

        /* ---------------------- QCM ----------------------- */
        # /admin/qcm
        Route::group(['prefix' => 'qcm', 'as' => 'admin::qcm::'], function() {

            # /admin/qcm/new
            Route::group(['prefix' => 'new'], function() {
                Route::post('/', ['uses' => 'Admin\QcmController@getNewGeneral', 'as' => 'new::get']);
                Route::post('/{exercice_id}', ['uses' => 'Admin\QcmController@postNewGeneral', 'as' => 'new::post']);
            });

            # /admin/qcm/{exercice_id}/edit/{id}
            Route::group(['prefix' => '{exercice_id}/edit/{id}'], function() {
                Route::get('/', ['uses' => 'Admin\QcmController@getEditGeneral', 'as' => 'edit::get']);
                Route::post('/', ['uses' => 'Admin\QcmController@postEditGeneral', 'as' => 'edit::post']);

                # /admin/qcm/{exercice_id}/edit/{id}/questions
                Route::group(['prefix' => 'questions'], function() {
                    Route::get('/', ['uses' => 'Admin\QcmController@getEditQuestions', 'as' => 'edit::questions::get']);
                    Route::post('/', ['uses' => 'Admin\QcmController@postEditQuestions', 'as' => 'edit::questions::post']);
                    Route::post('/import', ['uses' => 'Admin\QcmController@importQcm', 'as' => 'import']);
                    Route::post('/export', ['uses' => 'Admin\QcmController@exportQcm', 'as' => 'export']);
                    Route::post('/select', ['uses' => 'Admin\QcmController@selectQuestion', 'as' => 'edit::questions::select']);
                    Route::post('/new', ['uses' => 'Admin\QcmController@newQuestion', 'as' => 'edit::questions::new']);

                    # /admin/qcm/{exercice_id}/edit/{id}/questions/{id_question}
                    Route::group(['prefix' => '{id_question}'], function() {
                        Route::get('/', ['uses' => 'Admin\QcmController@getEditQuestionById', 'as' => 'edit::questions::get::id']);
                        Route::post('/edit', ['uses' => 'Admin\QcmController@editQuestion', 'as' => 'edit::questions::modif']);
                        Route::delete('/delete', ['uses' => 'Admin\QcmController@deleteQuestion', 'as' => 'edit::questions::delete']);
                        Route::delete('/{id_answer}/delete', ['uses' => 'Admin\QcmController@deleteAnswer', 'as' => 'edit::questions::answers::delete']);
                    });
                });
            });
        });

        /* ------------------ TPNUMERIQUE ------------------- */
        # /admin/tpnumerique
        Route::group(['prefix' => 'tpnumerique'], function () {
            Route::get('/nouveau', ['uses' => 'Admin\TpController@nouveau', 'as' => 'nouveautp']);
            Route::get('/supprimer/{tp}', ['uses' => 'Admin\TpController@suppression', 'as' => 'supprimertp'])->where(['tp' => '[0-9]+']);
            Route::post('/creer', ['uses' => 'Admin\TpController@creernouveau', 'as' => 'creertp']);
            Route::post('/brouillon/{id_brouillon}/{inputchange}', ['uses' => 'Admin\TpController@brouillon', 'as' => 'brouillontpn'])->where(['id_brouillon' => '[0-9]+']);
            Route::get('/modifier/{tp}', ['uses' => 'Admin\TpController@modifier', 'as' => 'modifiertp'])->where(['tp' => '[0-9]+']);
            Route::get('/voirpano/{pano_url}/{exercices_v}/{exercices_h}', ['uses' => 'Admin\TpController@voirpano', 'as' => 'voirpano']);
            Route::get('/voirsite/{site_id}', ['uses' => 'Admin\TpController@voirsite', 'as' => 'voirsite'])->where(['site_id' => '[0-9]+']);
            Route::post('/choixgroupes', ['uses' => 'Admin\TpController@choixgroupes', 'as' => 'choixgroupes']);

            # /admin/tpnumerique/gerer
            Route::group(['prefix' => 'gerer'], function () {
                Route::get('/', ['uses' => 'Admin\TpController@gerer', 'as' => 'gerertp']);
                Route::get('/voir/{tp}', ['uses' => 'Admin\TpController@voir', 'as' => 'voirtp'])->where(['tp' => '[0-9]+']);
            });

            # /admin/tpnumerique/exercice
            Route::group(['prefix' => 'exercice'], function() {
                Route::post('/position', ['uses' => 'Admin\TpController@modifPosition', 'as' => 'modifposition']);
            });
        });

        /* --------------------- SITE ------------------------- */
        # /admin/site
        Route::group(['prefix' => 'site', 'as' => 'admin::site::'], function () {
            Route::get('/nouveau', ['uses' => 'Admin\SitesController@nouveau', 'as' => 'new']);
            Route::post('/creersite', ['uses' => 'Admin\SitesController@creerSite', 'as' => 'create']);
            Route::post('/setactive', ['uses' => 'Admin\SitesController@setEtapeActiveSite', 'as' => 'set']);

            # /admin/site/gerer
            Route::group(['prefix' => 'gerer'], function () {
                Route::get('/', ['uses' => 'Admin\SitesController@gerer', 'as' => 'edit']);

                # /admin/site/gerer/{id_site}
                Route::group(['prefix' => '{id_site}', 'where' => ['id_site' => '[0-9]+']], function () {

                    Route::delete('/', ['uses' => 'Admin\SitesController@suppression', 'as' => 'delete']);
                    Route::get('/visualisation', ['uses' => 'Admin\SitesController@visu', 'as' => 'visu']);

                    #/admin/site/gerer/{id_site}/sommaire
                    Route::group(['prefix' => 'sommaire', 'as' => 'summary::'], function () {
                        Route::get('/', ['uses' => 'Admin\SitesController@editSommaire', 'as' => 'edit']);
                        Route::post('/', ['uses' => 'Admin\SitesController@updateSommaire', 'as' => 'update']);
                        Route::delete('/sound/{id_sound}', ['uses' => 'Admin\SitesController@removeSound', 'as' => 'delete::sound']);
                    });

                    # /admin/site/gerer/{id_site}/atelier
                    Route::group(['prefix' => 'atelier', 'as' => 'atelier::'], function () {
                        Route::get('/', ['uses' => 'Admin\AteliersController@displayAtelierEdit', 'as' => 'index']);
                        Route::post('/', ['uses' => 'Admin\AteliersController@selectAtelier', 'as' => 'select']);
                        Route::post('/new', ['uses' => 'Admin\AteliersController@newAtelier', 'as' => 'new']);

                        # /admin/site/gerer/{id_site}/atelier/{id_atelier}
                        Route::group(['prefix' => '{id_atelier}', 'where' => ['id_atelier' => '(new|[0-9]+)']], function () {
                            Route::get('/', ['uses' => 'Admin\AteliersController@getAtelier', 'as' => 'get']);
                            Route::post('/', ['uses' => 'Admin\AteliersController@updateAtelier', 'as' => 'update']);
                            Route::delete('/', ['uses' => 'Admin\AteliersController@delete', 'as' => 'delete']);
                        });
                    });
                });
            });
        });

        /* -------------------- FICHIERS ---------------------- */
        # /admin/fichiers
        Route::group(['prefix' => 'fichiers'], function () {
            Route::get('/', ['uses' => 'Admin\FichiersController@index', 'as' => 'fichiers']);
            Route::get('/{cletri}', ['uses' => 'Admin\FichiersController@indextrie']);
            Route::post('/type/{type}', ['uses' => 'Admin\FichiersController@getFiles']);
        });

        /* --------------------- GROUPES ------------------------ */
        # /admin/groupes
        Route::group(['prefix' => 'groupes'], function () {
            Route::get('/', ['uses' => 'Admin\GroupesController@index', 'as' => 'groupes']);
            Route::post('/create', ['uses' => 'Admin\GroupesController@create', 'as' => 'groupe.create']);

            # /admin/groupes/{groupe}
            Route::group(['prefix' => '{groupe}', 'where' => ['groupe' => '[0-9]+']], function () {
                Route::delete('/', ['uses' => 'Admin\GroupesController@delete', 'as' => 'groupe.destroy']);
            });

            # /admin/groupes/edit/{groupe}
            Route::group(['prefix' => 'edit/{groupe}', 'where' => ['groupe' => '[0-9]+']], function () {
                Route::get('/', ['uses' => 'Admin\GroupesController@edit', 'as' => 'groupe.edit']);
                Route::post('/', ['uses' => 'Admin\GroupesController@update', 'as' => 'groupe.update']);
            });
        });

        /* ----------------------- PROFESSEUR ----------------------- */
        # /admin/professeur
        Route::group(['prefix' => 'professeur'], function () {
            Route::get('/', ['uses' => 'Admin\ProfesseursController@index', 'as' => 'professeur']);
            Route::post('/create', ['uses' => 'Admin\ProfesseursController@create', 'as' => 'prof.create']);
            Route::get('/edit/{prof}', ['uses' => 'Admin\ProfesseursController@edit', 'as' => 'prof.edit']);
            Route::post('/edit', ['uses' => 'Admin\ProfesseursController@update', 'as' => 'prof.update']);

            # /admin/professeur/{prof}
            Route::group(['prefix' => '{prof}', 'where' => ['prof' => '[0-9]+']], function () {
                Route::delete('/', ['uses' => 'Admin\ProfesseursController@destroyprof', 'as' => 'prof.destroy']);
            });
        });

        /* ------------------------- ETUDIANTS ----------------------- */
        # /admin/etudiants
        Route::group(['prefix' => 'etudiants', 'as' => 'admin::etudiants::'], function () {
            Route::get('/', ['uses' => 'Admin\EtudiantsController@index', 'as' => 'index']);
            Route::post('/create', ['uses' => 'Admin\EtudiantsController@create', 'as' => 'create']);

            Route::group(['prefix' => 'edit'], function () {
                Route::group(['prefix' => '{etd}', 'where' => ['etd' => '[0-9]+']], function () {
                    Route::get('/', ['uses' => 'Admin\EtudiantsController@edit', 'as' => 'edit']);
                    Route::post('/', ['uses' => 'Admin\EtudiantsController@update', 'as' => 'update']);
                    Route::delete('/', ['uses' => 'Admin\EtudiantsController@delete', 'as' => 'delete']);
                });
            });
        });
    });
});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
