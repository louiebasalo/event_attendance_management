<!DOCTYPE html>
<html>
<head>
    <title>login</title>
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    <style type="text/css">
        body{
            background-color: rgba(20,30,40,.95);
        }
        #lform{
            margin-top: 200px;  
        }
        .card{
            background-color: rgba(255,255,255,1);
        }
        .card-body{
            background-color: ;
        }
        .form-control{
            text-align: center;
        }
        .head{
            padding: auto;
            text-align: center;
            margin-top: 30px
        }
    </style>
</head>
<body>

    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4" id="lform" >
            <div class="card" >
                <div class="head">
                    <center><h2>Login Admin</h2></center>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">

                            <div class="col-md-12">
                                <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required placeholder="ID" autofocus="">

                                @if ($errors->has('username'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required placeholder="password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="submit" class="form-control btn btn-primary">
                                    {{ __('Login') }}
                                </button> 
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12 ">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                     @if (Route::has('password.request'))
                                    <a class=" btn-link" style="float: right"href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12">
                               

                               
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>

