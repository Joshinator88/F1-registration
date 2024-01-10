@extends ('layouts.app')

@section('content')
    <div class="accordion mx-2" id="accordionExample">
    @forelse($raceResults as $raceResult)
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
                            <img src="{{ asset('storage/raceResultProof/'.$raceResult->id.'.jpg') }}" class="col-10 col-sm-4 col-xl-1 mb-2"
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
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    @empty
        <h1>Er zijn nog geen resultaten geupload!</h1>
    @endforelse
    </div>

@endsection
