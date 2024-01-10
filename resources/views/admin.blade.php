@extends ('layouts.app')

@section('content')

@foreach($results as $result)

<div class="accordion mx-2" id="accordionExample">

  <div class="accordion-item">
    <h2 class="accordion-header" id="{{ $result->id }}">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $result->id }}" aria-expanded="true" aria-controls="collapse{{ $result->id }}">
        Result: {{ $result->id }}
      </button>
    </h2>
    <div id="collapse{{ $result->id }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $result->id }}" data-bs-parent="#accordionExample">
      <div class="accordion-body">
        <div class="row justify-content-around text-center">
          <img src="/controlePictures/controlePicture.jpeg" class="col-10 col-sm-4 col-xl-1 mb-2" alt="...">
          <div class="row col-12 col-sm-8">
            <p class="col-4  col-sm-2 m-auto justify-content-center">User: {{ $result->user_id }}</p>
            <p class="col-4  col-sm-2 m-auto justify-content-center">{{ $result->race->circuit }}</p>
            <!-- calculation to display the time result of the user in minutes, seconds en thousands -->
            <p class="col-4  col-sm-2 m-auto justify-content-center">{{ floor($result->seconds/60) . ':' . $result->seconds%60 . '.' . $result->seconds*1000%1000 }}</p>
            <form method="post" class="">
              @csrf
              <input class="btn btn-success col-10 mb-2" type="submit" name="goedgekeurd" value="goedgekeurd">
              <input class="btn btn-danger col-10 mt-2" type="submit" name="afgekeurd" value="afgekeurd">
              <input type="hidden" name="id" value="{{ $result->id }}">
              <input type="hidden" name="race_id" value="{{ $result->race->id }}">
            </form>
          </div>


        </div>
      </div>
    </div>
  </div>


</div>

@endforeach


@endsection
