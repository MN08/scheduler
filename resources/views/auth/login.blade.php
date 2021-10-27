@extends('auth.app')

@section('content')

                    <p class="margin-bottom-0">
                        Selamat Datang Kembali
                    </p>

                    <form class="sky-form" method="POST" action="{{ route('login') }}">
                        @csrf

                        <fieldset>
                            <section>
                                <label class="label" for="email">Email</label>
                                <label class="input">
                                    <i class="icon-append fa fa-envelope"></i>
                                    <input id="email" type="email" class="form-control @error('email') invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    <span class="tooltip tooltip-top-right">Email Address</span>

                                    @error('email')
                                        <small class="text-danger" role="alert">{{ $message }}</small>
                                    @enderror
                                </label>
                            </section>

                            <section>
                                <label class="label" for="password">Password</label>
                                <label class="input">
                                    <i class="icon-append fa fa-lock"></i>
                                    <input id="password" type="password" class="form-control @error('password') invalid @enderror" name="password" required autocomplete="current-password">
                                    <b class="tooltip tooltip-top-right">Type your Password</b>

                                    @error('password')
                                        <small class="text-danger" role="alert">{{ $message }}</small>
                                    @enderror
                                </label>
                                <a class="custom-forgot-password" href="{{ route('password.request') }}">Forgot Your Password?</a>
                                <label class="checkbox pull-left">
                                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}><i></i> Ingat Saya
                                </label>
                            </section>

                            <button type="submit" class="margin-top-20 btn btn-primary btn-block btn-sm pull-right">Masuk</button>
                        </fieldset>
                    </form>

@endsection
