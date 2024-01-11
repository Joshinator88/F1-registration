<!-- this is the navbar of the pages -->
@extends('layouts.app')

@section('content')
<?php 
// here we defined the path to the specific user his profile picture 
$path = '/profilePictures/' . $user->id . 'profile.' . $user->profile?->profile_picture;
?>

<div class="container">
    <div class="justify-content-center text-center maxheight-220">
        @if ($user->profile?->profile_picture !== NULL)
        <img class="img-fluid" src="{{ $path }}" alt="profile picture of {{ $user->email }}">
        @else 
        <img class="img-fluid" src="/profilePictures/noPicture.png" alt="profile picture of {{ $user->email }}">
        @endif
    </div>        
    <div class="container mt-4">
        <div class="row mt-2">
            <!-- displays the name of the user -->
            <h3 class="mr-auto col-md-4">{{ $user->name }}</h3>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-dark m-auto col-md-4" data-bs-toggle="modal" data-bs-target="#trophies">
            Bekijk trofeeën
            </button>

            <!-- Modal to show all the trophies of this user -->
            <div class="modal fade" id="trophies" tabindex="-1" aria-labelledby="trophiesLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="trophiesLabel">Trofeeën</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @forelse ($trophies as $trophy)
                            <h1>{{$trophy->trophy}} {{$trophy->race->circuit}}</h1>
                            @empty
                            <h1>Nog geen trofeeën verdient...</h1>

                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- the ul is a list with information about the user -->
<!-- these classes add margin to the top of the list and uses the bootstrap list-group(-flush) 
class to make list that we needed for our design -->
        <ul class="mt-2 list-group list-group-flush">

        <!-- each listgroupitem consists of 2 columns, col 1 is to clearify what data is shown on that row,
    and col 2 is to display the value of that data with the current user -->
            <li class="list-group-item">
                    <div class="row">
                        <div class="col">
                            Followers
                        </div>
                        <div class="col">
                          {{$user->profile?->followersCount}}
                        </div>
                </div>
            </li>

            <li class="list-group-item">
                    <div class="row">
                        <div class="col">
                            Punten
                        </div>
                        <div class="col">
                          {{ $user->points }}
                        </div>
                </div>
            </li>

            <li class="list-group-item">
                    <div class="row">
                        <div class="col">
                            Favoriete circuit
                        </div>
                        <div class="col">
                          {{ $user->profile?->favorite_circuit }}
                        </div>
                </div>
            </li>

            <li class="list-group-item">
                    <div class="row">
                        <div class="col">
                            Best finnish
                        </div>
                        <div class="col">
                          {{ $user->profile?->best_finnish }}
                        </div>
                </div>
            </li>

            <li class="list-group-item">
                    <div class="row">
                        <div class="col">
                            Date of birth
                        </div>
                        <div class="col">
                          {{ $user->profile?->birth_date }}
                        </div>
                </div>
            </li>

            <!-- this listitem is differen then the others because it is on seperate lines.
        this is on 2 lines so that there is more room for the Bio -->
            <li class="list-group-item">
                    
                        <div class="row text-center">
                          <h5>Bio</h5>
                        </div>
                        <div class="row text-center border">
                            <p>
                                {{ $user->profile?->bio }}
                            </p>
                        </div>
                </div>
            </li>

            

        </ul>
    </div>
</div>
@endsection
