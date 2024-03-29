@extends('layouts.master')

@section('title', $title)


@section('hero_area')
    @include('partials.page_header',['content'=> '<h2 class="product-title">'.$title.'</h2>'])
@endsection

@section('content')
    <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="nav-item @if($active_tab=="profile") active @endif">
                        <a href="#profile" class="nav-link" data-toggle="tab">
                            @lang('corals-classified-master::auth.profile')
                        </a>
                    </li>
                    @php \Actions::do_action('user_profile_tabs',user(),$active_tab) @endphp
                </ul>
                <div class="tab-content">
                    <div class="tab-pane @if($active_tab=="profile") active @endif" id="profile">
                        {!! CoralsForm::openForm(null,$user = user(), ['url' => url('profile'), 'method'=>'PUT','class'=>'ajax-form','files'=>true]) !!}
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a href="#edit_profile" class="nav-link active" data-toggle="pill"><i
                                                class="fa fa-pencil"></i> @lang('corals-classified-master::auth.edit_profile')
                                    </a></li>
                                <li class="nav-item">
                                    <a href="#profile_addresses" class="nav-link" data-toggle="pill"><i
                                                class="fa fa-map-marker"></i>
                                        @lang('corals-classified-master::auth.addresses')</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#reset_password" class="nav-link" data-toggle="pill"><i
                                                class="fa fa-lock"></i>
                                        @lang('corals-classified-master::auth.auth_password')</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#notification_preferences" class="nav-link" data-toggle="pill"><i
                                                class="fa fa-bell-o"></i>
                                        @lang('corals-classified-master::auth.notification_preferences')</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="edit_profile">
                                    <div class="row">
                                        <div class="col-md-4">
                                            {!! CoralsForm::text('name','User::attributes.user.name',true) !!}
                                            {!! CoralsForm::email('email','User::attributes.user.email',true) !!}
                                            {!! CoralsForm::textarea('properties[about]', 'User::attributes.user.about' , false, null,[
                                                'class'=>'limited-text',
                                                'maxlength'=>250,
                                                'help_text'=>'<span class="limit-counter">0</span>/250',
                                            'rows'=>'4']) !!}
                                        </div>
                                        <div id="country-div" class="col-md-4">
                                            {!! CoralsForm::text('last_name','User::attributes.user.last_name',true) !!}

                                            {!! CoralsForm::text('phone_country_code','User::attributes.user.phone_country_code',false,null,['id'=>'authy-countries']) !!}
                                            {!! CoralsForm::text('phone_number','User::attributes.user.phone_number',false,null,['id'=>'authy-cellphone']) !!}
                                            {!! CoralsForm::text('job_title','User::attributes.user.job_title') !!}
                                            {!! CoralsForm::text('properties[store_name]','corals-classified-master::labels.profile.store_name') !!}

                                        </div>
                                        <div class="col-md-4">
                                            <div class="text-center">
                                                <img id="image_source"
                                                     class="profile-user-img img-responsive img-circle"
                                                     style="width: 200px"
                                                     src="{{ user()->picture }}"
                                                     alt="User profile picture">
                                                {{ CoralsForm::hidden('profile_image') }}
                                                <small class="">@lang('corals-classified-master::auth.click_pic_update')</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="profile_addresses">
                                    @include('Settings::addresses.address_list_form', [
                                    'url'=>url('users/'.$user->hashed_id.'/address'),'method'=>'POST',
                                    'model'=>$user,
                                    'addressDiv'=>'#profile_addresses'
                                    ])
                                </div>
                                <div class="tab-pane" id="notification_preferences">
                                    @forelse(\CoralsNotification::getUserNotificationTemplates(user()) as $notifications_template)
                                        <div class="row">
                                            <div class="col-md-12">
                                                {!! CoralsForm::checkboxes(
                                                'notification_preferences['.$notifications_template->id .'][]',
                                                $notifications_template->friendly_name,
                                                false, $options = get_array_key_translation(config('notification.supported_channels')),
                                                $selected = $user->notification_preferences[$notifications_template->id] ?? [],
                                                ['checkboxes_wrapper'=>'span', 'label'=>['class' => 'm-r-10']])
                                                !!}
                                            </div>
                                        </div>
                                    @empty
                                        <h5>@lang('corals-classified-master::auth.no_notification')</h5>
                                    @endforelse
                                </div>
                                <div class="tab-pane" id="reset_password">
                                    <div class="row">
                                        <div class="col-md-4">
                                            {!! CoralsForm::password('password','User::attributes.user.password') !!}
                                            {!! CoralsForm::password('password_confirmation','User::attributes.user.password_confirmation') !!}

                                            @if(\TwoFactorAuth::isActive())
                                                {!! CoralsForm::checkbox('two_factor_auth_enabled','User::attributes.user.two_factor_auth_enabled',\TwoFactorAuth::isEnabled($user)) !!}

                                                @if(!empty(\TwoFactorAuth::getSupportedChannels()))
                                                    {!! CoralsForm::radio('channel','User::attributes.user.channel', false,\TwoFactorAuth::getSupportedChannels(),\Arr::get($user->getTwoFactorAuthProviderOptions(),'channel', null)) !!}
                                                @endif
                                            @endif
                                        </div>
                                        <div class="col-md-6 text-center">
                                            <i class="fa fa-lock" style="color:#7777770f; font-size: 10em;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                {!! CoralsForm::formButtons(trans('corals-classified-master::auth.save',['title' => $title_singular]),[],['href'=>url('dashboard')]) !!}
                            </div>
                        </div>
                        {!! CoralsForm::closeForm() !!}
                    </div>
                    @php \Actions::do_action('user_profile_tabs_content',user(),$active_tab) @endphp

                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.nav-tabs-custom -->
        </div>
    </div>
    <!-- /.row -->
    @include('User::users.profile.cropper_modal')

@endsection
@section('js')
    @include('User::users.profile.scripts')
@endsection
