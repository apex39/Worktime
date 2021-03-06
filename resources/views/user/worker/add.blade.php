@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Add worker</div>
                    <div class="panel-body">
                        @include('flash::message')

                        <form class="form-horizontal" role="form" method="POST"
                              action="{{ url('/workers/add/'.$worker_id) }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Worker ID</label>

                                <div class="col-md-6">
                                    <input id="worker_id" type="text" class="form-control" name="name"
                                           value="{{ $worker_id }}" disabled>

                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('surname') ? ' has-error' : '' }}">
                                <label for="surname" class="col-md-4 control-label">Surname</label>

                                <div class="col-md-6">
                                    <input id="surname" type="text" class="form-control" name="surname"
                                           value="{{ old('surname') }}" required autofocus>

                                    @if ($errors->has('surname'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('surname') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email"
                                           value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('working_hours') ? ' has-error' : '' }}">
                                <label for="working_hours" class="col-md-4 control-label">Working hours per day</label>

                                <div class="col-md-6">
                                    <input id="working_hours" type="number" min=1 class="form-control"
                                           name="working_hours" value=8 required autofocus>

                                    @if ($errors->has('working_hours'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('working_hours') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="shops" class="col-md-4 control-label">Shop:</label>
                                <div class="col-md-6">
                                    <select class="selectpicker form-control" id="shops" name="shops[]" required>
                                        @foreach ($shops as $shop)
                                            <option value={{ $shop->id }}>{{ $shop->address }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Add worker
                                    </button>

                                </div>
                            </div>
                            Note: Each worker will be prompted for a new password at first login.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
