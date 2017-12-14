@extends('layouts.app')

@section('header')
<script type="text/javascript" src="{{ asset('js/client/home.js') }}">
</script>
<script type="text/javascript" src="{{ asset('js/incharge/reports.js') }}">
</script>
<script type="text/javascript">
  var category = '{{ $category }}'
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
          <div class="col-sm-3">
            <h2 class="">Summary Report</h2>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <select class="form-control" name="category" id="category">
                <option value="all" {{ $category=='all'? 'selected' : ''}}>All</option>
                <option value="monthly" {{ $category=='monthly'? 'selected' : ''}}>Monthly</option>
                <option value="half_year" {{ $category=='half_year'? 'selected' : ''}}>6 Months</option>
              </select>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <select id="sort" class="form-control" name="sort" {{ ($category=='monthly' || $category=='half_year')? '' : 'disabled' }}>
                <option class="default" value="" disabled {{ $sort==''? 'selected': '' }}>Select</option>
                <option class="monthly" value="jan" {{ $sort=='jan'? 'selected': '' }}>January</option>
                <option class="monthly" value="feb" {{ $sort=='feb'? 'selected': '' }}>February</option>
                <option class="monthly" value="mar" {{ $sort=='mar'? 'selected': '' }}>March</option>
                <option class="monthly" value="apr" {{ $sort=='apr'? 'selected': '' }}>April</option>
                <option class="monthly" value="may" {{ $sort=='may'? 'selected': '' }}>May</option>
                <option class="monthly" value="jun" {{ $sort=='jun'? 'selected': '' }}>June</option>
                <option class="monthly" value="jul" {{ $sort=='jul'? 'selected': '' }}>July</option>
                <option class="monthly" value="aug" {{ $sort=='sep'? 'selected': '' }}>August</option>
                <option class="monthly" value="sep" {{ $sort=='jan'? 'selected': '' }}>September</option>
                <option class="monthly" value="oct" {{ $sort=='oct'? 'selected': '' }}>October</option>
                <option class="monthly" value="nov" {{ $sort=='nov'? 'selected': '' }}>November</option>
                <option class="monthly" value="dec" {{ $sort=='dec'? 'selected': '' }}>December</option>
                <option class="half" value="jan-jun" {{ $sort=='jan-jun'? 'selected': '' }}>January - June</option>
                <option class="half" value="jul-dec" {{ $sort=='jul-dec'? 'selected': '' }}>July - December</option>
              </select>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <input class="form-control" id="year" type="year" name="year" value="{{ $year? $year: date('Y') }}">
            </div>
          </div>
          <!-- <button class="btn btn-default pull-right" type="button" name="button">Monthly</button> -->
        </div>
        <div class="talble-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Service Provider</th>
                <th>Job Assigned</th>
                <th>Job Accomplished</th>
                <th>Rating</th>
                <th>Rating Value</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($serviceProviders as $serviceProvider)
              <tr>
                <td>{{ $serviceProvider->getUser->fullName }}</td>
                <td>{{ count($serviceProvider->getAssigned($sort, $year)) }}</td>
                <td>{{ count($serviceProvider->getAccomplished($sort, $year)) }}</td>
                  @php
                    $average = 0;
                  @endphp
                  @forelse ($serviceProvider->getAccomplished($sort, $year) as $jobRequest)
                    @php
                      $average = $average + $jobRequest->rating;
                    @endphp
                  @empty
                  @endforelse
                  @php
                    if(count($serviceProvider->getAccomplished($sort, $year))!=0)
                    $average = $average / count($serviceProvider->getAccomplished($sort, $year))
                  @endphp
                <td>
                  @if ($average > 0 && $average < 1.5)
                    Poor
                  @elseif ($average >= 1.5 && $average < 2.5)
                    Fair
                  @elseif ($average >= 2.5 && $average < 3.5)
                    Good
                  @elseif ($average >= 3.5 && $average < 4.5)
                    Very Good
                  @elseif ($average >= 4.5)
                    Excellent
                  @endif
                </td>
                <td>{{ $average }}</td>
              </tr>
              @empty
              <tr>
                <td class="text-center" colspan="6">No Request</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="text-center">
          {{ $serviceProviders->links() }}
        </div>
    </div>
</div>
@endsection
