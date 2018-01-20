@extends('layouts.app')

@section('sidebar')
    @include('layouts.user-sidebar')
@endsection

@section('content')
 <div id="wrapper">

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <ol class="breadcrumb">
                        <li class="active">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            Home
                        </li>
                    </ol>
                </div>

                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Message:</strong> Please choose year.
                </div>

            </div>
            <!-- /.col-lg-12 -->
        </div>

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
@endsection
