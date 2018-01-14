@extends('layouts.app2')

@section('sidebar')
    @include('layouts.admin-sidebar2')
@endsection

@section('content')
 <div id="wrapper">

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-header">
                    <ol class="breadcrumb">
                        <li class="active">
                            <strong>
                                <i class="fa fa-circle-thin" aria-hidden="true"></i>
                                {{ $game->game . ' Matches'}}
                            </strong>
                        </li>
                    </ol>
                </div>

                <a class="btn btn-default" data-toggle="modal" href='#modal-match'>
                    <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                    Match Schedule
                </a>


            </div>
            <!-- /.col-lg-12 -->
        </div>

    </div>
    <!-- /#page-wrapper -->

</div>




<div class="modal fade" id="modal-match">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add Match and Schedule</h4>
            </div>
            <div class="modal-body">
                
                <div class="container-fluid">
                    <form class="form-horizontal" action="">

                        {{ csrf_field() }}


                        

                        <div class="form-group">
                          <label for="dtp_input1" class="col-md-2 control-label">Schedule</label>
                          <div class="input-group date form_datetime col-md-6" data-date="1979-09-16T05:25:07Z" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                              <input class="form-control" size="16" type="text" value="" readonly>
                              <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                              <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                          </div>
                        <input type="hidden" id="dtp_input1" value="" /><br/>
                       </div>





                    </form>
                </div>

            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>


<!-- /#wrapper -->
@endsection

@push('heads')

  <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">

@endpush


@push('scripts')
   
  <script src="{{ asset('js/bootstrap-datetimepicker.js') }}"></script>

  <script src="{{ asset('js/bootstrap-datetimepicker.fr.js') }}"></script>

  <script type="text/javascript">
    $('.form_datetime').datetimepicker({
        //language:  'fr',
        weekStart: 1,
        todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    forceParse: 0,
        showMeridian: 1
    });
  $('.form_date').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    minView: 2,
    forceParse: 0
    });
  $('.form_time').datetimepicker({
        language:  'fr',
        weekStart: 1,
        todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 1,
    minView: 0,
    maxView: 1,
    forceParse: 0
    });
</script> 

@endpush