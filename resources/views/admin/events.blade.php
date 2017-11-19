@extends('layouts.app')

@section('sidebar')
    @include('layouts.admin-sidebar')
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
                            Events
                        </li>
                    </ol>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        {{-- content --}}
        <div class="row">
            <a href="#" class="btn btn-default"><i class="fa fa-plus-circle" aria-hidden="true"></i>
                New Event
            </a>
        </div>
        {{-- / content --}}
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
@endsection