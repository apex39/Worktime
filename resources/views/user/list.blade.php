@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
                    @include('flash::message')

            <div class="panel panel-default">
                <a href="/managers/add" class="btn btn-default pull-right">Add</a>
                <div class="panel-heading"><b>{{ $pageName }}</b></div>
                
                <ul class="list-group">
                    @foreach ($users as $user)
                        <a href="/managers/edit/{{ $user->id }}" class="list-group-item clearfix">{{ $user->name." ".$user->surname }}                    
                        </a>
                    @endforeach
                </ul>   
            </div>
        </div>
    </div>
</div>
@endsection
