@extends('layouts.page')

@section('page-content')
    <h1>@lang('settings.admin')</h1>
    <p>@lang('settings.admin-description')</p>

    <x-delete-section />

    <div class="row">
        <div class="col-12 col-md-6">
            <div class="bg-white shadow shadow-sm">
                <div class="ps-4 pt-4">
                    <h4>@lang('settings.domain-list')</h4>
                    <p>@lang('settings.domain-list-description')</p>
                </div>
                <table class="table align-middle">
                    <thead class="table-dark text-uppercase">
                        <th>#</th>
                        <th>@lang('domain.name')</th>
                        <th>@lang('general.active')</th>
                        <th>@lang('general.action')</th>
                    </thead>
                    <tbody>
                    <x-domain.form />

                    @foreach($domains as $domain)
                        <x-domain.form :domain="$domain" />
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="bg-white shadow shadow-sm p-4">
                <h4>@lang('settings.app-information')</h4>
                <p>@lang('settings.app-information-description')</p>
                <div class="d-flex justify-content-between align-items-center">
                    <span>Name<br><small>APP_NAME</small></span>
                    <span>{{ config('app.name') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span>Main URL<br><small>APP_URL</small></span>
                    <span>{{ config('app.url') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span>QR Code Base URL<br><small>QR_BASE_URL</small></span>
                    <span>{{ config('qr.url') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span>Default Locale<br><small>APP_DEFAULT_LOCALE</small></span>
                    <span>{{ config('app.locale') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span>Mail Host<br><small>MAIL_HOST, MAIL_PORT</small></span>
                    <span>{{ config('mail.mailers.smtp.host') }}:{{ config('mail.mailers.smtp.port') }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <span>Mail From<br><small>MAIL_FROM_NAME, MAIL_FROM_ADDRESS</small></span>
                    <span>{{ config('mail.from.name') }} ({{ config('mail.from.address') }})</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <span>Version</span>
                    <span>{{ config('app.version.branch') }}-{{ config('app.version.commit') }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
