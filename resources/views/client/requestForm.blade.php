@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-default">
        <div class="panel-heading">
          Job Request Form
        </div>
        <div class="panel-body">
            <form class="form-horizontal" action="/client/sendRequest" method="post">
              {{ csrf_field() }}

              <div class="form-group{{ $errors->has('service') ? ' has-error' : '' }}">
                <label class="control-label col-sm-2" for="service">Service:</label>
                <div class="col-sm-10">
                  <select class="form-control" name="service">
                    @forelse ($services as $service)
                      <option value="{{ $service->ID }}">{{ $service->name }}</option>
                    @empty

                    @endforelse
                  </select>
                </div>
              </div>

              <div class="form-group{{ $errors->has('requisitioningUnit') ? ' has-error' : '' }}">
                <label class="control-label col-sm-2" for="requisitioningUnit">Requeisition Unit:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="requisitioningUnit" placeholder="Enter requisitioning Unit" name="requisitioningUnit" value="{{ old('requisitioningUnit') }}">
                  @if ($errors->has('requisitioningUnit'))
                  <span class="help-block">
                    <strong>{{ $errors->first('requisitioningUnit') }}</strong>
                  </span>
                  @endif
                </div>
              </div>

              <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
                <label class="control-label col-sm-2" for="location">Location: </label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="location" name="location" placeholder="Enter Location" value="{{ old('location')? old('location'): Auth::user()->getRole->location}}">
                  @if ($errors->has('location'))
                  <span class="help-block">
                    <strong>{{ $errors->first('location') }}</strong>
                  </span>
                  @endif
                </div>
              </div>

              <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                <label for="description" class="control-label col-sm-2">Description</label>
                <div class="col-sm-10">
                   <textarea name="description" class="form-control" rows="3" id="description">{{ old('description') }}</textarea>
                   @if ($errors->has('description'))
                   <span class="help-block">
                     <strong>{{ $errors->first('description') }}</strong>
                   </span>
                   @endif
                </div>
              </div>

              <div class="form-group{{ $errors->has('dateNeeded') ? ' has-error' : '' }}">
                <label class="control-label col-sm-2" for="dateNeeded">Date Needed</label>
                <div class="col-sm-10">
                  <input class="form-control" type="date" name="dateNeeded" placeholder="Enter Date" value="{{ old('dateNeeded') }}">
                  @if ($errors->has('dateNeeded'))
                  <span class="help-block">
                    <strong>{{ $errors->first('dateNeeded') }}</strong>
                  </span>
                  @endif
                </div>
              </div>

              <div class="form-group{{ $errors->has('alternativeDate') ? ' has-error' : '' }}">
                <label class="control-label col-sm-2" for="alternativeDate">Alternative Date:</label>
                <div class="col-sm-10">
                  <input class="form-control" type="date" name="alternativeDate" id="alternativeDate" value="{{ old('alternativeDate') }}">
                  @if ($errors->has('alternativeDate'))
                  <span class="help-block">
                    <strong>{{ $errors->first('alternativeDate') }}</strong>
                  </span>
                  @endif
                </div>
              </div>

              <div class="form-group{{ $errors->has('contactNo') ? ' has-error' : '' }}">
                <label for="contactNo" class="control-label col-sm-2">Contact No.:</label>
                <div class="col-sm-10">
                  <input class="form-control" type="number" name="contactNo" placeholder="Enter Contact No." value="{{ old('contactNo') }}">
                  @if ($errors->has('contactNo'))
                  <span class="help-block">
                    <strong>{{ $errors->first('contactNo') }}</strong>
                  </span>
                  @endif
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-2">
                  <input type="submit" name="submit" class="btn btn-primary">
                </div>
              </div>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
