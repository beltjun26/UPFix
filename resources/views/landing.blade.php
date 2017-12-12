<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>UPFix</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href="css/app.css" rel="stylesheet"/>
    <link href="css/landing.css" rel="stylesheet"/>
  </head>
  <body>
    <div class="row">
      <img class="img-responsive" src="images/upfixLogo.png" alt="UPFix"/>
    </div>
    <div class="container">
      <div class="row">
        <div class="text-center">
          <h1>Register as a</h1>
        </div>
      </div>
      <div class="row">
        <div class="text-center">
          <div class="btn-group">
            <a href="/register/client" class="btn btn-default btn-lg" name="user">Client</a>
            <a href="/register/incharge" class="btn btn-default btn-lg" name= "dep_head">Incharge</a>
            <a href="/register/chairman" class="btn btn-default btn-lg" name="chairman">Chairman</a>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="text-center">
          <h3 class="">or</h3>
        </div>
      </div>
      <div class="row">
        <div class="text-center">
          <a href="/login" class="btn btn-default btn-lg">Login</a>
        </div>
      </div>
    </div>
  </body>
</html>
