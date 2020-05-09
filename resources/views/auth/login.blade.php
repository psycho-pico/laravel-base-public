@extends('layouts.plain')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card">
                <div class="card-body">
                    <h3 class="mb-1">{{__('Hi again')}}</h3>
                    @php
                        $greet = 'Please login..';
                        if (date('H') > 0) $greet = 'Overtime? Really?!';
                        if (date('H') > 6) $greet = 'Good morning. Have a great day!';
                        if (date('H') > 12) $greet = 'Good afternoon. How\'s your day?';
                        if (date('H') > 17) $greet = 'Good evening';
                        if (date('H') > 22) $greet = 'Good night. Overtime?';
                    @endphp
                    <div class="mb-4 secondary-text">{{__($greet)}}</div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row">
                            <div class="col-xs-12 col-sm-12">
                                <div class="form-label-group">
                                    <input id="username" type="username" spellcheck="false" placeholder="Username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                                    <label for="username" class="form-label">{{ __('Username') }}</label>
                                    @error('username')
                                        <div class="invalid-feedback" role="alert">
                                            <span>{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12">
                                <div class="form-label-group">
                                    <input id="password" type="password" spellcheck="false" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    <label for="password" class="form-label">{{ __('Password') }}</label>
                                    @error('password')
                                        <div class="invalid-feedback" role="alert">
                                            <span>{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3 mt-3">
                            <div class="col-xs-12 col-sm-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-sm-12">
                                <button type="submit" class="btn btn-primary btn-block btn-lg">
                                    {{ __('Login') }}
                                </button>
                                <a href="#!" class="btn btn-link forgot-password-btn" data-toggle="modal" data-target="#infoModal">{{ __('Forgot your password?') }}</a>
                                {{-- @if (Route::has('password.request'))
                                    <a class="btn btn-link forgot-password-btn" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content card">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          {{__('Hi, please ask your admin to recover your password')}}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">{{__('Okay')}}</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('footer')
    {{-- <script type="text/javascript">
        $('.forgot-password-btn').on('click', function(e) {
            e.preventDefault();
            alert('asd');
        });
    </script> --}}
@endsection
