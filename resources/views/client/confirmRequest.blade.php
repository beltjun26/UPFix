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
          <h2 class="pull-left">Accomplished Requests Table</h2>
          <a href="/client/requestForm" class="btn btn-success pull-right">Send Job Request</a>
        </div>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Requisitioning Unit</th>
                <th>Description</th>
                <th>Date Needed</th>
                <th>Contact No</th>
                <th>Status</th>
                <th>Assigned to</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($jobRequests as $jobRequest)
              <tr class="clickable-row {{ $jobRequest->indication() }}" data-href="/client/request/{{ $jobRequest->requestID }}">
                <td>{{ $jobRequest->requisitioningUnit }}</td>
                <td>{{ $jobRequest->description }}</td>
                <td>{{ date('F d Y', strtotime($jobRequest->dateNeeded)) }}</td>
                <td>{{ $jobRequest->contactNo }}</td>
                <td>{{ ($jobRequest->recommended() && $jobRequest->approved()? 'Approved':'Pending' ) }}</td>
                <td><span class="{{ $jobRequest->assigned()? '' : 'text-danger' }}">{{ $jobRequest->assigned()? $jobRequest->assignedTo()->getUser->fullName: 'Pending' }}</span></td>
              </tr>
              @empty

              @endforelse

            </tbody>
          </table>
        </div>
        {{ $jobRequests->links() }}
    </div>
</div>
@endsection
