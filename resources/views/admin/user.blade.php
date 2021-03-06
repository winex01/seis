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


                <table id="users-table" class="table table-striped table-condensed">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Username</th>
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
                      <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
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
<div class="modal fade" id="edit-user">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Edit User</h4>
            </div>
            <div class="modal-body">
                <form id="update-user-form" class="form-horizontal">

                  {{ csrf_field() }}
                  
                  <div class="form-group">
                    <label class="control-label col-sm-2" for="edit-name">Name:</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" value="{{old('edit-name')}}" id="edit-name" name="edit-name" placeholder="Enter Name">
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
        $('#users-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('user.all') }}',
            columns: [
                {data: 'id'},
                {data: 'name'},
                {data: 'username'},
                {data: 'created_at'},
                {data: 'action'},
            ]
        });
    });

  // delete team
  var id;
  function deleteUser(row) {
      $('#modal-confirm-delete .modal-body p').html('Are you sure you want to delete <strong>' + row.name + '</strong>?');
      $('#modal-confirm-delete').modal();

      id = row.id;
  }
  $('#btn-confirm-delete').click(function(event) {
        /* Act on the event */
        $.ajax({
            type: "DELETE",
            url: '{{ url('user').'/' }}'+id,
            success: function (data) {
                
                $('#modal-confirm-delete').modal('hide');
                dataTableRefresh('#users-table', 5);
                printSuccessMsg(data.title, 'Deleted');

            },
            error: function (data) {
                console.log('Error:', data);
            }

        });

  });


  function editUser(row){
    id = row.id;
    $('#edit-name').val(row.name)
    $('#edit-user').modal();
  }

  $('#update-user-form').submit(function(event) {
      /* Act on the event */
      event.preventDefault();

      var name = $('#edit-name').val();
        $.ajax({
            type: "PATCH",
            url: '{{ url('user').'/' }}'+id,
            data: {
                name: name
            },
            success: function (data) {
                console.log(data);
                
                dataTableRefresh('#users-table', 5);
                printSuccessMsg(data.title, 'Updated');
                $('#edit-user').modal('hide');

            },
            error: function (data) {
                console.log('Error:', data);
            }

        });
  });

</script>
@endpush