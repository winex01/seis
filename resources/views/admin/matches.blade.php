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

                        <li>
                            <i class="fa fa-calendar-o"></i> 
                            <a href="{{ route('event.index') }}">{{ $event->year }}</a>
                        </li>

                        <li class="active">
                            <i class="fa fa-users"></i> 
                            Matches</li>
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
                <h4 class="modal-title">Available Games</h4>
            </div>
            <div class="modal-body">
                

                

                
            </div>
        </div>
    </div>
</div>



@include('layouts.confirm-delete')

@endsection

@push('scripts')
    
@endpush