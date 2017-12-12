  @extends('layouts.app')

@section('header')
<style media="screen">

</style>
@endsection

@section('content')
<div class="container">
  <div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
      <div class="panel-heading">
        Set unavailability
      </div>
      <div class="panel-body">
        <form action="/serviceProvider/addUnavailability" method="post">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label>Start Date</label>
                <input class="form-control" type="date" name="startdaet" value="">
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label>End Date</label>
                <input class="form-control" type="date" name="enddate" value="">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <button class="btn btn-default pull-right" type="submit" name="submit">Submit</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
