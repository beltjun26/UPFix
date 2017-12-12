@extends('layouts.app')

@section('header')
<style media="screen">
  div > img{
    width: 250px;
    height: 250px;
  }
  p{
      font-size: 20px;
  }
</style>
@endsection

@section('content')
<div class="container">
  <div class="row">
    <div class="text-center">
      <img class="img-circle" src="{{ asset('/images/default-user-image.png') }}" alt="profiel_picture">
    </div>
  </div>
  <div class="text-center">
     <div class="row">
      <h2>{{ $user->fullName }}<br>
        <span class="text-primary text-capitalize">
          {{ $user->username }}
        </span>
      </h2>
      <p class="lead">
      </p>
      <p>
        {{ $user->role }}<br>
        {{ $user->gender=='male'? 'Male':'Female'  }}<br>
        {{ $user->email }}
      </p>
    </div>
  </div>
  <div class="row">

  </div>
</div>
@endsection
