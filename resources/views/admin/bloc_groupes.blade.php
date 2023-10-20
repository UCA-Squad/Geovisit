						@if(count($groupes) > 0)	
						 @foreach ($groupes as $groupe)
						<div class="panel-group">
    <div class="panel" id="paneladmin2">
      <div class="panel-heading">
        <h4 class="panel-title">
         <span style="width:300px;display: inline-block;">Groupe {{$groupe->titre}} </span>|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nb d’étudiant : {{$groupe->etudiants()->count()}}
    <a data-toggle="collapse" href="#collapse2{{$groupe->id}}"> <img src="{{URL::asset('img/show.png') }}" style="float:right;"/></a> <img src="{{URL::asset('img/corbeille.png') }}" style="float:right;margin-right:40px;cursor:pointer" data-toggle="confirmation" data-btn-ok-label="Oui" data-btn-cancel-label="Non!" title="Voulez-vous détacher ce groupe?" data-href="{{$groupe->id}}"/></h4>
      </div>
      <div id="collapse2{{$groupe->id}}" class="panel-collapse collapse {{ (session('affich')==$groupe->id) ? ' in' : ''}}">
        <div class="panel-body">
		@if($groupe->etudiants()->count() > 0)
				<table class="etudiant"> <tr>
  
    <th>N° D’ETUDIANT</th>
    <th>NOM</th>		
    <th>PRENOM</th>
		<th>CONTACT</th>
		
  </tr>
				
				 @foreach ($groupe->etudiants()->get() as $etudiant)
						 
						  @foreach ($etudiant->user()->get() as $etudiantdetail)
						 <tr><td>{{$etudiantdetail->username}}</td><td>{{$etudiantdetail->nom}}</td><td>{{$etudiantdetail->prenom}}</td><td>{{$etudiantdetail->email}}</td></tr>
						@endforeach
				 @endforeach
				 </table>
		@endif
				
		</div>
      </div>
    </div>
  </div>
	 @endforeach
 @else
	 Vous n'avez aucun groupe!
@endif