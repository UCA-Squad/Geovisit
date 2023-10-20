<?php namespace App\Http\Controllers;
use App\Repositories\UserRepository;
class UserController extends Controller {
protected $userRepository;
  /**
   * Display a listing of the resource.
   *
   * @return Response
   */
public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

  public function index()
  {
    
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
  public function store()
  {
    
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

  	public function update(UserUpdateRequest $request, $id)
	{
		//$this->setAdmin($request);

		$this->userRepository->update($id, $request->all());

		//return redirect('user')->withOk("L'utilisateur " . $request->input('name') . " a été modifié.");
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