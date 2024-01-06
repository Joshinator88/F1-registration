@extends ('layouts.app')
<link rel="stylesheet" href="{{asset('css/app.css')}}">

@section ('content')

<div class="container">
    <div class="row justify-content-center">


@foreach($users as $user)

<?php 
// here we defined the path to the specific user his profile picture 
$path = '/profilePictures/' . $user->id . 'profile.' . $user->profile?->profile_picture;
?>

    <div class="col-sm-8 col-lg-4 mb-3">
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