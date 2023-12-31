@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <div class="container">
        <div class="row justify-content-center">
            @foreach($races as $race)
                @if($race->isActive())
                    <div class="col-sm-8 col-md-8 col-lg-4 mb-3 mt-3">
                        <div class="card">
                            <div class="card-header text-center">
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
            @foreach($races as $race)
                @if(!$race->isActive())
                    <div class="col-sm-8 col-md-8 col-lg-4 mb-3">
                        <div class="card">
                            <div class="card-header text-center">
                                {{$race->circuit}}
                            </div>
                            <a href="{{route('races-id', $race->id)}}">
                                <div class="card-body" style="height: 340px; overflow: hidden;">
                                    <img class="card-img-top"
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
