<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qcm_questions extends Model
{
    protected $table = 'qcm_questions';
    public $timestamps = TRUE;
    protected $fillable = ['qcm_id', 'titre', 'question'];
    
    public function qcm() {
        return $this->belongsTo(\App\Models\Qcm::class);
    }
    
    public function answers() {
        return $this->hasMany(\App\Models\Qcm_answers::class);
    }
}
