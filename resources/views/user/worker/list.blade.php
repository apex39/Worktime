@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @include('flash::message')

            <div class="panel panel-default">
                <a href="/workers/add" class="btn btn-default pull-right">Add</a>
                <div class="panel-heading"><b>{{ $pageName }}</b></div>
                
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
                                        <li class="list-group-item">{{$user->name}} {{$user->surname}} <span class="glyphicon glyphicon-user"></span>
                                            <a href="/managers/edit/{{ $user->id }}" class="btn-xs pull-right">Edit</a>
                                        </li>
                                    @endif
                                @endforeach

                                @foreach($shop->users as $user)
                                    @if($user->checkRole("worker"))
                                        <li class="list-group-item">{{$user->name}} {{$user->surname}}
                                            <a href="/workers/edit/{{ $user->id }}" class="btn-xs pull-right">Edit</a>
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
