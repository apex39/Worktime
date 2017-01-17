@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $pageName }}</div>
                <div class="panel-body">
                    @include('flash::message')

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/shops/edit/'.$shop->id) }}">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="address" class="col-md-4 control-label">Address</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" value="{{ $shop->address }}" required autofocus>

                                @if ($errors->has('address'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">Phone</label>

                            <div class="col-md-6">
                                <input id="phone" type="tel" class="form-control" name="phone" value="{{ $shop->phone }}" required autofocus>

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('opening_time') ? ' has-error' : '' }}">
                            <label for="opening_hours" class="col-md-4 control-label">Opening hours</label>

                            <div class="col-md-6 form-inline">
                                <input id="opening_time" type="number" class="form-control"
                                       name="opening_time" value="{{ $shop->opening_hour }}"
                                       min="0" max="23" required autofocus>

                                @if ($errors->has('opening_time'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('opening_time') }}</strong>
                                </span>
                                @endif
                                -
                                <input id="closing_time" type="number" class="form-control"
                                       name="closing_time" value="{{ $shop->closing_hour }}"
                                       min="0" max="23" required autofocus>

                                @if ($errors->has('closing_time'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('closing_time') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('break_time') ? ' has-error' : '' }}">
                            <label for="break_time" class="col-md-4 control-label">Break time (min)</label>

                            <div class="col-md-6 form-inline">
                                <input id="break_time" type="number" class="form-control" name="break_time"
                                       value="{{ $shop->break_time }}" min="0" required autofocus>

                                @if ($errors->has('break_time'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('break_time') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                {{ $pageName }}
                            </button>

                        </div>
                    </div>
                </form>
                             <form class="delete form-horizontal" role="form" id="deleteForm" method="POST" action="/shops/delete/{{ $shop->id }}">
                             {{ method_field('DELETE') }}
                              {{ csrf_field() }}
                            <button type="button" class="btn btn-primary pull-right" id="deleteButton" >
                                Delete
                            </button>
                    </form>
            </div>
        </div>
    </div>
</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="{{ URL::asset('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js') }}"></script>
<script>

    $(document).ready(function() {
        /* Login button click handler */
        $('#deleteButton').click(function(event) {
            bootbox.confirm({ 
              size: "small",
              message: "Are you sure?", 
          callback: function(result){            
            event.preventDefault();
            if (result) {
                $( "#deleteForm" ).submit();
            }

          } 
      }
      );
        });

    });
</script>
@endsection
