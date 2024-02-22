@extends('layouts/layoutMaster')

@section('title', 'Account settings - Account')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script>
        $('#account-tab-link').click(function(e) {
            e.preventDefault();
            $(this).addClass('active');

            $('#billing-details').addClass('d-none');
            $('#billing-tab-link').removeClass('active');

            $('#connection-details').addClass('d-none');
            $('#connection-tab-link').removeClass('active');

            $('#notification-details').addClass('d-none');
            $('#notification-tab-link').removeClass('active');

            $('#security-details').addClass('d-none');
            $('#security-tab-link').removeClass('active');

            $('#account-details').removeClass('d-none');
        });
        $('#billing-tab-link').click(function(e) {
            e.preventDefault();
            $(this).addClass('active');

            $('#account-details').addClass('d-none');
            $('#account-tab-link').removeClass('active');

            $('#security-details').addClass('d-none');
            $('#security-tab-link').removeClass('active');

            $('#connection-details').addClass('d-none');
            $('#connection-tab-link').removeClass('active');

            $('#notification-details').addClass('d-none');
            $('#notification-tab-link').removeClass('active');

            $('#billing-details').removeClass('d-none');
        });
        $('#security-tab-link').click(function(e) {
            e.preventDefault();
            $(this).addClass('active');
            $('#connection-details').addClass('d-none');
            $('#connection-tab-link').removeClass('active');

            $('#billing-details').addClass('d-none');
            $('#billing-tab-link').removeClass('active');

            $('#account-details').addClass('d-none');
            $('#account-tab-link').removeClass('active');

            $('#notification-details').addClass('d-none');
            $('#notification-tab-link').removeClass('active');

            $('#security-details').removeClass('d-none');
        });
        $('#notification-tab-link').click(function(e) {
            e.preventDefault();
            $(this).addClass('active');
            $('#security-details').addClass('d-none');
            $('#security-tab-link').removeClass('active');

            $('#billing-details').addClass('d-none');
            $('#billing-tab-link').removeClass('active');

            $('#account-details').addClass('d-none');
            $('#account-tab-link').removeClass('active');

            $('#connection-details').addClass('d-none');
            $('#connection-tab-link').removeClass('active');

            $('#notification-details').removeClass('d-none');
        });
        $('#connection-tab-link').click(function(e) {
            e.preventDefault();
            $(this).addClass('active');
            $('#security-details').addClass('d-none');
            $('#security-tab-link').removeClass('active');

            $('#billing-details').addClass('d-none');
            $('#billing-tab-link').removeClass('active');

            $('#account-details').addClass('d-none');
            $('#account-tab-link').removeClass('active');

            $('#notification-details').addClass('d-none');
            $('#notification-tab-link').removeClass('active');

            $('#connection-details').removeClass('d-none');
        });
    </script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/pages-account-settings-account.js') }}"></script>
@endsection

@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light">Account Settings /</span> Account
    </h4>

    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-pills flex-column flex-md-row mb-4">
                <li class="nav-item"><a class="nav-link active" href="#" id="account-tab-link"><i
                            class="ti-xs ti ti-users me-1"></i>
                        Account</a></li>
                <li class="nav-item"><a class="nav-link" href="#" id="security-tab-link"><i
                            class="ti-xs ti ti-lock me-1"></i> Security</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="#" id="billing-tab-link"><i
                            class="ti-xs ti ti-file-description me-1"></i>
                        Billing & Plans</a></li>
                <li class="nav-item"><a class="nav-link" href="#" id="notification-tab-link"><i
                            class="ti-xs ti ti-bell me-1"></i>
                        Notifications</a></li>
                <li class="nav-item"><a class="nav-link" href="#" id="connection-tab-link"><i
                            class="ti-xs ti ti-link me-1"></i>
                        Connections</a></li>
            </ul>
            @include('content/partials/admin/user_account_settings')
            @include('content/partials/admin/user_security_settings')
            @include('content/partials/admin/user_notification_settings')
            @include('content/partials/admin/user_billing_settings')
            @include('content/partials/admin/user_connection_settings')
        </div>
    </div>


@endsection
