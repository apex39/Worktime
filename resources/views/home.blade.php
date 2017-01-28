@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('flash::message')

                <div class="panel panel-default">
                    <div class="panel-heading">Active workers</div>

                    <ul class="list-group">
                        @foreach ($logged_workers as $user)
                            <li class="list-group-item">
                                <a href="/workers/details/{{ $user->id }}">{{$user->name}} {{$user->surname}}</a>

                                @foreach($user->records as $record)
                                    @if($record->action_id == 1)
                                        <span class="pull-right">
                                                <span class="timer" id="timer.{{$record->id}}"></span>
                                        </span>
                                        <span class="glyphicon glyphicon-play pull-right"></span>
                                    @endif
                                    @if($record->action_id == 2)
                                        <span class="pull-right">
                                                <span class="timer" id="timer.{{$record->id}}"></span>
                                        </span>
                                        <span class="glyphicon glyphicon-pause pull-right"></span>
                                    @endif
                                @endforeach
                            </li>

                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script>
        var timers = document.getElementsByClassName("timer");

        var dates = {!! json_encode($records_dates)!!};

        function updateClocks() {
            for(var i=1; i<=timers.length; i++) {
                var startDateTime = new Date(dates[i-1].date);
                var startStamp = startDateTime.getTime();
                newDate = new Date();
                newStamp = newDate.getTime();
                var diff = Math.round((newStamp-startStamp)/1000);

                var h = Math.floor(diff/(60*60));
                diff = diff-(h*60*60);
                var m = Math.floor(diff/(60));
                diff = diff-(m*60);
                var s = diff;

                document.getElementById("timer."+i).innerHTML = h+":"+m+":"+s;
            }
        }
        setInterval(updateClocks, 1000);
    </script>
@endsection
