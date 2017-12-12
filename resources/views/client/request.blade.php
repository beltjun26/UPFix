@extends('layouts.app')

@section('header')
<style media="screen">

</style>
@endsection

@section('content')
<div class="container">
  <div class="col-md-8 col-md-offset-2">
    <div class="panel panel-{{ $jobRequest->indication() }}">
      <div class="panel-heading">
        Job Request Detail
        <a href="{{ ($jobRequest->recommended() || $jobRequest->approved() || $jobRequest->assigned())? '#errorDelete' : '#myModal' }}" data-toggle="modal" class="pull-right text-danger"><span class="glyphicon glyphicon-trash"></span> Delete</a>
      </div>
      <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
              <p>Do you really want to delete this request?</p>
            </div>
            <div class="modal-footer">
              <form class="" action="/client/deleteRequest" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="requestID" value="{{ $jobRequest->requestID }}">
                <button type="submit" name="submit" class="btn btn-danger">Delete</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div id="errorDelete" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Confirmation</h4>
            </div>
            <div class="modal-body">
              <p>You can't delete request that had been approved or recommended already!</p>
            </div>
            <div class="modal-footer">
                <button type="button" name="submit" class="btn btn-info" data-dismiss="modal">Back</button>
            </div>
          </div>
        </div>
      </div>

      <div class="panel-body">
        <div class="row">
          <div class="col-sm-6">
            <label for="">requisitioning Unit: </label>
            <p class="lead">{{ $jobRequest->requisitioningUnit }}</p>
          </div>
          <div class="col-sm-6">
            <label for="">Location:</label>
            <p class="lead">{{ $jobRequest->location }}</p>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <label>Description:</label>
            <p>{{ $jobRequest->description }}</p>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <label>Date Needed:</label>
            <p class="lead">{{ date('F d Y', strtotime($jobRequest->dateNeeded)) }}</p>
          </div>
          <div class="com-sm-6">
            <label>Alternative date:</label>
            <p class="lead">{{ date('F d Y', strtotime($jobRequest->alternativeDate)) }}</p>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <label>Contact Numbers:</label>
            <p class="lead">{{ $jobRequest->contactNo }}</p>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <label class="{{ $jobRequest->approved()? 'text-success' : 'text-danger' }}">Approved by:</label>
            <p class="{{ $jobRequest->approved()? 'text-success' : 'text-danger' }}">
              @if($jobRequest->approved())
                {{ $jobRequest->approvedBy()->getUser->fullName }}
              @else
                pending
              @endif
            </p>
          </div>
          <div class="col-sm-6">
            <label class="{{ $jobRequest->recommended()? 'text-success' : 'text-danger' }}">Recommended by:</label>
            <p class="{{ $jobRequest->recommended()? 'text-success' : 'text-danger' }}">
              @if($jobRequest->recommended())
                {{ $jobRequest->recommendedBy()->getUser->fullName }}
              @else
                pending
              @endif
            </p>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <label class="{{ $jobRequest->assigned()? 'text-success' : 'text-danger' }}">Assigned To:</label>
            <p class="{{ $jobRequest->assigned()? 'text-success' : 'text-danger' }}">
              @if($jobRequest->assigned())
                {{ $jobRequest->assignedTo()->getUser->fullName }}
              @else
                pending
              @endif
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
