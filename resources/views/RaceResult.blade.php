@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body result-style">
                <h5 class="card-title text-center text-white">Leaderboard {{$race->circuit}}</h5>
                <div class="table-responsive mt-3">
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
                        <!-- looping over the top ten results of this circuit -->
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
        <!-- here i create the canvas where where the chart will be written on -->
        <canvas id="myChart">

        </canvas>
        <!-- for the graphs we used the library chart.js wich we imported here via a cdn -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // I know that there is an error here but I could not make it work otherwise
            // wI store the json in string fomat in a variable called string an store the parsed data in the objects variable
            let string = [].concat(@json($raceResultsUser));
            let objects = JSON.parse(string);
            // here I created two arrays, I need the times for the y axis and the datse for the ax axis
            let times = [];
            let dates = [];
            // i loop over the array with json objects and assign the values to the times and dates arrays respectivly
            objects.forEach((object) => {
                times.push(object['seconds'])
                dates.push(object['created_at'].substring(0, 9))
            });
            
            const chart = document.getElementById('myChart');

            // create a new instance of a chart
            new Chart(chart, {
                type: 'line',
                data: {
                // labels are placed around the x axis, here I want to put my dates
                labels: dates,
                datasets: [{
                    // when you hover over a certain point in the graph you see: 'label: time', so i wanted the label to be the following
                    label: 'performance in seconds',
                    // here you pass in an array so i passed the times array
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
