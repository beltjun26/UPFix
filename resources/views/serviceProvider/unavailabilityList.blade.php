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
          <h2 class="col-sm-offset-3 pull-left">Unavailability</h2>
        </div>
        <div class="col-sm-6 col-sm-offset-3">
          <div class="talble-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Date</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($dates as $date)
              <tr>
                <td>{{ date('F d Y', strtotime($date->date)) }} </td>
              </tr>
              @empty
              <tr class="text-center">
                <td>No Unavailability</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        </div>
        <div class="text-center">
          {{ $dates->links() }}
        </div>
    </div>
</div>
@endsection
