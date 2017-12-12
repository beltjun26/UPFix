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
          <h2 class="pull-left">{{ $serviceProvider->getUser->fullName }}</h2>
        </div>
        <div class="talble-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Client</th>
                <th>Description</th>
                <th>Date Needed</th>
                <th>Date Finished</th>
                <th>Comment</th>
                <th>Rating</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($jobRequests as $jobRequest)
              <tr class="{{ $jobRequest->indication() }}" data-href="/chairman/request/{{ $jobRequest->requestID }}">
                <td>{{ $jobRequest->getClient->getUser->fullName }}</td>
                <td>{{ $jobRequest->description }}</td>
                <td>{{ date('F d Y', strtotime($jobRequest->dateNeeded)) }}</td>
                <td>{{ date('F d Y', strtotime($jobRequest->accomplishedDate())) }}</td>
                <td>{{ $jobRequest->getComment() }}</td>
                <td>
                  @if ($jobRequest->rating == 1)
                    Poor
                  @elseif ($jobRequest->rating == 2)
                    Fair
                  @elseif ($jobRequest->rating == 3)
                    Good
                  @elseif ($jobRequest->rating == 4)
                    Very Good
                  @elseif ($jobRequest->rating == 5)
                    Excellent
                  @endif
                </td>
              </tr>
              @empty
              <tr>
                <td class="text-center" colspan="6">No Request</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        {{ $jobRequests->links() }}
    </div>
</div>
@endsection
