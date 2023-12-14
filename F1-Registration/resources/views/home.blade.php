<!-- this is the navbar of the pages -->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="justify-content-center">
            <img src="profileImages/opdebootmetsha.jpeg" class="img-fluid col-12" alt="profile picture of {{ Auth::user()->name }}">
        
<div class="container mt-2">
    <div class="row m-auto ">
        <!-- displays the name of the user -->
        <h3 class="col-8 m-auto">{{ Auth::user()->name }}</h3>
        <!-- this button is to turn on edit mode and makes the user able to change certain information displayed on the profile page,
    this also enables the save button -->
        <button type="button" class="btn btn-success btn-sm col-4">Edit</button>
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
                          2800000000
                        </div>
                </div>
            </li>

            <li class="list-group-item">
                    <div class="row">
                        <div class="col">
                            Punten
                        </div>
                        <div class="col">
                          820000000
                        </div>
                </div>
            </li>

            <li class="list-group-item">
                    <div class="row">
                        <div class="col">
                            Favoriete circuit
                        </div>
                        <div class="col">
                          peaches garden
                        </div>
                </div>
            </li>

            <li class="list-group-item">
                    <div class="row">
                        <div class="col">
                            Highest finnish
                        </div>
                        <div class="col">
                          1st
                        </div>
                </div>
            </li>

            <li class="list-group-item">
                    <div class="row">
                        <div class="col">
                            Date of birth
                        </div>
                        <div class="col">
                          02/11/1999
                        </div>
                </div>
            </li>

            <!-- this listitem is differen then the others because it is on seperate lines.
        this is on 2 lines so that there is more room for the Bio -->
            <li class="list-group-item">
                    
                        <div class="row text-center">
                          <h5>Bio</h5>
                        </div>
                        <div class="row text-center">
                          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Harum culpa soluta nemo, nihil, consequuntur alias ipsa maxime dicta dolores et cum necessitatibus. Minus dignissimos perspiciatis voluptas neque dolorem adipisci odit?</p>
                        </div>
                </div>
            </li>

            <!-- when edit mode is turned on and items are changed then the save button is enabled and can be used to update the old data with the new data -->
            <li class="list-group-item">
                <div class="row text-center">
                    <button type="button" class="btn btn-success" disabled>Save</button>
                </div>
            </li>

        </ul>
    </div>
</div>
@endsection
