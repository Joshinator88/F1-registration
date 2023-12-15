@extends('layouts.app')

@section('content')

<!-- form waar de gebruiker zijn naam, favoriete circuit, geboorte datum en bio kan aanpassen -->

<form method="post" enctype="multipart/form-data">
    @csrf
  Select image to upload:
  <input type="file" name="profilePicture" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form> 


@endsection