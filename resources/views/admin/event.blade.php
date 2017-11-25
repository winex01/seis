@extends('layouts.app')

@section('sidebar')
    @include('layouts.admin-sidebar')
@endsection

@section('content')
 <div id="wrapper">

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <ol class="breadcrumb">
                        <li>
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="active">
                            <i class="fa fa-list-alt fa-fw"></i> 
                            Events</li>
                    </ol>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        @include('flash::message')
        @include('layouts.validation-errors')

        {{-- content --}}
        <div class="form-group">
            <a data-toggle="modal" href='#new-event' class="btn btn-default"><i class="fa fa-plus-circle" aria-hidden="true"></i>
                New Event
            </a>
        </div>


        <table id="events-table" class="table table-striped">
            <thead>
            <tr>
              <th>ID</th>
              <th>Year</th>
              <th>Created</th>
              <th><center>Action</center></th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        {{-- / content --}}
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<div class="modal fade" id="new-event">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">New Event</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('event.store') }}">

                  {{ csrf_field() }}
                  
                  <div class="form-group">
                    <label class="control-label col-sm-4">Year:</label>
                    <div class="col-sm-6">
                        <input type="number" name="year" min="1999" max="2099" class="form-control" />
                    </div>
                  </div>

                  <div class="form-group"> 
                    <div class="col-sm-offset-4 col-sm-10">
                      <button type="submit" class="btn btn-primary btn-outline">Save
                      <i class="fa fa-check" aria-hidden="true"></i>
                      </button>
                    </div>
                  </div>
                </form>
            </div>
            
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(function() {
            $('#events-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url('event/all') }}',
                columns: [
                    {data: 'id'},
                    {data: 'year'},
                    {data: 'created_at'},
                    {data: 'action'},
                ]
            });
        });
    </script>
@endpush