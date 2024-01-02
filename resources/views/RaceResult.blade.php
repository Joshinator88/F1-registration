@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card custom-card">
            <div class="card-body">
                <h5 class="card-title text-center">Race Results abu dhabi</h5>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped table-dark">
                        <thead>
                        <tr>
                            <th scope="col" class="col-sm">#</th>
                            <th scope="col">Naam</th>
                            <th scope="col">Ronde tijd</th>
                            <th scope="col">Punten</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($raceResults as $key => $result)
                            <tr>
                                <th scope="row">{{$key +1}}</th>
                                <td>{{ $result->user->name}}</td>
                                <td>{{ $result->seconds}}</td>
                                <td>{{ $result->points }}</td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
