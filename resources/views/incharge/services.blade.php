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
          <h2 class="col-sm-offset-3 pull-left">Services</h2>
          <a href="#myModal" class="btn btn-success pull-right" data-toggle="modal">Add Service</a>
        </div>

        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Service</h4>
              </div>
              <form class="" action="/incharge/addService" method="post">
                {{ csrf_field() }}
                <div class="modal-body">
                  <label class="label-control">Service:</label>
                  <input type="text" name="name" class="form-control">
                </div>
                  <div class="modal-footer">
                    <input type="hidden" name="departmentID" value="{{ Auth::user()->departmentID }}">
                    <button type="submit" name="submit" class="btn btn-success">Add</button>
                </div>
                </form>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-sm-offset-3">
          <div class="talble-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Name</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($services as $service)
              <tr>
                <td>{{ $service->name }} <span class="pull-right"><a href="#" class="text-danger"><span class="glyphicon glyphicon-trash"></span>Delete</a></span></td>
              </tr>
              @empty
              <tr class="text-center">
                <td>No Service Yet</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        </div>
        <div class="text-center">
          {{ $services->links() }}
        </div>
    </div>
</div>
@endsection
