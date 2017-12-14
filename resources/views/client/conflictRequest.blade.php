@extends('layouts.app')

@section('header')
<style media="screen">

</style>
@endsection

@section('content')
<div class="container">
<div class="col-md-8 col-md-offset-2">
  <div class="panel panel-danger  ">
    <div class="panel-heading">
      <div class="row">
        <div class="col-sm-12">
          <span class="pull-left">Set Date</span>
          <form class="" action="/client/deleteRequest" method="post">
            {{ csrf_field() }}
            <input type="hiddne" name="requestID" value="{{ $jobRequest->requestID }}">
            <button class="btn btn-danger pull-right" type="submit" name="submit">Delete</button>
          </form>
        </div>
      </div>
    </div>
    <div class="panel-body">
      <form action="/client/changeDate" method="post">
        {{ csrf_field() }}
        <input type="hidden" name="requestID" value="{{ $jobRequest->requestID }}">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label>Preffered Date</label>
              <input class="form-control" type="date" name="dateNeeded" value="" required>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>Alternative date</label>
              <input class="form-control" type="date" name="alternativeDate" value="" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <button class="btn btn-default pull-right" type="submit" name="submit">Submit</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
</div>
@endsection
