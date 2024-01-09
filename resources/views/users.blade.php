@extends ('layouts.app')
<link rel="stylesheet" href="{{asset('css/app.css')}}">


@section ('content')
    <div class="container">
        <form class="form-inline" method="get" action="/search">
            @csrf
            <div class="row">
                <div class="col-sm-10">
                    <input class="form-control inline mr-sm-2" type="search" name="search" placeholder="Search"
                           aria-label="Search">
                </div>
                <button class="col btn btn-outline-success m-2 my-sm-0" type="submit">Search</button>
            </div>
        </form>
    </div>

    <div class="container">

        <div class="row red justify-content-center">

            @foreach($users as $user)

                    <?php
// here we defined the path to the specific user his profile picture
                    $path = '/profilePictures/' . $user->id . 'profile.' . $user->profile?->profile_picture;
                    ?>

                <div class="col-sm-8 col-lg-4 my-2">
                    <a class="no-style" href="/user/{{ $user->id }}">
                        <div class="card">

                            @if ($user->profile?->profile_picture !== NULL)
                                <img class="card-img-top" src="{{ $path }}" alt="profile picture of {{ $user->email }}">
                            @else
                                <img src="/profilePictures/noPicture.png" alt="profile picture of {{ $user->email }}">
                            @endif

                            <div class="card-body">
                                <h3 class="card-title">{{ $user->name }}</h3>
                                <p class="card-text">{{ $user->profile?->bio }}</p>
                            </div>

                        </div>
                    </a>

                </div>

            @endforeach
        </div>
    </div>

@endsection
