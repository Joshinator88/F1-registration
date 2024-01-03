@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <body>

    <div class="container">
        <div class="row justify-content-center">

            @foreach($races as $race)

                <div class="col-sm-8 col-md-8 col-lg-4 mb-3">
                    <div class="card">
                        <div class="card-header text-center">
                            {{$race->circuit}}
                            @if($race->isActive())
                                <br class=""> Upload je tijd voor deze race!</br>
                            @endif
                        </div>
                        <a href="{{route('races-id', $race->id)}}">
                            <div class="card-body">
                                <img class="card-img-top img-fluid"
                                     src="{{ asset('racePictures/'.$race->circuit.'.png') }}"
                                     alt="Card image cap">
                            </div>
                        </a>
                    </div>
                </div>
    @endforeach

    </body>
@endsection
