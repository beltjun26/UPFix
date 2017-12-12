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
        Job Request Details
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
          <div class="col-sm-12">
            <label>Date Accomplished:</label>
            <p class="lead">{{ date('F d Y', strtotime($jobRequest->dateNeeded)) }}</p>
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
        <hr>
        <h3>Accomplishment Report</h3>
        <div class="row">
          <div class="col-sm-12">
            <label>Remarks:</label>
            <p class="lead">{{ $jobRequest->accomplish()->remarks }}</p>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <label class="{{ $jobRequest->confirmed()? 'text-success' : 'text-danger' }}">Confirmed:</label>
            <p class="{{ $jobRequest->confirmed()? 'text-success' : 'text-danger' }}">
              @if($jobRequest->confirmed())
                {{ $jobRequest->getClient->getUser->fullName }}
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
