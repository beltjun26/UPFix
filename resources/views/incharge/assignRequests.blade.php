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
          <h2 class="pull-left">Assign Requests</h2>
        </div>
        <div class="talble-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Client</th>
                <th>Requisitioning Unit</th>
                <th>Description</th>
                <th>Date Approved</th>
                <th>Date Needed</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($jobRequests as $jobRequest)
              <tr class="clickable-row {{ $jobRequest->indication() }}" data-href="/incharge/assignTo/{{ $jobRequest->requestID }}">
                <td>{{ $jobRequest->getClient->getUser->fullName }}</td>
                <td>{{ $jobRequest->requisitioningUnit }}</td>
                <td>{{ $jobRequest->description }}</td>
                <td>{{ date('F d Y', strtotime($jobRequest->approvedDate())) }}</td>
                <td>{{ date('F d Y', strtotime($jobRequest->dateNeeded)) }}</td>
              </tr>
              @empty
              <tr>
                <td class="text-center" colspan="5">No Request</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
    </div>
</div>
@endsection
