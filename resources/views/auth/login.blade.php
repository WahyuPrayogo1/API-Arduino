<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta20
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Login Absensi</title>
    <!-- CSS files -->
    <link href="{{asset('backend/css/tabler.min.css?1692870487')}}" rel="stylesheet"/>
    <link href="{{asset('backend/css/tabler-flags.min.css?1692870487')}}" rel="stylesheet"/>
    <link href="{{asset('backend/css/tabler-payments.min.css?1692870487')}}" rel="stylesheet"/>
    <link href="{{asset('backend/css/tabler-vendors.min.css?1692870487')}}" rel="stylesheet"/>
    <link href="{{asset('backend/css/demo.min.css?1692870487')}}" rel="stylesheet"/>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>

    <link rel="icon" href="{{ asset('backend/img/logo-absen (2).png') }}" type="image/x-icon">


  </head>
  <body  class=" d-flex flex-column">
    <script src="{{asset('backend/js/demo-theme.min.js?1692870487')}}"></script>
    <div class="page page-center">
        <div class="container container-normal py-4">
          <div class="row align-items-center g-4">
            <div class="col-lg">
              <div class="container-tight">
                <div class="text-center mb-4">
                  <a href="{{ url('/') }}" class="navbar-brand navbar-brand-autodark">
                    <img src="{{ asset('backend/img/logo-absen (2).png') }}" height="100" width="100%" alt="Logo">
                  </a>
                </div>
                <div class="card card-md">
                  <div class="card-body">
                    <h2 class="h2 text-center mb-4">Login Dulu Bang</h2>
                    <form method="POST" action="{{ route('login') }}" autocomplete="off" novalidate>
                      @csrf
                      <div class="mb-3">
                        <label class="form-label">Email address</label>
                        <input type="email" class="form-control" name="email" placeholder="your@email.com" value="{{ old('email') }}" required autofocus>
                        @error('email')
                          <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                      </div>
                      <div class="mb-2">
                        <label class="form-label">
                          Password
                          {{-- <span class="form-label-description">
                            <a href="{{ route('password.request') }}">I forgot password</a>
                          </span> --}}
                        </label>
                        <div class="input-group input-group-flat">
                          <input type="password" class="form-control" name="password" placeholder="Your password" required>
                          <span class="input-group-text">
                            <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"/>
                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"/>
                              </svg>
                            </a>
                          </span>
                        </div>
                        @error('password')
                          <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                      </div>

                      <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">Sign in</button>
                      </div>
                    </form>
                  </div>
                </div>

              </div>
            </div>
            <div class="col-lg d-none d-lg-block">
              <img src="{{ asset('backend/img/undraw_secure_login_pdn4.svg') }}" height="300" class="d-block mx-auto" alt="Login Illustration">
            </div>
          </div>
        </div>
      </div>

    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="{{asset('backend/js/tabler.min.js?1692870487')}}" defer></script>
    <script src="{{asset('backend/js/demo.min.js?1692870487')}}" defer></script>
  </body>
</html>
