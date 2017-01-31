@extends('layouts.app')
@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Worker details</div>
                    <div class="panel-body">
                        <div id="chart_div"></div>
                        <h5>Shop: {{$user->shops->first()->address}}</h5>
                        <h5>Working hours: {{$user->working_hours}}</h5>
                        <h5>Punctuality: {{$user->punctuality()}}</h5>
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