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
        <div class="panel panel-default">
            <div class="panel-body">
                
                @include('flash::message')
                @include('layouts.validation-errors')
                {{-- custom --}}
                @include('layouts.flash-success')

                {{-- content --}}
                <div class="form-group">
                    <a data-toggle="modal" href='#new-event' class="btn btn-default"><i class="fa fa-plus-circle" aria-hidden="true"></i>
                        New Event
                    </a>
                </div>


                <table id="events-table" class="table table-striped table-condensed">
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
        </div>
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


<div class="modal fade" id="edit-event">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Edit Event</h4>
            </div>
            <div class="modal-body">
                <form  id="update-event-form" class="form-horizontal">

                  {{ csrf_field() }}
                  
                  <div class="form-group">
                    <label class="control-label col-sm-4">Year:</label>
                    <div class="col-sm-6">
                        <input type="number" name="edit-year" id="edit-year" min="1999" max="2099" class="form-control" />
                    </div>
                  </div>

                  <div class="form-group"> 
                    <div class="col-sm-offset-4 col-sm-10">
                      <button type="submit" class="btn btn-primary btn-outline">Update
                      <i class="fa fa-check" aria-hidden="true"></i>
                      </button>
                    </div>
                  </div>
                </form>
            </div>
            
        </div>
    </div>
</div>

@include('layouts.confirm-delete')

@endsection

@push('scripts')
    <script type="text/javascript">
        $(function() {
            $('#events-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('event.all') }}',
                columns: [
                    {data: 'id'},
                    {data: 'year'},
                    {data: 'created_at'},
                    {data: 'action'},
                ]
            });
        });



      // delete event
      var id;
      function deleteEvent(event_id, event_year) {
          $('#modal-confirm-delete .modal-body p').html('Are you sure you want to delete <strong>' + event_year + '</strong>?');
          $('#modal-confirm-delete').modal();

          id = event_id;
      }
      $('#btn-confirm-delete').click(function(event) {
            /* Act on the event */
            $.ajax({
                type: "DELETE",
                url: '{{ url('event').'/' }}'+id,
                success: function (data) {
                    
                    $('#modal-confirm-delete').modal('hide');
                    dataTableRefresh('#events-table');
                    printSuccessMsg(data.title, 'Deleted');

                },
                error: function (data) {
                    console.log('Error:', data);
                }

            });

      });

      function editEvent(eid, eyear){
        id = eid;
        $('#edit-year').val(eyear)
        $('#edit-event').modal();
      }

      $('#update-event-form').submit(function(event) {
          /* Act on the event */
          event.preventDefault();

          var year = $('#edit-year').val();
            $.ajax({
                type: "PATCH",
                url: '{{ url('event').'/' }}'+id,
                data: {
                    year: year
                },
                success: function (data) {
                    console.log(data);
                    
                    dataTableRefresh('#events-table');
                    printSuccessMsg(data.title, 'Updated');
                    $('#edit-event').modal('hide');

                },
                error: function (data) {
                    console.log('Error:', data);
                }

            });
      });


      
    </script>
@endpush