@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('flash::message')

                <div class="panel panel-default ">
                    <div class="panel-heading clearfix">
                        @if ($isAdmin)
                            <h4 class="panel-title pull-left" style="padding-top: 7.5px;"><b>Shops</b></h4>
                            <a href="/shops/add" class="btn btn-default pull-right btn-sm">Add</a>
                        @else
                            <h4 class="panel-title pull-left" style="padding-top: 7.5px;padding-bottom: 4.5px">
                                <b>Shops</b></h4>
                        @endif
                    </div>

                    <ul class="list-group">
                        @foreach ($shops as $shop)
                            <h4 class="panel-title list-group-item">
                                <a class="list-group-item-heading">{{ $shop->address }}
                                    {{--Remove three last characters from the time for a nice view--}}
                                    <small>Opening hours: {{ substr($shop->opening_time, 0, -3)  }}
                                        - {{ substr($shop->closing_time, 0, -3) }}
                                        Break time: {{$shop->break_time}} minutes
                                    </small>
                                </a>
                                <a href="/shops/edit/{{ $shop->id }}" class="btn-xs pull-right">Edit</a>
                            </h4>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
