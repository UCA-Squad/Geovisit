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

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Qcm;
use App\Models\Qcm_questions;
use App\Models\Qcm_answers;
use App\Models\Exercice;
use Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpSpreadsheet;

class QcmController extends Controller {

    public function getNewGeneral(Request $request) {
        $exercice = new Exercice();
        $exercice->x = $request->get('x');
        $exercice->y = $request->get('y');
        $exercice->type = $request->get('type');
        $exercice->atelier_tpn_id = $request->get('atelier_tpn_id');
        $exercice->contenu = '';
        $exercice->contenu_admin = '';
        if ($exercice->save()) {
            return new JsonResponse(['id_exercice' => $exercice->id]);
        }
    }

    public function getEditGeneral($id_exercice, $id) {
        if ($id_exercice === 'new' && $id === 'new') {
            $id_exercice = NULL;
            $out = NULL;
        } else if ($id === 'new') {
            $out = NULL;
        } else {
            $qcm = Qcm::find($id);
            $out = [];
            $out['titre'] = $qcm->titre;
            $out['description'] = $qcm->description;
            $out['description_admin'] = $qcm->description_admin;
            $out['id'] = $qcm->id;
        }
        return view('admin.ateliers.qcm.editGeneral', ['qcm' => $out, 'id_exercice' => $id_exercice]);
    }

    public function PostNewGeneral($id_exercice, Request $request) {
        /* Check rules pour qcm-description et qcm-description-admin */
        $rules = ['titre-qcm' => 'required|regex:/[a-zA-Z0-9À-ÖØ-öø-ÿ\s]+/'];

        $this->validate($request, $rules);

        $qcm = new Qcm();
        $qcm->exercice_id = $id_exercice;
        $qcm->titre = $request->get('titre-qcm');
        $qcm->description = $request->get('qcm-description');
        $qcm->description_admin = $request->get('qcm-description-admin');

        $selectQuestions = [];
        $selectQuestions['new'] = 'AJOUTER UNE NOUVELLE QUESTION';
        try {
            $qcm->save();
            $exercice = Exercice::find($id_exercice);
            $exercice->contenu = json_encode(['qcm_id' => $qcm->id], JSON_THROW_ON_ERROR);
            $exercice->contenu_admin = json_encode(['qcm_id' => $qcm->id], JSON_THROW_ON_ERROR);
            $exercice->save();
            return view('admin.ateliers.qcm.editQuestion', ['question' => NULL, 'selectQuestions' => $selectQuestions, 'qcm' => $qcm, 'id_exercice' => $id_exercice]);
        } catch (Exception $ex) {
            return new JsonResponse(['error' => $ex->message()]);
        }
    }

    public function postEditGeneral($id_exercice, $id, Request $request) {
        /* Check rules pour qcm-description et qcm-description-admin */
        $rules = ['titre-qcm' => 'required|regex:/^[a-zA-Z0-9À-ÖØ-öø-ÿ\s\':!?_]+$/'];

        $this->validate($request, $rules);

        $qcm = Qcm::find($id);
        $qcm->titre = $request->get('titre-qcm');
        $qcm->description = $request->get('qcm-description');
        $qcm->description_admin = $request->get('qcm-description-admin');
        $qcm->save();

        $selectQuestions = [];
        $selectQuestions['new'] = 'AJOUTER UNE NOUVELLE QUESTION';
        $idx = 1;

        $questions = $qcm->questions()->get();

        foreach ($questions as $question) {
            $selectQuestions[$question->id] = 'QUESTION ' . $idx;
            $idx++;
        }

        $q = $questions->isEmpty() ? NULL : $questions[0];

        return view('admin.ateliers.qcm.editQuestion', ['question' => $q, 'selectQuestions' => $selectQuestions, 'qcm' => $qcm, 'id_exercice' => $id_exercice]);
    }

    public function getEditQuestions($id_exercice, $id) {

        $qcm = Qcm::find($id);

        $selectQuestions = [];
        $selectQuestions['new'] = 'AJOUTER UNE NOUVELLE QUESTION';
        $idx = 1;

        $questions = $qcm->questions()->get();

        foreach ($questions as $question) {
            $selectQuestions[$question->id] = 'QUESTION ' . $idx;
            $idx++;
        }

        $q = $questions->isEmpty() ? NULL : $questions[0];

        return view('admin.ateliers.qcm.editQuestion', ['question' => $q, 'selectQuestions' => $selectQuestions, 'qcm' => $qcm, 'id_exercice' => $id_exercice]);
    }

