<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Atelier;
use App\Models\Site;

class AteliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Atelier::create(array(
            "site_id" => Site::where('dossier', '=', '/final/tpn/loya')->get()[0]->id,
            "x_sommaire" => 40,
            "y_sommaire" => 70,
            "x_carte" => 77,
            "y_carte" => 79,
            "image" => "/final/tpn/loya/site1/vignette.jpg",
            "timeline" => 3.00,
            "image_deplie" => "/final/tpn/loya/site1/pano.jpg",
            "lien_360" => "/final/tpn/loya/site1/loyasite1",
            "vmin" => -43.0731,
            "vmax" => 55.8216,
            "audio" => "/final/tpn/loya/site1/snd.mp3"
        ));
        
        Atelier::create(array(
            "site_id" => Site::where('dossier', '=', '/final/tpn/loya')->get()[0]->id,
            "x_sommaire" => 25,
            "y_sommaire" => 60,
            "x_carte" => 72,
            "y_carte" => 86,
            "image" => "/final/tpn/loya/site2/vignette.jpg",
            "timeline" => 13.00,
            "image_deplie" => "/final/tpn/loya/site2/pano.jpg",
            "lien_360" => "/final/tpn/loya/site2/loyasite1",
            "vmin" => -50.3675,
            "vmax" => 43.9825,
            "audio" => "/final/tpn/loya/site2/snd.mp3"
        ));
        
        Atelier::create(array(
            "site_id" => Site::where('dossier', '=', '/final/tpn/loya')->get()[0]->id,
            "x_sommaire" => 45,
            "y_sommaire" => 70,
            "x_carte" => 68,
            "y_carte" => 86,
            "image" => "/final/tpn/loya/site3/vignette.jpg",
            "timeline" => 18.00,
            "image_deplie" => "/final/tpn/loya/site3/pano.jpg",
            "lien_360" => "/final/tpn/loya/site3/loyasite1",
            "vmin" => -36.245,
            "vmax" => 36.085,
            "audio" => "/final/tpn/loya/site3/snd.mp3"
        ));
        
        Atelier::create(array(
            "site_id" => Site::where('dossier', '=', '/final/tpn/loya')->get()[0]->id,
            "x_sommaire" => 45,
            "y_sommaire" => 50,
            "x_carte" => 60,
            "y_carte" => 87,
            "image" => "/final/tpn/loya/site4/vignette.jpg",
            "timeline" => 27.00,
            "image_deplie" => "/final/tpn/loya/site4/pano.jpg",
            "lien_360" => "/final/tpn/loya/site4/loyasite1",
            "vmin" => -72.1601,
            "vmax" => 62.1834,
            "audio" => "/final/tpn/loya/site4/snd.mp3"
        ));
        
        Atelier::create(array(
            "site_id" => Site::where('dossier', '=', '/final/tpn/loya')->get()[0]->id,
            "x_sommaire" => 50,
            "y_sommaire" => 75,
            "x_carte" => 56.9,
            "y_carte" => 79,
            "image" => "/final/tpn/loya/site5/vignette.jpg",
            "timeline" => 32.00,
            "image_deplie" => "/final/tpn/loya/site5/pano.jpg",
            "lien_360" => "/final/tpn/loya/site5/loyasite1",
            "vmin" => -64.3496,
            "vmax" => 66.6014,
            "audio" => "/final/tpn/loya/site5/snd.mp3"
        ));
        
        Atelier::create(array(
            "site_id" => Site::where('dossier', '=', '/final/tpn/loya')->get()[0]->id,
            "x_sommaire" => 45,
            "y_sommaire" => 65,
            "x_carte" => 52,
            "y_carte" => 74.2,
            "image" => "/final/tpn/loya/site6/vignette.jpg",
            "timeline" => 37.00,
            "image_deplie" => "/final/tpn/loya/site6/pano.jpg",
            "lien_360" => "/final/tpn/loya/site6/loyasite1",
            "vmin" => -51.2571,
            "vmax" => 62.1571,
            "audio" => "/final/tpn/loya/site6/snd.mp3"
        ));
        
        Atelier::create(array(
            "site_id" => Site::where('dossier', '=', '/final/tpn/loya')->get()[0]->id,
            "x_sommaire" => 45,
            "y_sommaire" => 70,
            "x_carte" => 50.3,
            "y_carte" => 68.2,
            "image" => "/final/tpn/loya/site8/vignette.jpg",
            "timeline" => 44.00,
            "image_deplie" => "/final/tpn/loya/site8/pano.jpg",
            "lien_360" => "/final/tpn/loya/site8/loyasite1",
            "vmin" => -69.03,
            "vmax" => 42.69,
            "audio" => "/final/tpn/loya/site8/snd.mp3"
        ));
        
        Atelier::create(array(
            "site_id" => Site::where('dossier', '=', '/final/tpn/loya')->get()[0]->id,
            "x_sommaire" => 50,
            "y_sommaire" => 50,
            "x_carte" => 49.3,
            "y_carte" => 61,
            "image" => "/final/tpn/loya/site9/vignette.jpg",
            "timeline" => 48.00,
            "image_deplie" => "/final/tpn/loya/site9/pano.jpg",
            "lien_360" => "/final/tpn/loya/site9/loyasite1",
            "vmin" => -48.25,
            "vmax" => 53.9172,
            "audio" => "/final/tpn/loya/site9/snd.mp3"
        ));
        
        Atelier::create(array(
            "site_id" => Site::where('dossier', '=', '/final/tpn/loya')->get()[0]->id,
            "x_sommaire" => 50,
            "y_sommaire" => 50,
            "x_carte" => 44,
            "y_carte" => 66,
            "image" => "/final/tpn/loya/site10/vignette.jpg",
            "timeline" => 54.00,
            "image_deplie" => "/final/tpn/loya/site10/pano.jpg",
            "lien_360" => "/final/tpn/loya/site10/loyasite1",
            "vmin" => -53.4686,
            "vmax" => 64.0872,
            "audio" => "/final/tpn/loya/site10/snd.mp3"
        ));
        
        Atelier::create(array(
            "site_id" => Site::where('dossier', '=', '/final/tpn/loya')->get()[0]->id,
            "x_sommaire" => 50,
            "y_sommaire" => 50,
            "x_carte" => 39,
            "y_carte" => 67,
            "image" => "/final/tpn/loya/site11/vignette.jpg",
            "timeline" => 56.00,
            "image_deplie" => "/final/tpn/loya/site11/pano.jpg",
            "lien_360" => "/final/tpn/loya/site11/loyasite1",
            "vmin" => -40.945,
            "vmax" => 47.225,
            "audio" => "/final/tpn/loya/site11/snd.mp3"
        ));
        
        Atelier::create(array(
            "site_id" => Site::where('dossier', '=', '/final/tpn/loya')->get()[0]->id,
            "x_sommaire" => 50,
            "y_sommaire" => 50,
            "x_carte" => 32,
            "y_carte" => 65,
            "image" => "/final/tpn/loya/site12/vignette.jpg",
            "timeline" => 62.00,
            "image_deplie" => "/final/tpn/loya/site12/pano.jpg",
            "lien_360" => "/final/tpn/loya/site12/loyasite1",
            "vmin" => -75.71,
            "vmax" => 38.99,
            "audio" => "/final/tpn/loya/site12/snd.mp3"
        ));
        
        Atelier::create(array(
            "site_id" => Site::where('dossier', '=', '/final/tpn/loya')->get()[0]->id,
            "x_sommaire" => 50,
            "y_sommaire" => 50,
            "x_carte" => 29.3,
            "y_carte" => 42.5,
            "image" => "/final/tpn/loya/site13/vignette.jpg",
            "timeline" => 79.00,
            "image_deplie" => "/final/tpn/loya/site13/pano.jpg",
            "lien_360" => "/final/tpn/loya/site13/loyasite1",
            "vmin" => -89.745,
            "vmax" => 61.425,
            "audio" => "/final/tpn/loya/site13/snd.mp3"
        ));
        
        Atelier::create(array(
            "site_id" => Site::where('dossier', '=', '/final/tpn/loya')->get()[0]->id,
            "x_sommaire" => 50,
            "y_sommaire" => 50,
            "x_carte" => 29.8,
            "y_carte" => 32,
            "image" => "/final/tpn/loya/site14/vignette.jpg",
            "timeline" => 82.00,
            "image_deplie" => "/final/tpn/loya/site14/pano.jpg",
            "lien_360" => "/final/tpn/loya/site14/loyasite1",
            "vmin" => -89.75,
            "vmax" => 65.49,
            "audio" => "/final/tpn/loya/site14/snd.mp3"
        ));
        
        Atelier::create(array(
            "site_id" => Site::where('dossier', '=', '/final/tpn/loya')->get()[0]->id,
            "x_sommaire" => 50,
            "y_sommaire" => 50,
            "x_carte" => 27,
            "y_carte" => 26.5,
            "image" => "/final/tpn/loya/site15/vignette.jpg",
            "timeline" => 86.00,
            "image_deplie" => "/final/tpn/loya/site15/pano.jpg",
            "lien_360" => "/final/tpn/loya/site15/loyasite1",
            "vmin" => -89.75,
            "vmax" => 56.47,
            "audio" => "/final/tpn/loya/site15/snd.mp3"
        ));
        
        Atelier::create(array(
            "site_id" => Site::where('dossier', '=', '/final/tpn/vigny')->get()[0]->id,
            "x_sommaire" => 40,
            "y_sommaire" => 70,
            "x_carte" => 38.2,
            "y_carte" => 36,
            "image" => "/final/tpn/vigny/site1/vignette.jpg",
            "timeline" => 1.10,
            "image_deplie" => "/final/tpn/vigny/site1/pano.jpg",
            "lien_360" => "/final/tpn/vigny/site1/loyasite1",
            "vmin" => -60.91,
            "vmax" => 60.91,
            "audio" => "/final/tpn/vigny/site1/snd.mp3"
        ));
        
        Atelier::create(array(
            "site_id" => Site::where('dossier', '=', '/final/tpn/vigny')->get()[0]->id,
            "x_sommaire" => 25,
            "y_sommaire" => 60,
            "x_carte" => 44,
            "y_carte" => 37.5,
            "image" => "/final/tpn/vigny/site2/vignette.jpg",
            "timeline" => 12.60,
            "image_deplie" => "/final/tpn/vigny/site2/pano.jpg",
            "lien_360" => "/final/tpn/vigny/site2/loyasite1",
            "vmin" => -55.455,
            "vmax" => 71.815,
            "audio" => "/final/tpn/vigny/site2/snd.mp3"
        ));
        
        Atelier::create(array(
            "site_id" => Site::where('dossier', '=', '/final/tpn/vigny')->get()[0]->id,
            "x_sommaire" => 45,
            "y_sommaire" => 70,
            "x_carte" => 46.2,
            "y_carte" => 45.5,
            "image" => "/final/tpn/vigny/site3/vignette.jpg",
            "timeline" => 20.0,
            "image_deplie" => "/final/tpn/vigny/site3/pano.jpg",
            "lien_360" => "/final/tpn/vigny/site3/loyasite1",
            "vmin" => -46.7381,
            "vmax" => 46.7381,
            "audio" => "/final/tpn/vigny/site3/snd.mp3"
        ));
        
        Atelier::create(array(
            "site_id" => Site::where('dossier', '=', '/final/tpn/vigny')->get()[0]->id,
            "x_sommaire" => 45,
            "y_sommaire" => 50,
            "x_carte" => 50.6,
            "y_carte" => 52.8,
            "image" => "/final/tpn/vigny/site4/vignette.jpg",
            "timeline" => 24.90,
            "image_deplie" => "/final/tpn/vigny/site4/pano.jpg",
            "lien_360" => "/final/tpn/vigny/site4/loyasite1",
            "vmin" => -64.545,
            "vmax" => 80.905,
            "audio" => "/final/tpn/vigny/site4/snd.mp3"
        ));
        
        Atelier::create(array(
            "site_id" => Site::where('dossier', '=', '/final/tpn/vigny')->get()[0]->id,
            "x_sommaire" => 50,
            "y_sommaire" => 75,
            "x_carte" => 60.1,
            "y_carte" => 71.5,
            "image" => "/final/tpn/vigny/site6/vignette.jpg",
            "timeline" => 45.90,
            "image_deplie" => "/final/tpn/vigny/site6/pano.jpg",
            "lien_360" => "/final/tpn/vigny/site6/loyasite1",
            "vmin" => -75.625,
            "vmax" => 70.345,
            "audio" => "/final/tpn/vigny/site6/snd.mp3"
        ));
        
        Atelier::create(array(
            "site_id" => Site::where('dossier', '=', '/final/tpn/vigny')->get()[0]->id,
            "x_sommaire" => 45,
            "y_sommaire" => 65,
            "x_carte" => 66.2,
            "y_carte" => 75.2,
            "image" => "/final/tpn/vigny/site7/vignette.jpg",
            "timeline" => 53.40,
            "image_deplie" => "/final/tpn/vigny/site7/pano.jpg",
            "lien_360" => "/final/tpn/vigny/site7/loyasite1",
            "vmin" => -67.555,
            "vmax" => 71.815,
            "audio" => "/final/tpn/vigny/site7/snd.mp3"
        ));
        
        Atelier::create(array(
            "site_id" => Site::where('dossier', '=', '/final/tpn/vigny')->get()[0]->id,
            "x_sommaire" => 45,
            "y_sommaire" => 70,
            "x_carte" => 72.6,
            "y_carte" => 79.5,
            "image" => "/final/tpn/vigny/site8/vignette.jpg",
            "timeline" => 60.70,
            "image_deplie" => "/final/tpn/vigny/site8/pano.jpg",
            "lien_360" => "/final/tpn/vigny/site8/loyasite1",
            "vmin" => -55.45,
            "vmax" => 24.55,
            "audio" => "/final/tpn/vigny/site8/snd.mp3"
        ));
    }
}
