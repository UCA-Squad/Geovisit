<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Qcm_answers extends Model
{
    protected $table = 'qcm_answers';
    public $timestamp = TRUE;
    protected $fillable = ['qcm_id', 'qcm_questions_id', 'answer_title', 'answer_boolean'];
    
    public function qcm() {
        return $this->belongsTo(\App\Models\Qcm::class);
    }
    
    public function question() {
        return $this->belongsTo(\App\Models\Qcm_questions::class);
    }
}