    public function getEditQuestionById($id_exercice, $id, $id_question) {
        $qcm = Qcm::find($id);

        $selectQuestions = [];
        $selectQuestions['new'] = 'AJOUTER UNE NOUVELLE QUESTION';
        $idx = 1;

        $questions = $qcm->questions()->get();

        foreach ($questions as $question) {
            $selectQuestions[$question->id] = 'QUESTION ' . $idx;
            $idx++;
        }

        $q = $id_question === 'new' ? NULL : Qcm_questions::find($id_question);

        return view('admin.ateliers.qcm.editQuestion', ['question' => $q, 'selectQuestions' => $selectQuestions, 'qcm' => $qcm, 'id_exercice' => $id_exercice]);
    }

    public function selectQuestion($id_exercice, $id, Request $request) {
        $rules = ['question-selected' => 'required|alpha_num'];

        $this->validate($request, $rules);

        return Redirect::route('admin::qcm::edit::questions::get::id', ['exercice_id' => $id_exercice, 'id' => $id, 'id_question' => $request->get('question-selected')]);
    }

    public function editQuestion($id_exercice, $id, $id_question, Request $request) {
        $rules = ['question-title' => 'required|regex:/^[a-zA-Z0-9À-ÖØ-öø-ÿ\s\':!?_]+$/', 'question-question' => 'required', 'question-answer' => 'required|array|min:1|max:1', 'question-answer.*' => 'required|array|min:2', 'question-answer.*.*' => 'required|array|min:1|max:1', 'question-answer.*.*.*' => 'required|regex:/^[a-zA-Z0-9À-ÖØ-öø-ÿ\s\':!?_]+$/', 'question-answer-boolean-' => 'required|array|min:1|max:1', 'question-answer-boolean-.*' => 'required|array|min:2', 'question-answer-boolran-.*.*' => 'required|array|min:1|max:1', 'question-answer-boolean-.*.*.*' => 'required|numeric|min:0|max:1'];

        $validator = Validator::make($request->request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::route('admin::qcm::edit::questions::get::id', ['exercice_id' => $id_exercice, 'id' => $id, 'id_question' => $id_question])->withErrors($validator)->withInput();
        }

        $qcm = Qcm::find($id);
        $question = Qcm_questions::find($id_question);
        $question->titre = $request->get('question-title');
        $question->question = $request->get('question-question');

        if ($question->save()) {
            foreach ($request->get('question-answer')[$question->id] as $key => $val) {
                foreach ($val as $id_answer => $title) {
                    $answer = Qcm_answers::where('id', '=', $id_answer)->where('qcm_id', '=', $qcm->id)->where('qcm_questions_id', '=', $question->id)->get();
                    if ($answer->isEmpty()) {
                        $answer = new Qcm_answers();
                    } else {
                        $answer = $answer[0];
                    }
                    $answer->qcm_id = $qcm->id;
                    $answer->qcm_questions_id = $question->id;
                    $answer->answer_title = $title;
                    $answer->answer_boolean = boolval($request->get('question-answer-boolean-')[$id_question][$key][$id_answer]);
                    $answer->save();
                }
            }
        }

        return Redirect::route('admin::qcm::edit::questions::get::id', ['exercice_id' => $id_exercice, 'id' => $id, 'id_question' => $id_question]);
    }

    public function newQuestion($id_exercice, $id, Request $request) {
        $rules = ['question-title' => 'required|regex:/^[a-zA-Z0-9À-ÖØ-öø-ÿ\s\':!?_]+$/', 'question-question' => 'required', 'question-answer' => 'required|array|min:1|max:1', 'question-answer.*' => 'required|array|min:2', 'question-answer.*.*' => 'required|array|min:1|max:1', 'question-answer.*.*.*' => 'required|regex:/^[a-zA-Z0-9À-ÖØ-öø-ÿ\s\':!?_]+$/', 'question-answer-boolean-' => 'required|array|min:1|max:1', 'question-answer-boolean-.*' => 'required|array|min:2', 'question-answer-boolran-.*.*' => 'required|array|min:1|max:1', 'question-answer-boolean-.*.*.*' => 'required|numeric|min:0|max:1'];
        $validator = Validator::make($request->request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::route('admin::qcm::edit::questions::get', ['exercice_id' => $id_exercice, 'id' => $id])->withErrors($validator)->withInput();
        }

        $qcm = Qcm::find($id);

        $question = new Qcm_questions();
        $question->qcm_id = $qcm->id;
        $question->titre = $request->get('question-title');
        $question->question = $request->get('question-question');

        if ($question->save()) {
            foreach ($request->get('question-answer')['new'] as $key => $val) {
                $answer = new Qcm_answers;
                $answer->qcm_id = $qcm->id;
                $answer->qcm_questions_id = $question->id;
                $answer->answer_title = $request->get('question-answer')['new'][$key]['new'];
                $answer->answer_boolean = boolval($request->get('question-answer-boolean-')['new'][$key]['new']);
                $answer->save();
            }
        }

        return Redirect::route('admin::qcm::edit::questions::get::id', ['exercice_id' => $id_exercice, 'id' => $id, 'id_question' => $question->id]);
    }

