@extends('theme.moreno::views.member.dashboard.layouts.master')

@section('content')
    <div class="moreno-dashboard-empty moreno-settings-page">
        <section class="moreno-settings-hero">
            <div class="moreno-settings-hero-copy">
                <span class="moreno-dashboard-kicker">Tu perfil de creador</span>
                <h1>Configura tu cuenta</h1>
                <p>Administra tus datos, preferencias de pago y seguridad desde un solo lugar.</p>
            </div>
            <div class="moreno-settings-hero-meta">
                <span class="moreno-settings-status"><span aria-hidden="true"></span>Cuenta activa</span>
                <div class="moreno-settings-hero-mark" aria-hidden="true">
                    <span class="fas fa-sliders-h"></span>
                </div>
            </div>
        </section>

        <x-core::card class="moreno-settings-card">
            <x-core::card.header>
            <x-core::tab class="moreno-settings-tabs card-header-tabs">
                <x-core::tab.item
                    id="profile-tab"
                    label="Información de cuenta"
                    :is-active="true"
                />
                <x-core::tab.item
                    id="avatar-tab"
                    label="Foto de perfil"
                />
                <x-core::tab.item
                    id="change-password-tab"
                    label="Contraseña"
                />
                <x-core::tab.item
                    id="change-custom-fields-tab"
                    label="Datos adicionales"
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
                    <div class="moreno-settings-pane-heading">
                        <div>
                            <span class="moreno-settings-section-label">Identidad visual</span>
                            <h2>Tu foto de perfil</h2>
                            <p>Usa una imagen que te identifique dentro de tu espacio de creador.</p>
                        </div>
                    </div>
                    <div class="moreno-settings-avatar-layout">
                        @if($img = auth('member')->user()->avatar_url)
                            <div class="moreno-settings-avatar-preview">
                                <img src="{{$img}}" alt="Foto de perfil de {{ auth('member')->user()->name }}" />
                            </div>
                        @else
                            <div class="moreno-settings-avatar-preview moreno-settings-avatar-fallback" aria-hidden="true">
                                <span class="fas fa-user"></span>
                            </div>
                        @endif
                        <div class="moreno-settings-avatar-form">
                        <form action="{{route('public.member.avatar')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label class="form-label" for="customFile">Selecciona una nueva imagen</label>
                            <input class="form-control" id="customFile" accept="image/*" name="avatar_file" type="file" />
                            <p class="moreno-settings-help">Formatos recomendados: JPG o PNG. Usa una imagen cuadrada para obtener el mejor resultado.</p>
                            <button class="btn btn-primary mt-2" type="submit">Actualizar foto</button>
                        </form>
                        </div>
                    </div>
                </x-core::tab.pane>
                <x-core::tab.pane id="change-password-tab">
                    <div class="moreno-settings-pane-heading">
                        <div>
                            <span class="moreno-settings-section-label">Protección de acceso</span>
                            <h2>Cambia tu contraseña</h2>
                            <p>Usa una contraseña única para mantener tu cuenta protegida.</p>
                        </div>
                    </div>
                    {!! $changePasswordForm !!}
                </x-core::tab.pane>
                <x-core::tab.pane id="change-custom-fields-tab">
                    <div class="moreno-settings-pane-heading">
                        <div>
                            <span class="moreno-settings-section-label">Información adicional</span>
                            <h2>Personaliza tu perfil</h2>
                            <p>Añade los datos que nos ayudan a preparar mejores oportunidades para ti.</p>
                        </div>
                    </div>
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
    </div>
@endsection

@include('plugins/custom-field::_script-templates.render-custom-fields')

@push('scripts')
    <script>
        (() => {
            const refByInput = document.querySelector('[name=ref_by]');

            if (!refByInput) {
                return;
            }

            refByInput.addEventListener('click', async () => {
                try {
                    await navigator.clipboard.writeText(refByInput.value);
                } catch (error) {
                    refByInput.select();
                    refByInput.setSelectionRange(0, 99999);
                    document.execCommand('copy');
                }

                refByInput.classList.add('is-copied');
                window.setTimeout(() => refByInput.classList.remove('is-copied'), 1800);
            });
        })();

        (() => {
            const translations = {
                first_name: 'Nombre',
                last_name: 'Apellidos',
                email: 'Correo electrónico',
                username: 'Nombre de usuario',
                ref_by: 'Enlace de invitación',
                phone: 'Teléfono',
                dob: 'Fecha de nacimiento',
                gender: 'Género',
                payment_method_default: 'Método de pago',
                description: 'Descripción',
                old_password: 'Contraseña actual',
                password: 'Nueva contraseña',
                password_confirmation: 'Confirmar contraseña',
            };

            Object.entries(translations).forEach(([field, label]) => {
                const fieldLabel = document.querySelector(`label[for="${field}"]`);

                if (fieldLabel) {
                    fieldLabel.textContent = label;
                }
            });

            const profileSubmit = document.querySelector('#botble-member-forms-fronts-profile-form button[type="submit"]');
            const passwordSubmit = document.querySelector('#botble-member-forms-fronts-change-password-form button[type="submit"]');
            const customSubmit = document.querySelector('#botble-member-forms-custom-form button[type="submit"]');

            if (profileSubmit) profileSubmit.textContent = 'Guardar cambios';
            if (passwordSubmit) passwordSubmit.textContent = 'Actualizar contraseña';
            if (customSubmit) customSubmit.textContent = 'Guardar cambios';
        })();
    </script>
    {!! JsValidator::formRequest(Botble\Member\Http\Requests\SettingRequest::class) !!}
    {!! JsValidator::formRequest(Botble\Member\Http\Requests\UpdatePasswordRequest::class) !!}
@endpush
