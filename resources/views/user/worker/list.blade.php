@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('flash::message')

                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title pull-left" style="padding-top: 7.5px;"><b>Workers</b></h4>
                        <a href="/workers/add" class="btn btn-default pull-right btn-sm">Add</a>
                    </div>

                    <ul class="list-group">
                        @foreach ($shops as $shop)
                            <h4 class="panel-title list-group-item">
                                <a data-toggle="collapse" href="#collapse{{ $shop->id }}">{{ $shop->address }}</a>
                            </h4>

                            <div id="collapse{{ $shop->id }}" class="panel-collapse collapse">
                                <ul class="list-group">

                                    {{--Two loops over the users as we want list of managers on top --}}
                                    @foreach($shop->users as $user)
                                        @if($user->checkRole("manager"))
                                            <li class="list-group-item"><span class="glyphicon glyphicon-user"></span>
                                                {{$user->name}} {{$user->surname}}
                                                @if ($isAdmin)
                                                    <a href="/managers/edit/{{ $user->id }}" class="btn-xs pull-right">Edit</a>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach

                                    @foreach($shop->users as $user)
                                        @if($user->checkRole("worker"))
                                            <li class="list-group-item">
                                                <a href="/workers/details/{{ $user->id }}">{{$user->name}} {{$user->surname}}</a>
                                                <a href="/workers/edit/{{ $user->id }}"
                                                   class="btn-xs pull-right">Edit</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
