<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Site;

class SitesTableSeeder extends Seeder {
    
    public function run() {
        
        Site::create(array(
            'titre' => 'Baie de Loya',
            'photo' => '/final/tpn/loya/loya.jpg',
            'video' => '/final/tpn/loya/Sommaire_Loya.mp4',
            'img_mini_map' => '/final/tpn/loya/carte.png',
            'img_sentier' => '/final/tpn/loya/sentier.png',
            'dossier' => '/final/tpn/loya',
            'sound' => json_encode(array(
                array("sound" => array('tpn/loya/snd/far.mp3'), "range" => array(-0.1, 0.0, 0.33, 0.6)), 
                array("sound" => array('tpn/loya/snd/mid.mp3'), "range" => array(0.0, 0.33, 0.66, 1.0)),
                array("sound" => array('tpn/loya/snd/close.mp3'), "range" => array(0.33, 0.66, 1.0, 1.1))))
        ));
        
        Site::create(array(
            'titre' => 'Carrière de Vigny',
            'photo' => '/final/tpn/vigny/vigny.jpg',
            'video' => '/final/tpn/vigny/sommaire_vigny.mp4',
            'img_mini_map' => '/final/tpn/vigny/carte.png',
            'img_sentier' => '/final/tpn/vigny/sentier.png',
            'dossier' => '/final/tpn/vigny',
            'sound' => json_encode(array(
                array("sound" => array('tpn/vigny/snd/FXs.mp3'), "range" => array(-0.1, 0.0, 0.6, 1.0)),
                array("sound" => array('tpn/vigny/snd/birds.mp3'), "range" => array(0.4, 0.7, 1.0, 1.1))
            ))
        ));
        
    }
    
}