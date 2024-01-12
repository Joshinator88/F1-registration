<!-- the navbar of the file -->
@extends('layouts.app')

@section('content')
<!-- the if statements are to display an error when there is one the error wont exist and so would not interfere with the styling -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    @if (isset($error))
        <div class="alert alert-danger text-center" role="alert">
            {{ $error }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
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
                    <input type="number" class="form-control" min="0" max="999" name="thousands">
                </div>

            </div>

        </div>

        <div class="mb-3">
            <!-- a file input field where the user can upload a proof image, the div underneath will 
            discribe where the user have to pay attention to when taking the picture -->
            <label for="controlPicture" class="form-label">Als bewijs, upload hier een selfie met uw resultaten</label>
            <input type="file" class="form-control" name="controlePicture" id="controlePicture" aria-describedby="pictureHelp" required>
            <div id="pictureHelp" class="form-text">Zorg er voor dat jij zelf, de track en je tijd duidelijk zichtbaar
                zijn op de foto en dat de foto een portrait foto is
            </div>
        </div>
        <div class="text-center">
            <input type="submit" name="submit" class="btn uploadRaceButton col-10 col-md-6 text-center text-white" id="submit"
                   value="Opslaan">
        </div>

    </form>

@endsection
