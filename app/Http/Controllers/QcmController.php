<?php

/* 
 * 
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

namespace App\Http\Controllers;
use App\Models\Qcm;
use Illuminate\Http\Request;
use Response;

class QcmController extends Controller {
    
    public function get($id) {
        $response = [];
        $qcm = Qcm::find($id);
        $response['titre'] = $qcm->titre;
        $response['description'] = $qcm->description;
        $response['id'] = $qcm->id;
        $response['questions'] = [];
        $response['questions_list'] = [];
        
        foreach($qcm->questions()->get() as $key => $question) {
            $response['questions_list'][$question->id] = 'Question ' . ($key + 1) . ' : ' . $question->titre;
            $q = ['titre' => $question->titre, 'question' => $question->question, 'id' => $question->id, 'answers' => []];
            
            foreach($question->answers()->get() as $answer) {
                array_push($q['answers'], ['id' => $answer->id, 'answer_title' => $answer->answer_title]);
            }
            array_push($response['questions'], $q);
        }
        
        return view('exercices.qcm')->withQcm($response);
    }
    
    public function submit($id, Request $request) {
        $qcm = Qcm::find($id);
        $nb_question = 0;
        $rules = [];
        $questions = [];
        
        foreach($qcm->questions()->get() as $key => $question) {
            $q = ['id' => $question->id, 'answers' => []];
            foreach($question->answers()->get() as $answer) {
                array_push($q['answers'], ['id' => $answer->id, 'boolean' => boolval($answer->answer_boolean)]);
            }
            array_push($questions, $q);
            $nb_question++;
        }
        
        for ($i = 1; $i <= $nb_question; $i++) {
            $rules['qcm-question-' . $i] = 'array';
            $rules['qcm-question-' . $i . '.*'] = 'Regex:/^answer-\d+$/';
        }
        
        $this->validate($request, $rules);
        
        return Response::json(['nb' => $nb_question, 'correction' => $questions]);
    }
    
}
