@extends('layouts.app')

@section('header')
<script type="text/javascript">

</script>
<style media="screen">
</style>
@endsection

@section('content')
<div class="container">
  <div class="col-md-8 col-md-offset-2">
    <div class="panel panel-{{ $jobRequest->indication() }}">
      <div class="panel-heading">
          Assign Job Request
      </div>
      <div class="panel-body">
        <div class="row">
          <div class="col-sm-2">
            <label>Client:</label>
          </div>
          <div class="col-sm-10">
            <p>{{ $jobRequest->getClient->getUser->fullName }}</p>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">
            <label>Description:</label>
          </div>
          <div class="col-sm-10">
            <p>{{ $jobRequest->description }}</p>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">
            <label>Date Needed:</label>
          </div>
          <div class="col-sm-10">
            <p>{{ date('F d Y', strtotime($jobRequest->dateNeeded)) }}</p>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">
            <label>Alternative Date:</label>
          </div>
          <div class="col-sm-10">
            <p>{{ date('F d Y', strtotime($jobRequest->alternativeDate)) }}</p>
          </div>
        </div>
        <form action="/incharge/assign" method="post">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-sm-2">
              <label>Assign To:</label>
            </div>
            @php
              $noSPavailable = 0;
            @endphp
            <div class="col-sm-10">
              <div class="form-group">
                <select class="form-control" name="serviceProviderID">
                  @forelse ($serviceProviders as $serviceProvider)
                    @if($serviceProvider->isAvailable($jobRequest->dateNeeded) || $serviceProvider->isAvailable($jobRequest->alternativeDate))
                      @php
                        $noSPavailable = 1;
                      @endphp
                      <option class="danger" value="{{ $serviceProvider->ID }}">{{ $serviceProvider->getUser->fullName }}</option>
                    @else
                    @endif
                  @empty
                  @endforelse
                </select>
              </div>
            </div>
          </div>
          @if($noSPavailable == 0)
          <div class="row">
            <div class="col-sm-10 col-sm-offset-2">
              <p class="text-danger">No available Service Provider these dates</p>
            </div>
          </div>
          @else
          @endif
          <div class="row">
            <div class="col-sm-12">
              <input type="hidden" name="requestID" value="{{ $jobRequest->requestID }}">
              @if($noSPavailable == 0)
              <a href="/incharge/returnRequest/{{ $jobRequest->requestID }}" class="btn btn-danger pull-right">Return Request</a>
              @else
              <button class="btn btn-info pull-right" type="submit" name="submit">Assign</button>
              @endif
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
