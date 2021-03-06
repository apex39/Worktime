@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit worker</div>
                    <div class="panel-body">
                        @include('flash::message')

                        <form class="form-horizontal" role="form" method="POST"
                              action="{{ url('/workers/edit/'.$user->id) }}">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}


                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="username" class="col-md-4 control-label">Worker ID</label>

                                <div class="col-md-6">
                                    <input id="username" type="text" class="form-control" name="username"
                                           value="{{ $user->username }}">
                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{ $user->name  }}" required autofocus>

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
                                           value="{{ $user->surname  }}" required autofocus>

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
                                           value="{{ $user->email  }}" required>

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
                                           name="working_hours" value={{ $user->working_hours  }} required autofocus>

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
                                        Edit worker
                                    </button>

                                    <button type="button" class="btn btn-primary pull-right" style="margin-left: 7.5px;"
                                            id="deleteButton">
                                        Delete
                                    </button>
                                    <button type="button" class="btn btn-primary pull-right" id="resetButton">
                                        Reset Password
                                    </button>

                                </div>
                            </div>
                        </form>
                        <form class="delete form-horizontal" role="form" id="deleteForm" method="POST"
                              action="/workers/delete/{{ $user->id }}">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}

                        </form>
                        <form class="form-horizontal" role="form" id="resetForm" method="POST"
                              action="/workers/reset/{{ $user->id }}">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--TODO: Extract this "are you sure" script to separate file in order to be included to each edit--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="{{ URL::asset('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript"
            src="{{ URL::asset('https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            /* Login button click handler */
            $('#deleteButton').click(function (event) {
                bootbox.confirm({
                        size: "small",
                        message: "Are you sure?",
                        callback: function (result) {
                            event.preventDefault();
                            if (result) {
                                $("#deleteForm").submit();
                            }

                        }
                    }
                );
            });

            $('#resetButton').click(function (event) {
                bootbox.confirm({
                        size: "small",
                        message: "Are you sure?",
                        callback: function (result) {
                            event.preventDefault();
                            if (result) {
                                $("#resetForm").submit();
                            }

                        }
                    }
                );
            });
        });
    </script>
@endsection
