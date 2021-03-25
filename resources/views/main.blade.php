@extends('layouts.app')

@section('content')
@if (Auth::check())
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                @if (Session::has('message'))
                    <div class="alert alert-{{ Session::get('message')[1] }} alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ Session::get('message')[0] }}
                    </div>
                @endif
                <div class="panel-body">
                    @if(isset($users))
                        <div class="panel panel-default">
                            <div class="panel-heading">Users <a href="{{ route('users.create') }}" style="float:right;"><button type="button" class="btn btn-primary btn-md"  data-toggle="tooltip" data-placement="top" title="Add" aria-hidden="true"><span class="glyphicon glyphicon-plus"></span> Create User</button></a>
                            <table class="table table-striped">
                                <thead>
                                    <th>id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Date Created</th>
                                    <th>Date Updated</th>
                                    <th>&nbsp;</th>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->id}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{date("Y-m-d H:i:s",strtotime($user->created_at))}}</td>
                                        <td>{{date("Y-m-d H:i:s",strtotime($user->updated_at))}}</td>
                                        <td>
                                            <div class="col-xs-2 pull-right">
                                                <form class="form-horizontal" role="form" method="POST" action="{{ route('users.destroy',$user->id) }}" onsubmit="return destroyme();" >
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE')}}
                                                    <button type="submit" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="top" title="Delete" aria-hidden="true"><span class="glyphicon glyphicon-trash"></span></button>
                                                </form>
                                            </div>
                                            <div class="col-xs-2 pull-right">
                                                <a href="{{ route('users.edit',$user->id) }}"><button type="button" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="top" title="Edit" aria-hidden="true"><span class="glyphicon glyphicon-pencil"></span></button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{$users->links()}}
                        </div>
                    @else
                        Welcome to User Management click <a href="{{ route('users.index') }}">Manage Users</a> to start.
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-sign-in"></i> Login
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<script type="text/javascript">
function destroyme(id){
    var r = confirm("Are you sure you want to delete user id: "+id+"?");
    return r;
}
</script>
@endsection
