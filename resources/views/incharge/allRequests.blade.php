@extends('layouts.app')

@section('header')
<script type="text/javascript" src="{{ asset('js/client/home.js') }}">
</script>
<script type="text/javascript" src="{{ asset('js/incharge/allrequests.js') }}">

</script>
<style media="screen">
  .clickable-row{
    cursor: pointer;
  }
</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="row">
          <div class="col-sm-6">
            <h2 class="pull-left">All Request</h2>
          </div>
          <div class="col-sm-offset-3 col-sm-3">
            <div class="form-group">
              <select class="form-control pull-right" name="sort">
                <option value="all">All</option>
                <option value="unrecommended" {{ $sort == 'unrecommended'? 'Selected' : '' }}>Unrecommended</option>
                <option value="unaccomplished" {{ $sort == 'unaccomplished'? 'Selected' : '' }}>Unaccomplished</option>
                <option value="unassigned" {{ $sort == 'unassigned'? 'Selected' : '' }}>Unassigned</option>
                <option value="for_confirmation" {{ $sort == 'for_confirmation'? 'Selected' : '' }}>For Confirmation</option>
                <option value="finished" {{ $sort == 'finished'? 'Selected' : '' }}>Finished</option>
              </select>
            </div>
          </div>
        </div>
        <div class="talble-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Client</th>
                <th>Requisitioning Unit</th>
                <th>Location</th>
                <th>Description</th>
                <th>Date Needed</th>
                <th>Alternative Date</th>
                <th>Contact No</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($jobRequests as $jobRequest)
              <tr class="clickable-row {{ $jobRequest->indication() }}" data-href="/incharge/request/{{ $jobRequest->requestID }}">
                <td>{{ $jobRequest->getClient->getUser->fullName }}</td>
                <td>{{ $jobRequest->requisitioningUnit }}</td>
                <td>{{ $jobRequest->location }}</td>
                <td>{{ $jobRequest->description }}</td>
                <td>{{ date('F d Y', strtotime($jobRequest->dateNeeded)) }}</td>
                <td>{{ date('F d Y', strtotime($jobRequest->alternativeDate)) }}</td>
                <td>{{ $jobRequest->contactNo }}</td>
              </tr>
              @empty
              <tr>
                <td class="text-center" colspan="7">No Request</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
    </div>
</div>
@endsection
