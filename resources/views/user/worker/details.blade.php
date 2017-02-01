@extends('layouts.app')
@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">{{$user->name}} {{$user->surname}}: {{$user->worker_id}} - worker details</div>
                    <div class="panel-body">
                        <div id="chart_div"></div>
                        <h5>Shop:<b> {{$user->shops->first()->address}}</b></h5>
                        <h5>Opening hours: <b>{{ substr($user->shops->first()->opening_time, 0, -3)  }} - {{ substr($user->shops->first()->closing_time, 0, -3) }}</b></h5>
                        <h5>Break time: <b>{{$user->shops->first()->break_time}}</b> minutes</h5>
                        <hr>
                        <h5>Working hours: <b>{{$user->working_hours}}</b></h5>
                        <h5>Punctuality: <b>{{$user->punctuality()}}</b></h5>
                        <h5>Work coverage: <b>{{$user->workCoverage()}}</b>%</h5>
                        <h5>Average daily number of breaks: <b>{{$user->averageDailyBreaks()}}</b></h5>

                        <h5>E-mail: <a href="mailto:".{{$user->email}}>{{$user->email}}</a></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<!--Load the AJAX API-->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
    google.charts.load("current", {packages:["timeline"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {

        var container = document.getElementById('chart_div');
        var chart = new google.visualization.Timeline(container);
        var dataTable = new google.visualization.DataTable();
        dataTable.addColumn({ type: 'string', id: 'Type' });
        dataTable.addColumn({ type: 'string', id: 'Name' });
        dataTable.addColumn({ type: 'date', id: 'Start' });
        dataTable.addColumn({ type: 'date', id: 'End' });
        dataTable.addRows([

                @foreach($records as $record)
            [@if($record->action_id == '1')"Work"
                @elseif($record->action_id == '2')"Break"
                @endif,"{{$record->duration()}}",new Date({{$record->created_at->year}}, {{$record->created_at->month-1}}, {{$record->created_at->day}}, {{$record->created_at->hour}}, {{$record->created_at->minute}}, {{$record->created_at->second}}),
                new Date({{$record->updated_at->year}}, {{$record->updated_at->month-1}}, {{$record->updated_at->day}}, {{$record->updated_at->hour}}, {{$record->updated_at->minute}}, {{$record->updated_at->second}})],
            @endforeach
        ]);
        var options = {
            timeline: { colorByRowLabel: true }
        };
        chart.draw(dataTable, options);
    }
</script>