    public function deleteAnswer($id_exercice, $id, $id_question, $id_answer, Request $request) {

        $answer = Qcm_answers::find($id_answer);
        $answer->delete();

        return Response::json(['id_exercice' => $id_exercice, 'id' => $id, 'id_question' => $id_question]);
    }

    public function deleteQuestion($id_exercice, $id, $id_question, Request $request) {

        $question = Qcm_questions::find($id_question);

        foreach ($question->answers()->get() as $answer) {
            $answer->delete();
        }

        $question->delete();

        return Redirect::route('admin::qcm::edit::questions::get', ['exercice_id' => $id_exercice, 'id' => $id]);
    }

    public function importQcm($id_exercice, $id, Request $request) {
        $reader = null;
        $rules = ['qcm-file' => 'required|file|mimes:ods,csv,xls,xlsx'];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return Redirect::route('admin::qcm::edit::questions::get', ['exercice_id' => $id_exercice, 'id' => $id])->withErrors($validator);
        }

        switch ($request->file('qcm-file')->getClientOriginalExtension()) {
            case 'xls':
                $reader = new PhpSpreadsheet\Reader\Xls();
                break;
            case 'xlsx':
                $reader = new PhpSpreadsheet\Reader\Xlsx();
                break;
            case 'csv':
                $reader = new PhpSpreadsheet\Reader\Csv();
                break;
            case 'ods':
                $reader = new PhpSpreadsheet\Reader\Ods();
                break;
        }

        $reader->setReadDataOnly(TRUE);
        $spreadsheet = $reader->load($request->file('qcm-file'));
        $worksheet = $spreadsheet->getActiveSheet()->toArray();
        $spreadsheet->disconnectWorksheets();
        unset($spreadsheet);

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

        function convert_boolean($str) {
            $out = filter_var(strtolower($str), FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if (is_null($out)) {
                if (in_array(strtolower($str), ['vrai', 'oui', 'v', 'o'])) {
                    $out = TRUE;
                } else {
                    $out = FALSE;
                }
            }

            return $out;
        }
        
        $qcm = Qcm::find($id);

        foreach ($data as $question) {
            $qcm_question = new Qcm_questions();
            $qcm_question->qcm_id = $qcm->id;
            $qcm_question->titre = $question['titre'];
            $qcm_question->question = $question['question'];
            if ($qcm_question->save()) {
                foreach ($question['answers'] as $answer) {
                    $qcm_answer = new Qcm_answers();
                    $qcm_answer->qcm_id = $qcm->id;
                    $qcm_answer->qcm_questions_id = $qcm_question->id;
                    $qcm_answer->answer_title = $answer['answer_title'];
                    $qcm_answer->answer_boolean = convert_boolean($answer['answer_boolean']);
                    $qcm_answer->save();
                }
            }
            
        }
        
        return Redirect::route('admin::qcm::edit::questions::get', ['exercice_id' => $id_exercice, 'id' => $id]);
    }

    public function exportQcm($id_exercice, $id, Request $request) {
        $spreadsheet = new PhpSpreadsheet\Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        
        $qcm = Qcm::find($id);
        $questions = $qcm->questions()->get();
        $cell = 1;
        
        foreach($questions as $question) {
            $nb_answer = $question->answers()->count();
            $sheet->mergeCells('A' . $cell . ':A' . ($cell + ($nb_answer - 1)));
            $sheet->setCellValue('A' . $cell, $question->titre);
            $sheet->mergeCells('B'.$cell . ':B' . ($cell + ($nb_answer - 1)));
            $sheet->setCellValue('B' . $cell, $question->question);            
            
            foreach ($question->answers()->get() as $answer) {
                $sheet->setCellValue('C' . $cell, $answer->answer_title);
                $sheet->setCellValue('D' . $cell, $answer->answer_boolean === 1 ? 'VRAI' : 'FAUX');
                $cell++;
            }
            
            $cell++;
        }
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="geovisit_qcm_export_' . gmdate('YmdHis') . '.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer = PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->setPreCalculateFormulas(false);
        ob_end_clean();
        $writer->save('php://output');  
        exit();
        
    }

}
