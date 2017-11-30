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
                            Game Types</li>
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
                        New Game
                    </a>
                </div>


                <table id="gametype-table" class="table table-striped table-condensed">
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
                {{-- / content --}}
            </div>
        </div>
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

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
                {data: 'created_at'},
                {data: 'action'},
            ]
        });
    });




</script>
@endpush