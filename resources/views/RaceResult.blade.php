@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card custom-card">
            <div class="card-body">
                <h5 class="card-title text-center">Leaderboard {{$race->circuit}}</h5>
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
    <div class="container">
        <canvas id="myChart">

        </canvas>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            let string = [].concat(@json($raceResultsUser));
            let objects = JSON.parse(string);
            let times = [];
            let dates = [];
            objects.forEach((object) => {
                times.push(object['seconds'])
                dates.push(object['created_at'].substring(0, 9))
            });
            const chart = document.getElementById('myChart');

            new Chart(chart, {
                type: 'line',
                data: {
                labels: dates,
                datasets: [{
                    label: 'performance in seconds',
                    data: times,
                    borderWidth: 1
                }]
                },
                options: {
                scales: {
                    y: {
                    beginAtZero: true
                    }
                }
                }
        });

        </script>
    </div>
@endsection
