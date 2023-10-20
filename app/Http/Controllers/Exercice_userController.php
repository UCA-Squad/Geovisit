<?php namespace App\Http\Controllers;
use Response;
use Illuminate\Http\Request;
use Auth;
use App\Models\Exercice_user;
class Exercice_userController extends Controller {

  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
  public function index()
  {
       // return Response::json(['id'=>'g']);

  }

  /**
   * Show the form for creating a new resource.
   *
   * @return Response
   */
  public function create()
  {
    
  }

  /**
   * Store a newly created resource in storage.
   *
   * @return Response
   */
  public function store(Request $request)
  {
    $realise = Exercice_user::firstOrNew([
        'user_id' => Auth::user()->userable_id, 
        'exercice_id' => $request->input('exercice')
    ]);
    $realise->user_id = Auth::user()->userable_id;
    $realise->exercice_id = $request->input('exercice');
    if ($realise->exists) {
        $isNew = FALSE;
        $realise->touch();
    } else {
        $isNew = TRUE;
    }
    $realise->save();
    
    return Response::json(['id'=>$realise->id, 'new' => $isNew]);
    
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function show($id)
  {
    
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function edit($id)
  {
    
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function update($id)
  {
    
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return Response
   */
  public function destroy($id)
  {
    
  }
  
}

?>