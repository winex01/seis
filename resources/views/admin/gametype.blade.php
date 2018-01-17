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
                            <i class="fa fa-th fa-fw"></i> 
                            Sports</li>
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
                    <a data-toggle="modal" href='#new-gametype' class="btn btn-default"><i class="fa fa-plus-circle" aria-hidden="true"></i>
                        Add Sport
                    </a>
                </div>


                <table id="gametype-table" class="table table-striped table-condensed">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Description</th>
                      <th>Medal Points</th>
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

<div class="modal fade" id="new-gametype">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add Sport</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('gametype.store') }}">

                  {{ csrf_field() }}
                  
                  <div class="form-group">
                    <label class="control-label col-sm-2" for="description">Description:</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="description" name="description" placeholder="ex. Basketball, Chess">
                    </div>
                  </div>

                  <div class="col-sm-2">
                      <label for="sel1">Medal Points:</label>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <select class="form-control" id="sel1" name="medal_points">
                        @for($i = 1; $i <= 10; $i++)
                          <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                      </select>
                    </div>
                  </div>
                
                  <div class="form-group"> 
                    <div class="col-sm-offset-2 col-sm-10">
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


<div class="modal fade" id="edit-gametype">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Edit Sport</h4>
            </div>
            <div class="modal-body">
                <form  id="update-gametype-form" class="form-horizontal">

                  {{ csrf_field() }}
                  
                  <div class="form-group">
                    <label class="control-label col-sm-2" for="edit-description">Description:</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="edit-description" name="edit-description" placeholder="ex. Basketball, Chess" autofocus="">
                    </div>
                  </div>

                  <div class="col-sm-2">
                      <label for="medal-points">Medal Points:</label>
                  </div>
                  <div class="col-sm-2">
                    <div class="form-group">
                      <select class="form-control" id="medal-points" name="medal_points">
                        @for($i = 1; $i <= 10; $i++)
                          <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                      </select>
                    </div>
                  </div>
                
                  <div class="form-group"> 
                    <div class="col-sm-offset-2 col-sm-10">
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



@include('layouts.confirm-delete')

@endsection

@push('scripts')
<script type="text/javascript">
    $(function() {
        $('#gametype-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('gametype.all') }}',
            columns: [
                {data: 'id'},
                {data: 'description'},
                {data: 'medal_points'},
                {data: 'created_at'},
                {data: 'action'},
            ]
        });
    });

  // delete gametype
  var id;
  function deleteGametype(gtid, gtdesc) {
      $('#modal-confirm-delete .modal-body p').html('Are you sure you want to delete <strong>' + gtdesc + '</strong>?');
      $('#modal-confirm-delete').modal();

      id = gtid;
  }
  $('#btn-confirm-delete').click(function(event) {
        /* Act on the event */
        $.ajax({
            type: "DELETE",
            url: '{{ url('gametype').'/' }}'+id,
            success: function (data) {
                
                $('#modal-confirm-delete').modal('hide');
                dataTableRefresh('#gametype-table', 5);
                printSuccessMsg(data.title, 'Deleted');

            },
            error: function (data) {
                console.log('Error:', data);
            }

        });

  });


  function editGametype(row){
    id = row.id;
    $('#edit-description').val(row.description)
    $('#edit-gametype').modal();
    $('#medal-points').val(row.medal_points);
  }

  $('#update-gametype-form').submit(function(event) {
      /* Act on the event */
      event.preventDefault();

      var description = $('#edit-description').val();
      var medal_points = $('#medal-points').val();

        $.ajax({
            type: "PATCH",
            url: '{{ url('gametype').'/' }}'+id,
            data: {
                description: description,
                medal_points: medal_points
            },
            success: function (data) {
                console.log(data);
                
                dataTableRefresh('#gametype-table', 5);
                printSuccessMsg(data.title, 'Updated');
                $('#edit-gametype').modal('hide');

            },
            error: function (data) {
                console.log('Error:', data);
            }

        });
  });

</script>
@endpush