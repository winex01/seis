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
                            <i class="fa fa-user fa-fw"></i> 
                            Users</li>
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
                    <a data-toggle="modal" href='#add-user' class="btn btn-default"><i class="fa fa-plus-circle" aria-hidden="true"></i>
                        Add User
                    </a>
                </div>


                <table id="team-table" class="table table-striped table-condensed">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Team Description</th>
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

<div class="modal fade" id="add-user">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add User</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('user.store') }}">

                  {{ csrf_field() }}
                  
                  <div class="form-group">
                    <label class="control-label col-sm-2" for="name">Name:</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" value="{{old('name')}}" id="name" name="name" placeholder="Enter Name">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-2" for="username">Username:</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="username" value="{{old('username')}}" name="username" placeholder="Enter Username">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-2" for="password">Password:</label>
                    <div class="col-sm-10">
                      <input type="password" {{old('password')}} class="form-control" id="password" name="password" placeholder="Enter Password">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-2" for="password-confirm ">Confirm:</label>
                    <div class="col-sm-10">
                      <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
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

{{-- update --}}
<div class="modal fade" id="edit-team">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Edit Team</h4>
            </div>
            <div class="modal-body">
                <form  id="update-team-form" class="form-horizontal">

                  {{ csrf_field() }}
                  
                  <div class="form-group">
                    <label class="control-label col-sm-2" for="edit-description">Team:</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="edit-description" name="edit-description" placeholder="ex. Basketball, Chess" autofocus="">
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
        $('#team-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('team.all') }}',
            columns: [
                {data: 'id'},
                {data: 'description'},
                {data: 'created_at'},
                {data: 'action'},
            ]
        });
    });

  // delete team
  var id;
  function deleteTeam(param1, param2) {
      $('#modal-confirm-delete .modal-body p').html('Are you sure you want to delete <strong>' + param2 + '</strong>?');
      $('#modal-confirm-delete').modal();

      id = param1;
  }
  $('#btn-confirm-delete').click(function(event) {
        /* Act on the event */
        $.ajax({
            type: "DELETE",
            url: '{{ url('team').'/' }}'+id,
            success: function (data) {
                
                $('#modal-confirm-delete').modal('hide');
                dataTableRefresh('#team-table');
                printSuccessMsg(data.title, 'Deleted');

            },
            error: function (data) {
                console.log('Error:', data);
            }

        });

  });


  function editTeam(param1, param2){
    id = param1;
    $('#edit-description').val(param2)
    $('#edit-team').modal();
  }

  $('#update-team-form').submit(function(event) {
      /* Act on the event */
      event.preventDefault();

      var description = $('#edit-description').val();
        $.ajax({
            type: "PATCH",
            url: '{{ url('team').'/' }}'+id,
            data: {
                description: description
            },
            success: function (data) {
                console.log(data);
                
                dataTableRefresh('#team-table');
                printSuccessMsg(data.title, 'Updated');
                $('#edit-team').modal('hide');

            },
            error: function (data) {
                console.log('Error:', data);
            }

        });
  });

</script>
@endpush