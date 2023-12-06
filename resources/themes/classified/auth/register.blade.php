@extends('layouts.auth')

@section('title',trans('corals-classified-master::auth.register'))
@section('css')
    <style type="text/css">
        #terms {
            color: black;
        }

        #terms-anchor {
            text-transform: uppercase;
        }

        input[name=name] {
            border-bottom-right-radius: 0px;
            border-top-right-radius: 0px;
        }

        input[name=last_name] {
            border-top-left-radius: 0px;
            border-bottom-left-radius: 0px;
        }

        #last-name-col {
            padding-left: 2px;
        }

        #first-name-col {
            padding-right: 2px;
        }
    </style>
@endsection

@section('hero_area')
    @include('partials.page_header',['content'=> '<h2 class="product-title">'.trans('corals-classified-master::auth.register').'</h2>'])
@endsection

@section('content')
    <section class="login">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-xs-12">
                    <div class="login-form login-area">
                        <h3>@lang('corals-classified-master::auth.register_new_account')</h3>
                        <form method="POST" action="{{ route('register') }}" class="ajax-form login-form">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-md-3" id="first-name-col">
                                    <div class="form-group has-feedback {{ $errors->has('name') ? ' has-error' : '' }}">
                                        <input type="text" name="name"
                                               class="form-control" placeholder="@lang('User::attributes.user.name')"
                                               value="{{ old('name') }}" autofocus/>
                                        <span class="glyphicon glyphicon-user form-control-feedback"></span>

                                        @if ($errors->has('name'))
                                            <div class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-3" id="last-name-col">
                                    <div class="form-group has-feedback {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                        <input type="text" name="last_name"
                                               class="form-control"
                                               placeholder="@lang('User::attributes.user.last_name')"
                                               value="{{ old('last_name') }}" autofocus/>
                                        <span class="glyphicon glyphicon-user form-control-feedback"></span>

                                        @if ($errors->has('last_name'))
                                            <div class="help-block">
                                                <strong>{{ $errors->first('last_name') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                        <input type="email" name="email"
                                               class="form-control" placeholder="@lang('User::attributes.user.email')"
                                               value="{{ old('email') }}"/>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

                                        @if ($errors->has('email'))
                                            <div class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                                        <input type="password" name="password" class="form-control"
                                               placeholder="@lang('User::attributes.user.password')"/>
                                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                                        @if ($errors->has('password'))
                                            <div class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">

                                    <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                        <input type="password" name="password_confirmation" class="form-control"
                                               placeholder="@lang('User::attributes.user.retype_password')"/>
                                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                                        @if ($errors->has('password_confirmation'))
                                            <div class="help-block">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>


                            </div>
                            @if( $is_two_factor_auth_enabled = \TwoFactorAuth::isActive())
                                @if( $twoFaView = \TwoFactorAuth::TwoFARegistrationView())
                                    <div id="2fa-registration-details">
                                        @include($twoFaView)
                                    </div>
                                @endif
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group has-feedback {{ $errors->has('terms') ? ' has-error' : '' }}">
                                        <div class="checkbox icheck">
                                            <label>
                                                <input name="terms" value="1" type="checkbox"/>
                                                <strong>@lang('corals-classified-master::auth.agree')
                                                    <a href="#" data-toggle="modal" id="terms-anchor"
                                                       data-target="#terms">@lang('corals-classified-master::auth.terms')</a>
                                                </strong>
                                            </label>
                                        </div>
                                        @if ($errors->has('terms'))
                                            <span class="help-block"><strong>@lang('corals-classified-master::auth.accept_terms')</strong></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-6">
                                    <button type="submit"
                                            class="btn btn-success btn-block"
                                            data-style="expand-rights">@lang('corals-classified-master::auth.register')</button>
                                </div>
                            </div>
                            <div class="row justify-content-md-center">
                                <div class="col-md-6 col-md-offset-3 offset-md-3 my-3 text-center">
                                    <br/>
                                    <a class=""
                                       href="{{ route('login') }}">@lang('corals-classified-master::auth.already_have_account')</a>
                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@component('components.modal',['id'=>'terms','header'=>\Settings::get('site_name').' Terms and policy'])
    {!! \Settings::get('terms_and_policy') !!}
@endcomponent
