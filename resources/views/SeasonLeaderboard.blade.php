@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card custom-card">
            <div class="card-body result-style">
                <h5 class="card-title text-center text-white">Leaderboard season {{ \Carbon\Carbon::now()->year }}</h5>
                <div class="table-responsive mt-3">
                    <table class="table table-hover table-bordered table-striped table-dark">
                        <thead>
                        <tr>
                            <th scope="col" class="col-sm">#</th>
                            <th scope="col">Naam</th>
                            <th scope="col">Punten</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($leaderboard as $userName => $points)
                            <tr>
                                <th scope="row"> {{$loop->index + 1}}</th>
                                <td>{{ $userName}}</td>
                                <td>{{ $points }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
