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
                            <i class="fa fa-futbol-o" aria-hidden="true"></i>
                            {{ $event->year }} Schedule and Matches
                        </li>
                    </ol>
                </div>

                <div class="form-group">
                    <button id="btn-score-board" class="btn btn-success btn-outline">
                        <span class="glyphicon glyphicon-calendar"></span>
                    Score Board</button>
                </div>

                <table id="games-table" class="table table-striped table-condensed">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Sport</th>
                      <th>Medal Points</th>
                      <th>Manager</th>
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
<!-- /#wrapper -->



<div class="modal fade" id="modal-matches">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="matches-title">matches</h4>
            </div>
            <div class="modal-body">
                
                <table id="match-table" class="table table-striped table-condensed">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th>Team 1</th>
                      <th>Team 2</th>
                      <th>Schedule</th>
                      <th>Winner</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>






<div class="modal fade" id="modal-score">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{ $event->year }} Score Board</h4>
            </div>
            <div class="modal-body">
                

                <table id="score-table" class="table table-striped table-condensed">
                    <thead>
                    <tr>
                      <th>ID</th>
                      <th class="text-success">Team</th>
                      <th class="text-danger">Gold Medal</th>
                      <th class="text-primary">Silver Medal</th>
                      <th class="text-warning">Bronze Medal</th>
                      <th class="text-info">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection



@push('scripts')

<script type="text/javascript">
  $(function() {
            $('#games-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('welcome.yearSports', $event->id) }}',
                columnDefs: [
                    { "width": "250", "targets": 4 }
                ],
                columns: [
                    {data: 'id'},
                    {data: 'game'},
                    {data: 'medal_points'},
                    {data: 'manager'},
                    {data: 'action'},
                ]
            });
        });




function sportsMatches(row) {
    console.log(row);
    $('#matches-title').text(row.game + ' schedule and matches');

    var table = $('#match-table').DataTable({
                    processing: true,
                    serverSide: true,
                    bDestroy: true,
                    ajax: '{{ url('/year/scheduleAndMatches').'/' }}' + row.id,
                    columns: [
                        {data: 'id'},
                        {data: 'team1_id'},
                        {data: 'team2_id'},
                        {data: 'schedule'},
                        {data: 'winner_team_id'},
                    ]
                });

    $('#modal-matches').modal();
}


$('#btn-score-board').click(function(event) {
    /* Act on the event */
    $('#score-table').DataTable({
            processing: true,
            serverSide: true,
            bDestroy: true,
            ajax: '{{ route('welcome.scoreboard', $event->id) }}', 
            columns: [
                {data: 'id'},
                {data: 'description'}, //team
                {data: 'gold'},
                {data: 'silver'},
                {data: 'bronze'},
                {data: 'total'},
            ]
    });

    // $.ajax({
    {{-- //     url: '{{ route('welcome.scoreboard', $event->id) }}', --}}
    //     type: 'GET',
    //     success: function (data) {
    //         console.log(data);
    //     }
    // });

    
    $('#modal-score').modal();

});

</script> 

@endpush