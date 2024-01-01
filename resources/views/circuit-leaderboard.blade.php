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
                    <tr>
                        <th scope="row">1</th>
                        <td>Rick</td>
                        <td>1.21.235</td>
                        <td>25</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>1.22.373</td>
                        <td>18</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>henk</td>
                        <td>1.27.675</td>
                        <td>15</td>
                    </tr>
                    <tr>
                        <th scope="row">4</th>
                        <td>paul</td>
                        <td>1.33.435</td>
                        <td>13</td>
                    </tr>
                    <tr>
                        <th scope="row">5</th>
                        <td>bert</td>
                        <td>1.47.374</td>
                        <td>11</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
