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
                    <a class="btn btn-success btn-outline" data-toggle="modal" href='#modal-score'>
                        <span class="glyphicon glyphicon-calendar"></span>
                    Score Board</a>
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





<div class="modal fade" id="modal-score">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

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

</script> 

@endpush