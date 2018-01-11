@extends('layouts.app2')

@section('sidebar')
    @include('layouts.admin-sidebar2')
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
            </div>
            <!-- /.col-lg-12 -->
        </div>

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
@endsection
