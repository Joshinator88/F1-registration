@extends('layouts.app')

@section('content')

<!-- form waar de gebruiker zijn naam, favoriete circuit, geboorte datum en bio kan aanpassen -->
<?php var_dump($ogExtension); ?>
<form method="post" enctype="multipart/form-data">
    @csrf
  <label for="profilePicture">upload hier uw profielfoto:</label>
  <input type="file" name="profilePicture" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form> 


@endsection