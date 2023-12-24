<!-- the navbar of the file -->
@extends('layouts.app')

@section('content')
@if (isset($error))
<div class="alert alert-danger text-center" role="alert">
  {{ $error }}
</div>

@endif

<form class="p-3 m-auto col-10 col-lg-8 shadow-lg border-lg" method="post" enctype="multipart/form-data">
    @csrf
    <!-- hier komt de naam van de huidige race -->
    <h3 class="title text-center">Upload een tijd voor: {{ $race->circuit }}</h3> 
    <div class="mb-3">
      <div class="row">

        <input type="hidden" name="race_id" value="{{ $race->id }}">

        <div class="col-sm">
            <label for="minutes" class="form-label ms-1">Minuten: </label>
            <input type="number" name="minutes" class="form-control" min="0" max="59">
        </div>

        <div class="col-sm">
            <label for="seconds" class="form-label ms-1">Seconden: </label>
            <input type="number" name="seconds" class="form-control" min="0" max="59">
        </div>

        <div class="col-sm">
            <label for="thousands" class="form-label ms-1">Mili seconden: </label>
            <input type="number" class="form-control" min="0" max="9999" name="thousands">
        </div>
        
      </div>
        
    </div>
    
    <div class="mb-3">
    <!-- een file input field waar een user een bewijs foto kan uploaden, 
    de div onderin beschrijft waar de user op moet letten bij het maken van de foto  -->
      <label for="controlPicture" class="form-label">Als bewijs, upload hier een selfie met uw resultaten</label>
      <input type="file" class="form-control" name="controlPicture" id="controlPicture" aria-describedby="pictureHelp" required>
      <div id="pictureHelp" class="form-text">Zorg er voor dat jij zelf, de track en je tijd duidelijk zichtbaar zijn op de foto</div>
    </div>
    <div class="text-center">
        <input type="submit" name="submit" class="btn btn-primary col-10 col-md-6 text-center" id="submit" value="Opslaan">
    </div>
    
</form>


@endsection
