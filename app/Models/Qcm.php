<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qcm extends Model
{
    protected $table = 'qcm';
    public $timestamps = TRUE;
    protected $fillable = ['titre', 'description', 'description_admin'];
    
    public function questions() {
        return $this->hasMany(\App\Models\Qcm_questions::class);
    }
    
    public function answers() {
        return $this->hasMany(\App\Models\Qcm_answers::class);
    }
}
