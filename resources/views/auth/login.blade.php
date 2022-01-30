<!DOCTYPE html>
<html>
  @include('layouts.head')
  <body class="app">
    <div class="min-vh-100 d-flex justify-content-center align-items-center w-100">
        <div class="login__card">
            <h2 class="text-center pb-3">{{ config('app.name') }}</h2>
            <form action="{{ url('/login') }}" role="form" method="post" accept-charset="utf-8" novalidate="novalidate">
                {{csrf_field()}}

                <div class="mb-3 position-relative">
                    <input
                        id="username"
                        type="text"
                        name="username"
                        value=""
                        class="form-control inventory__input__fill"
                        autofocus="1"
                        data-rule-required="1"
                        data-msg-required="This field is required."
                        aria-required="true"
                        placeholder="Username">
                    <span class="text-danger">{{ $errors->has('username') ? $errors->first('username') : '' }}</span>

                    <span class="icon-holder lock__icon">
                        <i class="c-blue-500 ti-user"></i>
                    </span>
                </div>

                <div class="mb-3 position-relative">
                    <input
                        id="password"
                        type="password"
                        class="form-control inventory__input__fill"
                        name="password"
                        value=""
                        data-rule-required="1"
                        data-msg-required="This field is required."
                        aria-required="true"
                        placeholder="Password">
                    <span class="text-danger">{{$errors->has('password') ? $errors->first('password') : ''}}</span>

                    <span class="icon-holder lock__icon">
                        <i class="c-blue-500 ti-unlock"></i>
                    </span>
                </div>

                <div class="peers ai-c jc-sb fxw-nw mb-3">
                    <div class="peer">
                        <div class="checkbox checkbox-circle checkbox-info peers ai-c">
                            <input class="peer" type="checkbox" name="remember" id="inputCall1" {{ old('remember') ? 'checked' : '' }}>
                            <label for="inputCall1" class=" peers peer-greed js-sb ai-c form-label">
                                <span class="peer peer-greed">Remember Me</span>
                            </label>
                        </div>
                    </div>

                    <a href="{{url('request_reset_password')}}">
                        forgot password
                    </a>
                </div>

                <div class="peers ai-c jc-sb fxw-nw">
                    <button class="btn btn-primary btn-color w-100">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
