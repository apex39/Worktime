@extends('layouts.app')
{!! Charts::assets() !!}
@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                   <div class="panel panel-default">
                    <div class="panel-heading">Worker details</div>
                    <div class="panel-body">

                        {!! $chart->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
