@extends('layouts.app')

@section('header')
<script type="text/javascript" src="{{ asset('js/client/home.js') }}">
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
          <h2 class="pull-left">Requests</h2>
        </div>
        <div class="talble-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>requisitioning Unit</th>
                <th>Location</th>
                <th>Description</th>
                <th>Date Needed</th>
                <th>Alternative Date</th>
                <th>Contact No</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($jobRequests as $jobRequest)
              <tr class="clickable-row {{ $jobRequest->indication() }}" data-href="/serviceProvider/request/{{ $jobRequest->requestID }}">
                <td>{{ $jobRequest->requisitioningUnit }}</td>
                <td>{{ $jobRequest->location }}</td>
                <td>{{ $jobRequest->description }}</td>
                <td>{{ date('F d Y', strtotime($jobRequest->dateNeeded)) }}</td>
                <td>{{ date('F d Y', strtotime($jobRequest->alternativeDate)) }}</td>
                <td>{{ $jobRequest->contactNo }}</td>
              </tr>
              @empty

              @endforelse
            </tbody>
          </table>
        </div>
    </div>
</div>
@endsection
