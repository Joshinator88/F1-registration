@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <div class="container bg-white">
        <div class="row justify-content-center">
            <!-- here we loop over all races to search for the active race -->
            @foreach($races as $race)
            <!-- when the race is active then it gets placed at the top of the page and be centered -->
                @if($race->isActive())
                    <div class="col-sm-8 col-md-8 col-lg-4 mb-3 mt-3">
                        <div class="card card-races">
                            <div class="card-header text-center text-white">
                                {{$race->circuit}}
                            </div>
                            <a href="{{route('races-id', $race->id)}}">
                                <div class="card-body">
                                    <img class="card-img-top img-fluid"
                                         src="{{ asset('racePictures/'.$race->circuit.'.png') }}"
                                         alt="Card image cap"/>
                                </div>
                            </a>
                        </div>
                    </div>
                    <hr/>
                @endif
                {{-- stop the loop if the active card has been shown --}}
                @break
            @endforeach
        </div>
        <div class="row justify-content-center">
            <!-- I will loop over the races agaain to displai the rest of them -->
            @foreach($races as $race)
            <!-- adding a constraint to make shure the active race won't be displayed twice -->
                @if(!$race->isActive())
                    <div class="col-sm-8 col-md-8 col-lg-4 mb-3">
                        <div class="card card-races">
                            <div class="card-header text-center text-white">
                                {{$race->circuit}}
                            </div>
                            <a href="{{route('races-id', $race->id)}}">
                                <div class="card-body">
                                    <img class="card-img-top object-fit-contain border rounded"
                                         src="{{ asset('racePictures/'.$race->circuit.'.png') }}"
                                         alt="Card image cap"/>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
