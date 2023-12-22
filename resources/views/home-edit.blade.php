@extends('layouts.app')

@section('content')

<?php  ?>
<!-- form waar de gebruiker zijn naam, favoriete circuit, geboorte datum en bio kan aanpassen -->
<div class="container">
  <form method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
      <label for="profilePicture" class="form-label">upload hier uw profielfoto:</label>
      <input type="file" class="form-control" name="profilePicture" id="profilePicture">
    </div>
    

    <!-- the User can change its email here but the email that is known in the db is filled in allready -->
    <div class="mb-3">
      <label for="newName" class="form-label">Naam</label>
      <input type="text" class="form-control" name="newName" id="newName" value="{{ $user->name }}">
    </div>

    <div class="mb-3">
      <label for="newFavCircuit" class="form-label">Favoriete circuit</label>
      <input type="text" class="form-control" name="newFavCircuit" id="newFavCircuit" value="{{$user->profile->favorite_circuit}}">
    </div>

    <div class="mb-3">
      <label for="newDateOfBirth" class="form-label">Geboorte datum</label>
      <input type="date" class="form-control" name="newDateOfBirth" id="newDateOfBirth" value="{{$user->profile->birth_date}}">
    </div>

    <div class="mb-3">
      <label for="newBio">Biografie</label>
      <textarea class="form-control" placeholder="Biografie" name="newBio" id="newBio" style="height: 100px">{{ $user->profile->bio}}</textarea>
    </div>

    <div class="mb-3 row text-center">
      <input type="submit" class="btn btn-success col-md-5 col-sm-12 m-auto mb-3" name="saveButton" id="saveButton" value="Save">
      <input type="submit" class="btn btn-danger col-md-5 col-sm-12 m-auto mb-3" name="quitButton" id="quitButton" value="ga terug naar home">
    </div>
    
  </form> 

</div>


@endsection