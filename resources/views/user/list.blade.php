@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @include('flash::message')

                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <h4 class="panel-title pull-left" style="padding-top: 7.5px;"><b>Managers</b></h4>
                        <a href="/managers/add" class="btn btn-default pull-right btn-sm">Add</a>
                    </div>

                    <ul class="list-group">
                        @foreach ($users as $user)
                            <a href="/managers/edit/{{ $user->id }}"
                               class="list-group-item clearfix">{{ $user->name." ".$user->surname }}
                            </a>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
