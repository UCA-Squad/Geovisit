<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades;

class Site extends Model {

    protected $table = 'sites';
    
    public $timestamps = false;
    
    protected $fillable = ['titre', 'photo', 'video', 'img_mini_map', 'img_sentier', 'dossier', 'sound', 'sig_map', 'latmin', 'latmax', 'lonmin', 'lonmax'];

    public function ateliers() {
        
        return $this->hasMany(\App\Models\Atelier::class);
        
    }

    public function tpns() {
        
        return $this->hasMany(\App\Models\Tpn::class);
        
    }
    
    public static function getShortInfos() {
        return Facades\DB::table('sites')
                ->select('sites.id', 'titre', 'photo')
                ->selectRaw('COUNT(DISTINCT(ateliers.id)) AS nb_ateliers')
                ->selectRaw('COUNT(DISTINCT(tpns.id)) AS nb_tpns') 
                ->leftjoin('ateliers', 'sites.id', '=', 'ateliers.site_id')
                ->leftjoin('tpns', 'sites.id', '=', 'tpns.site_id')
                ->groupBy('sites.id')
                ->get();
    }
    
    public static function getShortInfosFromSiteId($id) {
        return Facades\DB::table('sites')
                ->select('sites.id', 'titre', 'photo')
                ->selectRaw('COUNT(DISTINCT(ateliers.id)) AS nb_ateliers')
                ->selectRaw('COUNT(DISTINCT(tpns.id)) AS nb_tpns') 
                ->leftjoin('ateliers', 'sites.id', '=', 'ateliers.site_id')
                ->leftjoin('tpns', 'sites.id', '=', 'tpns.site_id')
                ->groupBy('sites.id')
                ->where('sites.id', '=', $id)
                ->get();
    }

}
