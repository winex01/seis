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

                        <li>
                            <i class="fa fa-list-alt" aria-hidden="true"></i>
                            <a href="{{ route('event.index') }}">Events</a>
                        </li>

                        <li class="active">
                            <i class="fa fa-calendar-o"></i> 
                            {{ $event->year }}</li>
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
                    <a data-toggle="modal" href='#include-game' class="btn btn-default"><i class="fa fa-plus-circle" aria-hidden="true"></i>
                        Include Sport
                    </a>
                </div>


                <table id="games-table" class="table table-striped table-condensed">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Sport</th>
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


<div class="modal fade" id="include-game">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Available Sports</h4>
            </div>
            <div class="modal-body">
                

                <table id="gametype-table" class="table table-striped table-condensed" width="100%">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Description</th>
                      <th>Created</th>
                      <th><center>Action</center></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                
            </div>
        </div>
    </div>
</div>



@include('layouts.confirm-delete')

@endsection

@push('scripts')
    <script type="text/javascript">
        $(function() {
            $('#games-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('event.games', $event->id) }}',
                columns: [
                    {data: 'id'},
                    {data: 'game'},
                    {data: 'created_at'},
                    {data: 'action'},
                ]
            });
        });


        // game type
        $(function() {
            $('#gametype-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('event.gameTypes', $event->id) }}',
                columns: [
                    {data: 'id'},
                    {data: 'description'},
                    {data: 'created_at'},
                    {data: 'action'},
                ]
            });
        });

        // add event game
        function addEventGame(gtid, gtdesc)
        {
            
            /* Act on the event */
            $.ajax({
                type: "POST",
                url: '{{ route('event.store.gametype', $event->id) }}',
                data: {
                    game_type_id: gtid,
                    game: gtdesc
                },
                success: function (data) {
                    console.log(data);

                    dataTableRefresh('#gametype-table');
                    dataTableRefresh('#games-table');
                    // printSuccessMsg(data.title, 'Deleted');

                },
                error: function (data) {
                    console.log('Error:', data);
                }

            });
            
        }

      // delete event game
      var id;
      function deleteEventGame(param1, param2) {
          $('#modal-confirm-delete .modal-body p').html('Are you sure you want to delete <strong>' + param2 + '</strong>?');
          $('#modal-confirm-delete').modal();

          id = param1;
      }
      $('#btn-confirm-delete').click(function(event) {
            /* Act on the event */
            $.ajax({
                type: "DELETE",
                url: '{{ url('event/game').'/' }}'+id,
                success: function (data) {
                    
                    $('#modal-confirm-delete').modal('hide');
                    dataTableRefresh('#gametype-table');
                    dataTableRefresh('#games-table');
                    printSuccessMsg(data.title, 'Deleted');

                },
                error: function (data) {
                    console.log('Error:', data);
                }

            });

      });

    </script>
@endpush