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

use PhpOffice\PhpSpreadsheet;
use App\Models\Qcm;
use App\Models\Qcm_questions;
use App\Models\Qcm_answers;
use App\Models\Atelier_tpn;

//$input_filename = '/home/guehenneux/Documents/GEOVISIT/QCM.xls';
//$input_filename = '/home/guehenneux/Documents/GEOVISIT/QCM.ods';
//$input_filename = '/home/guehenneux/Documents/GEOVISIT/QCM.csv';
$input_filename = '/home/guehenneux/Documents/GEOVISIT/QCM.xlsx';

//$reader = new PhpSpreadsheet\Reader\Xls();
//$reader = new PhpSpreadsheet\Reader\Ods();
//$reader = new PhpSpreadsheet\Reader\Csv();
$reader = new PhpSpreadsheet\Reader\Xlsx();

/* POUR XLS */
$reader->setReadDataOnly(TRUE);
$spreadsheet = $reader->load($input_filename);

$worksheet = $spreadsheet->getActiveSheet()->toArray();

$spreadsheet->disconnectWorksheets();
unset($spreadsheet);
/* FIN XLS */

$buff = [];
$data = [];

foreach ($worksheet as $row) {

    if (empty(array_filter($row))) {
        array_push($data, $buff);
        $buff = [];
    } else {
        if (!empty($row[0]) && !empty($row[1])) {
            $buff['titre'] = $row[0];
            $buff['question'] = $row[1];
            $buff['answers'] = [];
        } 

        array_push($buff['answers'], ['answer_title' => $row[2], 'answer_boolean' => $row[3]]);
    }

}
array_push($data, $buff);

//$atelier = Atelier_tpn::where('titre_atelier', '=', 'Ce sera un QCM')->get()[0];
//$exercice  = $atelier->exercices()->where('type', '=', 'qcm')->get()[0];
echo '<pre>';
print_r($data);
echo '</pre>';

//$qcm = new Qcm();
//$qcm->exercice_id = $exercice->id;
//$qcm->titre = 'Ce sera notre premier QCM';
//$qcm->description = 'Pour le moment on ne sait pas trop ou on va...';
//
//function convert_boolean($str) {
//    $out = filter_var(strtolower($str), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
//    if (is_null($out)) {
//        if (in_array(strtolower($str), ['vrai', 'oui', 'v', 'o'])) {
//            $out = TRUE;
//        } else {
//            $out = FALSE;
//        }
//    }
//    
//    return $out;
//}
//
//if ($qcm->save()) {
//    foreach ($data as $question) {
//        $qcm_question = new Qcm_questions();
//        $qcm_question->qcm_id = $qcm->id;
//        $qcm_question->titre = $question['titre'];
//        $qcm_question->question = $question['question'];
//        if ($qcm_question->save()) {
//            foreach($question['answers'] as $answer){
//                $qcm_answer = new Qcm_answers();
//                $qcm_answer->qcm_id = $qcm->id;
//                $qcm_answer->qcm_questions_id = $qcm_question->id;
//                $qcm_answer->answer_title = $answer['answer_title'];
//                $qcm_answer->answer_boolean = convert_boolean($answer['answer_boolean']);
//                $qcm_answer->save();
//            }
//        }
//    }
//}