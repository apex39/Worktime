@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit manager</div>
                    <div class="panel-body">
                        @include('flash::message')

                        <form class="form-horizontal" role="form" method="POST"
                              action="{{ url('/managers/edit/'.$user->id) }}">
                            {{ method_field('PATCH') }}
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                           value="{{  $user->name }}" required autofocus>

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
                                           value="{{ $user->surname }}" required autofocus>

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
                                           value="{{ $user->email }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="shops" class="col-md-4 control-label">Shops:</label>
                                <div class="col-md-6">
                                    <select class="selectpicker form-control" id="shops" name="shops[]" required
                                            multiple>
                                        @foreach ($shops as $shop)
                                            <option value="{{ $shop->id }}"
                                                    @if($user_shops->contains($shop))selected @endif >{{ $shop->address }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Edit manager
                                    </button>
                                    <button type="button" class="btn btn-primary pull-right" id="deleteButton">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </form>
                        <form class="delete form-horizontal" role="form" id="deleteForm" method="POST"
                              action="/managers/delete/{{ $user->id }}">
                            {{ method_field('DELETE') }}
                            {{ csrf_field() }}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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


        });
    </script>
@endsection
