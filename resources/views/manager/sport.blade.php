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

                {{-- flash --}}
                @include('flash::message')
                {{-- @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}
                @include('layouts.validation-errors')
                {{-- custom --}}
                @include('layouts.flash-success')
                {{-- end flash --}}


                <div class="form-group">
                  <a class="btn btn-default" data-toggle="modal" href='#modal-match'>
                      <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
                      Match Schedule
                  </a>

                  <a class="btn btn-primary btn-outline" data-toggle="modal" href='#modal-overall-winner'>
                      <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span>
                      Overall Winner
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



{{-- modal set result --}}
<div class="modal fade" id="modal-set-result">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Match Result</h4>
            </div>
            <div class="modal-body">
            
                <input type="hidden" name="match_id" id="match_id">                

                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-8">
                        <div class="form-group">
                          <label for="win">Select winner:</label>
                          <select class="form-control" id="win">
                          </select>
                        </div>
                    </div>
                    <div class="col-sm-2"></div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="submit-save-winner" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="modal-overall-winner">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Overall Winner of {{ ucwords($game->game) }}</h4>
            </div>
            <div class="modal-body">

                <form method="POST" action="{{ route('assign.medals') }}">

                    {{ csrf_field() }}

                    <input type="hidden" name="game_id" value="{{ $game->id }}">

                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                              <label for="gold-medal" class="text-danger">Gold Medal:</label>
                              <select class="form-control" id="gold-medal" name="gold_team_id">
                                <option value="">None</option>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}" {{ ($team->id == $game->gold_team_id) ? 'selected' : '' }} >{{ $team->description }}</option>
                                @endforeach
                              </select>
                            </div>
                        </div>
                        <div class="col-sm-3"></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                              <label for="silver-medal" class="text-primary">Silver Medal:</label>
                              <select class="form-control" id="silver-medal" name="silver_team_id">
                                <option value="">None</option>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}" {{ ($team->id == $game->silver_team_id) ? 'selected' : '' }} >{{ $team->description }}</option>
                                @endforeach
                              </select>
                            </div>
                        </div>
                        <div class="col-sm-3"></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3"></div>
                        <div class="col-sm-6">
                            <div class="form-group">
                              <label for="bronze-medal" class="text-warning">Bronze Medal:</label>
                              <select class="form-control" id="bronze-medal" name="bronze_team_id">
                                <option value="">None</option>
                                @foreach($teams as $team)
                                    <option value="{{ $team->id }}" {{ ($team->id == $game->bronze_team_id) ? 'selected' : '' }} >{{ $team->description }}</option>
                                @endforeach
                              </select>
                            </div>
                        </div>
                        <div class="col-sm-3"></div>
                    </div>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>


@include('layouts.confirm-delete')

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


  // set result
  function setResult(row1, row2, match) {
    // console.log(match);
    $('#match_id').val(match.id);

    $('#win').html('');
    $('#win').append('<option value="'+row1.id+'">'+row1.description+'</option>');
    $('#win').append('<option value="'+row2.id+'">'+row2.description+'</option>');

    if (match.winner_team_id != null) {
        $('#win').val(match.winner_team_id);
    }

    $('#modal-set-result').modal();
  }
  // 
  $('#submit-save-winner').click(function(event) {
      /* Act on the event */
      $.ajax({
            url: '{{ route('match.setWinner') }}',
            type: 'POST',
            data: {
                match_id: $('#match_id').val(),
                team_winner_id: $('#win').val()
            },
            success: function (data) {
                console.log(data);

                $('#modal-set-result').modal('hide');
                dataTableRefresh('#match-table', 6);
                printSuccessMsg(data.title, 'Updated');
            }
        });
  });

  var id;
  function removeMatch(row) {
      $('#modal-confirm-delete .modal-body p').html('Are you sure you want to delete this <strong>match</strong>?');
      $('#modal-confirm-delete').modal();

      id = row.id;
  }
  $('#btn-confirm-delete').click(function(event) {
        /* Act on the event */
        $.ajax({
            type: "DELETE",
            url: '{{ url('manager/match').'/' }}'+id,
            success: function (data) {
                
                $('#modal-confirm-delete').modal('hide');
                dataTableRefresh('#match-table', 6);
                printSuccessMsg(data.title, 'Deleted');

            },
            error: function (data) {
                console.log('Error:', data);
            }

        });

  });

</script> 

@endpush

