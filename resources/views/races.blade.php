@extends('layouts.app')

@section('content')
    <body>

    <div class="container">
        <div class="row justify-content-center">

            @foreach($races as $race)
            <div class="col-sm-8 col-md-8 col-lg-4 mb-3">
                <div class="card">
                    <div class="card-header text-center">
                  {{$race->circuit}}
                    </div>
                    <a href="{{route('races-id', $race->id)}}">
                        <div class="card-body">
                            <img class="card-img-top img-fluid" src="{{ asset('racePictures/'.$race->circuit.'.png') }}"
                                 alt="Card image cap">
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
{{--            <div class="col-sm-8 col-md-8 col-lg-4 mb-3">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header text-center">--}}
{{--                        Saudi Arabia--}}
{{--                    </div>--}}
{{--                    <a href="{{route('circuit-leaderboard')}}">--}}
{{--                        <div class="card-body">--}}
{{--                            <img class="card-img-top img-fluid" src="{{ asset('racePictures/saudi_arabia.png') }}"--}}
{{--                                 alt="Card image cap">--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col-sm-8 col-md-8 col-lg-4 mb-3">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header text-center">--}}
{{--                        Australia--}}
{{--                    </div>--}}
{{--                    <a href="{{route('circuit-leaderboard')}}">--}}
{{--                        <div class="card-body">--}}
{{--                            <img class="card-img-top img-fluid" src="{{ asset('racePictures/australia.png') }}"--}}
{{--                                 alt="Card image cap">--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

    </body>
@endsection
