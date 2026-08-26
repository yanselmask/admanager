@extends(Theme::getThemeNamespace('views.member.dashboard') . '.layouts.master')

@section('content')
    <x-core::card>
        <x-core::card.header>
            <x-core::tab class="card-header-tabs">
                <x-core::tab.item
                    id="profile-tab"
                    :label="trans('plugins/member::dashboard.account_field_title')"
                    :is-active="true"
                />
                <x-core::tab.item
                    id="avatar-tab"
                    :label="trans('plugins/member::dashboard.profile-picture')"
                />
                <x-core::tab.item
                    id="change-password-tab"
                    :label="trans('plugins/member::dashboard.change_password')"
                />
                <x-core::tab.item
                    id="change-custom-fields-tab"
                    :label="trans('Custom Fields')"
                />
                {!! apply_filters('member_dashboard_sidebar_menu', null) !!}
                {!! apply_filters('member_settings_register_content_tabs', null) !!}
            </x-core::tab>
        </x-core::card.header>

        <x-core::card.body>
            <x-core::tab.content>
                <x-core::tab.pane id="profile-tab" :is-active="true">
                    {!! $profileForm !!}
                </x-core::tab.pane>
                <x-core::tab.pane id="avatar-tab">
                    @if($img = auth('member')->user()->avatar_url)
                    <div class="avatar avatar-4xl">
                        <img class="rounded-circle" src="{{$img}}" alt="" />
                    </div>
                    @endif
                    <div class="container">
                        <form action="{{route('public.member.avatar')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3"><label class="form-label" for="customFile">Foto de perfil</label><input class="form-control" id="customFile" accept="image/*" name="avatar_file" type="file" /></div>
                            <div class="d-flex">
                                <button class="btn btn-primary mt-3">Cambiar imagen</button>
                            </div>
                        </form>
                    </div>
                </x-core::tab.pane>
                <x-core::tab.pane id="change-password-tab">
                    {!! $changePasswordForm !!}
                </x-core::tab.pane>
                <x-core::tab.pane id="change-custom-fields-tab">
                    {!! $customForm->renderForm(showEnd: false) !!}
                    @php
                        do_action(BASE_ACTION_META_BOXES, 'advanced', $customForm->getModel())
                    @endphp
                    <x-core::button type="submit" color="primary">{{__('Save changes')}}</x-core::button>
                    {!! Form::close() !!}
                </x-core::tab.pane>
                {!! apply_filters('member_settings_register_content_tab_inside', null) !!}
            </x-core::tab.content>
        </x-core::card.body>
    </x-core::card>
@endsection

@include('plugins/custom-field::_script-templates.render-custom-fields')

@push('scripts')
    <script>
        let refByInput = document.querySelector('[name=ref_by]');
        if(refByInput)
        {
            refByInput.addEventListener('click',() => {
                alert('Enlace copiado.')
                refByInput.select();
                refByInput.setSelectionRange(0, 99999);
                document.execCommand("copy");
            })
        }
    </script>
    {!! JsValidator::formRequest(Botble\Member\Http\Requests\SettingRequest::class) !!}
    {!! JsValidator::formRequest(Botble\Member\Http\Requests\UpdatePasswordRequest::class) !!}
@endpush
