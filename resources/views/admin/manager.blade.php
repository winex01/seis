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
                            Sport Managers</li>
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
                    <a data-toggle="modal" href='#add-sports-manager' class="btn btn-default"><i class="fa fa-plus-circle" aria-hidden="true"></i>
                        Add Sports Mngr.
                    </a>
                </div>


                <table id="sport-managers-table" class="table table-striped table-condensed">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>First Name</th>
                      <th>Middle Name</th>
                      <th>Last Name</th>
                      <th>Suffix</th>
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

<div class="modal fade" id="add-sports-manager">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">New Sports Manager</h4>
      </div>
      <div class="modal-body">
            <form class="form-horizontal" method="POST" action="{{ route('manager.store') }}">

            {{ csrf_field() }}

            <div class="form-group">
              <label class="control-label col-sm-2" for="firstname">FN:</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="firstname" value="{{old('firstname')}}" name="firstname" placeholder="First Name">
              </div>
              <label class="control-label col-sm-2" for="middlename">MN:</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="middlename" value="{{old('middlename')}}" name="middlename" placeholder="Middle Name">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="lastname">LN:</label>
              <div class="col-sm-4"> 
                <input type="text" class="form-control" id="lastname" value="{{old('lastname')}}" name="lastname" placeholder="Last Name">
              </div>
              <label class="control-label col-sm-2" for="suffix">Suffix:</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="suffix" value="{{old('suffix')}}" name="suffix" placeholder="eg. II, Jr.">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-2" for="username">UN:</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="username" value="{{old('username')}}" name="username" placeholder="Username">
              </div>
              <label class="control-label col-sm-2" for="password">PW:</label>
              <div class="col-sm-4">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-2" for="password_confirmation">CP:</label>
              <div class="col-sm-4">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
              </div>
            </div>

            <div class="form-group"> 
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary btn-outline">Submit
                  <i class="fa fa-check" aria-hidden="true"></i>
                </button>
              </div>
            </div>
          </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>


{{-- update --}}
<div class="modal fade" id="edit-mngr">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Edit Sports Manager</h4>
      </div>
      <div class="modal-body">
            <form id="update-mngr-form" class="form-horizontal">

            {{ csrf_field() }}

            <div class="form-group">
              <label class="control-label col-sm-2" for="edit-firstname">FN:</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="edit-firstname" value="{{old('edit-firstname')}}" name="edit-firstname" placeholder="First Name">
              </div>
              <label class="control-label col-sm-2" for="edit-middlename">MN:</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="edit-middlename" value="{{old('edot-middlename')}}" name="edot-middlename" placeholder="Middle Name">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="edit-lastname">LN:</label>
              <div class="col-sm-4"> 
                <input type="text" class="form-control" id="edit-lastname" value="{{old('edit-lastname')}}" name="edit-lastname" placeholder="Last Name">
              </div>
              <label class="control-label col-sm-2" for="edit-suffix">Suffix:</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="edit-suffix" value="{{old('edit-suffix')}}" name="edit-suffix" placeholder="eg. II, Jr.">
              </div>
            </div>

            <div class="form-group">
              <label class="control-label col-sm-2" for="edit-username">UN:</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" id="edit-username" value="{{old('edit-username')}}" name="edit-username" placeholder="Username">
              </div>
            </div>

            <div class="form-group"> 
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary btn-outline">Update
                  <i class="fa fa-check" aria-hidden="true"></i>
                </button>
              </div>
            </div>
          </form>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>



@include('layouts.confirm-delete')

@endsection

@push('scripts')
<script type="text/javascript">
    $(function() {
        $('#sport-managers-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('manager.all') }}',
            columns: [
                {data: 'id'},
                {data: 'firstname'},
                {data: 'middlename'},
                {data: 'lastname'},
                {data: 'suffix'},
                {data: 'created_at'},
                {data: 'action'},
            ]
        });
    });

    var id;
  function deleteMngr(row) {
      $('#modal-confirm-delete .modal-body p').html('Are you sure you want to delete <strong>' + row.firstname +' '+ row.lastname +'</strong>?');
      $('#modal-confirm-delete').modal();

      id = row.id;
      console.log(id);
  }
  $('#btn-confirm-delete').click(function(event) {
        /* Act on the event */
        $.ajax({
            type: "DELETE",
            url: '{{ url('manager').'/' }}'+id,
            success: function (data) {
                
                $('#modal-confirm-delete').modal('hide');
                dataTableRefresh('#sport-managers-table', 7);
                printSuccessMsg(data.title, 'Deleted');

            },
            error: function (data) {
                console.log('Error:', data);
            }

        });

  });

  function editMngr(row){
    id = row.id;
    $('#edit-firstname').val(row.firstname)
    $('#edit-middlename').val(row.middlename)
    $('#edit-lastname').val(row.lastname)
    $('#edit-suffix').val(row.suffix)
    $('#edit-username').val(row.username)
    $('#edit-mngr').modal();

    console.log(row.username);
  }

  $('#update-mngr-form').submit(function(event) {
      /* Act on the event */
      event.preventDefault();

      var firstname = $('#edit-firstname').val();
      var middlename = $('#edit-middlename').val();
      var lastname = $('#edit-lastname').val();
      var suffix = $('#edit-suffix').val();
      var username = $('#edit-username').val();
        $.ajax({
            type: "PATCH",
            url: '{{ url('manager').'/' }}'+id,
            data: {
                firstname: firstname,
                middlename: middlename,
                lastname: lastname,
                suffix: suffix,
                username: username
            },
            success: function (data) {
                console.log(data);
                
                dataTableRefresh('#sport-managers-table', 7);
                printSuccessMsg(data.title, 'Updated');
                $('#edit-mngr').modal('hide');

            },
            error: function (data) {
                console.log('Error:', data);
            }

        });
  });

</script>
@endpush