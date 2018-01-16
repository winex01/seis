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

                @include('flash::message')

                <div class="form-group">
                  <a class="btn btn-default" data-toggle="modal" href='#modal-match'>
                      <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                      Match Schedule
                  </a>
                </div>


                <table id="match-table" class="table table-striped table-condensed">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Team 1</th>
                      <th>Team 2</th>
                      <th>Schedule</th>
                      <th>Winner</th>
                      <th><center>Action</center></th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                

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
                    <form class="form-horizontal" method="POST" action="{{ route('match.store') }}">

                        {{ csrf_field() }}

                        <input type="hidden" name="game_id" value="{{ $game->id }}">

                        <div class="col-sm-5">
                          <div class="form-group">
                            <label for="team1_id">Team 1:</label>
                            <select class="form-control" id="team1_id" name="team1_id">
                              @foreach($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->description }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>

                        <div class="col-sm-2"></div>
                        
                        <div class="col-sm-5">
                           <div class="form-group">
                            <label for="team2_id">Team 2:</label>
                            <select class="form-control" id="team2_id" name="team2_id">
                              @foreach($teams as $team)
                                <option value="{{ $team->id }}">{{ $team->description }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>

                        <div class="col-sm-2"></div>
                        <div class="col-sm-8">
                          <div class="form-group">
                            <label for="dtp_input1" class="control-label">Schedule</label>
                            <div class="input-group date form_datetime" data-date="{{ \Carbon\Carbon::now()->toDateTimeString() }}" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                                <input class="form-control" size="16" type="text" value="" readonly>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                                <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                            </div>
                          <input type="hidden" id="dtp_input1" name="schedule" value="" /><br/>
                         </div>
                        </div>
                        <div class="col-sm-2"></div>
                         

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save
                  <span class="glyphicon glyphicon-save" aria-hidden="true"></span>
                </button>
                    </form>
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

<script type="text/javascript">
  $(function() {
        $('#match-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('match.all', $game->id) }}',
            columns: [
                {data: 'id'},
                {data: 'team1_id'},
                {data: 'team2_id'},
                {data: 'schedule'},
                {data: 'winner_team_id'},
                {data: 'action'},
            ]
        });
    });


</script> 

@endpush

