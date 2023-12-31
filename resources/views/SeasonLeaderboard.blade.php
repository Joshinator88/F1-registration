@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card custom-card">
            <div class="card-body">
                <h5 class="card-title text-center">Leaderboard season 2024</h5>
                <div class="table-responsive">
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
                                <th scope="row"> {{$loop->index}}</th>
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
