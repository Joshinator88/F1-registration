@extends ('layouts.app')

@section('content')
<!-- here we made an arcordion button which is containing all the ended races-->
<div class="container">
  <div class="accordion m-2" id="accordionOne">
    <div class="accordion-item">
      <h2 class="accordion-header" id="headingOne">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Troffeeën vergeven
        </button>
      </h2>
      <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
        <div class="accordion-body">
          <!-- here we map over all the ended races give each race 2 buttons, one for deleting and one for adding the trophies to that race -->
          @forelse ($races as $race)
            <form action="/addTrophies" class="inline" method="post">
              @csrf
              <div class="row text-center my-3">
                <label for="{{$race->circuit}}" class="col-sm-3">{{$race->circuit}}</label>
                <input name="giveTrophies" value="troffeeën uitdelen" type="submit" class="btn btn-success col-sm-3 m-auto">
                <input name="removeTrophies" value="Troffeeën verwijderen" type="submit" class="btn btn-danger col-sm-3 m-auto">
                <!-- we send the race_id allong to delete update or create the trophies for this race -->
                <input type="hidden" name="raceId" value="{{ $race->id }}">
              </div>
            </form>
            <!-- when there are no races ended w will show the following -->
            @empty
            <h2>Er zijn nog geen races afgelopen dus er kunnen nog geen troffeeën worden uitgedeelt</h2>
          @endforelse
        </div>
      </div>
    </div>
  </div>

<!-- when there are raceresults that need to be validated they will get stored in their own accordion -->
    @forelse($raceResults as $raceResult)
        <div class="accordion mx-2" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="{{ $raceResult->id }}">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapse{{ $raceResult->id }}" aria-expanded="true"
                            aria-controls="collapse{{ $raceResult->id }}">
                        Race: {{ $raceResult->race->circuit }}
                        | User: {{ $raceResult->user->name }}
                    </button>
                </h2>

                <div id="collapse{{ $raceResult->id }}" class="accordion-collapse collapse"
                     aria-labelledby="heading{{ $raceResult->id }}" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="row justify-content-around text-center">
                            <img src="{{ '/controlPictures/' . $raceResult->picture_name }}"
                                 class="col-10 col-sm-4 col-xl-1 mb-2"
                                 alt="...">
                            <div class="row col-12 col-sm-4">
                                <p class="col-4  col-sm-2 m-auto justify-content-center">
                                    User: {{ $raceResult->user->name }}</p>
                                <p class="col-4  col-sm-2 m-auto justify-content-center">{{ $raceResult->race->circuit }}</p>
                                <!-- calculation to display the time result of the user in minutes, seconds en thousands -->
                                <p class="col-4  col-sm-2 m-auto justify-content-center">{{ floor($raceResult->seconds/60) . ':' . $raceResult->seconds%60 . '.' . $raceResult->seconds*1000%1000 }}</p>
                                <form method="post" class="">
                                    @csrf
                                    <input class="btn btn-success col-10 mb-2" type="submit" name="goedgekeurd"
                                           value="goedgekeurd">
                                    <input class="btn btn-danger col-10 mt-2" type="submit" name="afgekeurd"
                                           value="afgekeurd">
                                    <input type="hidden" name="id" value="{{ $raceResult->id }}">
                                    <input type="hidden" name="picture_name" value="{{ $raceResult->picture_name }}">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <h1 class="mx-3">Er zijn nog geen resultaten geupload!</h1>

    @endforelse
</div>
@endsection
