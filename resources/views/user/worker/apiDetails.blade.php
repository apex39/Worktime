<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if($records->count() > 0)
                        <div id="chart_div"></div>
                    @endif
                    <h5>Allowed break time: <b>{{$user->shops->first()->break_time}}</b> minutes</h5>
                    <h5>Working hours: <b>{{$user->working_hours}}</b></h5>
                    @if($records->count() > 0)
                        <h5>Punctuality: <b>{{$user->punctuality()}}</b></h5>
                        <h5>Work coverage: <b>{{$user->workCoverage()}}</b>%</h5>
                        <h5>Average daily number of breaks: <b>{{$user->averageDailyBreaks()}}</b></h5>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Scripts -->
<script src="/js/app.js"></script>
</body>

</html>
<!--Load the AJAX API-->
@if($records->count() > 0)

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
        google.charts.load("current", {packages: ["timeline"]});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var container = document.getElementById('chart_div');
            var chart = new google.visualization.Timeline(container);
            var dataTable = new google.visualization.DataTable();
            dataTable.addColumn({type: 'string', id: 'Type'});
            dataTable.addColumn({type: 'string', id: 'Name'});
            dataTable.addColumn({type: 'date', id: 'Start'});
            dataTable.addColumn({type: 'date', id: 'End'});
            dataTable.addRows([

                    @foreach($records as $record)
                [@if($record->action_id == '2')"Work"
                    @elseif($record->action_id == '1')"Break"
                    @endif, "{{$record->duration()}}", new Date({{$record->created_at->year}}, {{$record->created_at->month-1}}, {{$record->created_at->day}}, {{$record->created_at->hour}}, {{$record->created_at->minute}}, {{$record->created_at->second}}),
                    new Date({{$record->updated_at->year}}, {{$record->updated_at->month-1}}, {{$record->updated_at->day}}, {{$record->updated_at->hour}}, {{$record->updated_at->minute}}, {{$record->updated_at->second}})],
                @endforeach
            ]);
            var options = {
                timeline: {colorByRowLabel: true}
            };
            chart.draw(dataTable, options);
        }
    </script>
@endif