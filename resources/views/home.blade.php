<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://unpkg.com/vue@2.1.10/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('flash::message')

                <div class="panel panel-default">
                    <div class="panel-heading">Active workers</div>

                    @php ($record_index = 1)
                    <ul class="list-group">
                        @if($logged_workers != null)
                            @foreach ($logged_workers as $user)
                                <li class="list-group-item">
                                    <a href="/workers/details/{{ $user->id }}">{{$user->name}} {{$user->surname}}</a>

                                    @foreach($user->records as $record)
                                        @if($record->action_id == 1)
                                            <span class="pull-right">
                                                    <span class="timer" id="timer.{{$record_index}}"></span>
                                            </span>
                                            <span class="glyphicon glyphicon-pause pull-right"></span>

                                            @php ($record_index++)
                                        @elseif($record->action_id == 2)
                                            <span class="pull-right">
                                                    <span class="timer" id="timer.{{$record_index}}"></span>
                                            </span>
                                            <span class="glyphicon glyphicon-play pull-right"></span>
                                            @php ($record_index++)
                                        @endif
                                    @endforeach
                                </li>
                            @endforeach
                        @else
                            <h5>&nbsp;No active workers.</h5>
                        @endif
                    </ul>
                </div>
            </div>

        </div>

    </div>

    @if($logged_workers != null)
        <script>
            var timers = document.getElementsByClassName("timer");

            var dates = {!! json_encode($records_dates)!!};

            function updateClocks() {
                for (var i = 1; i <= timers.length; i++) {
                    var startDateTime = new Date(dates[i - 1].date);
                    var startStamp = startDateTime.getTime();
                    newDate = new Date();
                    newStamp = newDate.getTime();
                    var diff = Math.round((newStamp - startStamp) / 1000);

                    var h = Math.floor(diff / (60 * 60));
                    diff = diff - (h * 60 * 60);
                    var m = Math.floor(diff / (60));
                    diff = diff - (m * 60);
                    var s = diff;

                    document.getElementById("timer." + i).innerHTML = h + ":" + m + ":" + s;
                }
            }
            setInterval(updateClocks, 1000);
        </script>
    @endif
@endsection
