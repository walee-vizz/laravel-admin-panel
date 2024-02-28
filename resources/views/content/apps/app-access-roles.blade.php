@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Roles - Apps')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/app-access-roles.js') }}"></script>
    <script src="{{ asset('assets/js/modal-add-role.js') }}"></script>
@endsection

@section('content')
    <h4 class="mb-4">Roles List</h4>

    <p class="mb-4">A role provided access to predefined menus and features so that depending on <br> assigned role an
        administrator can have access to what user needs.</p>
    <!-- Role cards -->
    <div class="row g-4">
        @if ($roles)
            @foreach ($roles as $role)
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h6 class="fw-normal mb-2">Total {{ $role->users()->count() }} users</h6>
                                @if ($role->users()->count())
                                    <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                        @foreach ($role->users as $role_user)
                                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                                title="{{ $role_user->name }}" class="avatar avatar-sm pull-up">
                                                @if ($role_user->profile_picture)
                                                    <img class="rounded-circle"
                                                        src="{{ asset('assets/' . $role_user->profile_picture) }}"
                                                        alt="Avatar">
                                                @else
                                                    <img class="rounded-circle"
                                                        src="{{ asset('assets/img/avatars/5.png') }}" alt="Avatar">
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                                {{-- <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        title="Vinnie Mostowy" class="avatar avatar-sm pull-up">
                                        <img class="rounded-circle" src="{{ asset('assets/img/avatars/5.png') }}"
                                            alt="Avatar">
                                    </li>
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        title="Allen Rieske" class="avatar avatar-sm pull-up">
                                        <img class="rounded-circle" src="{{ asset('assets/img/avatars/12.png') }}"
                                            alt="Avatar">
                                    </li>
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        title="Julee Rossignol" class="avatar avatar-sm pull-up">
                                        <img class="rounded-circle" src="{{ asset('assets/img/avatars/6.png') }}"
                                            alt="Avatar">
                                    </li>
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        title="Kaith D'souza" class="avatar avatar-sm pull-up">
                                        <img class="rounded-circle" src="{{ asset('assets/img/avatars/3.png') }}"
                                            alt="Avatar">
                                    </li>
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                        title="John Doe" class="avatar avatar-sm pull-up">
                                        <img class="rounded-circle" src="{{ asset('assets/img/avatars/1.png') }}"
                                            alt="Avatar">
                                    </li>
                                </ul> --}}
                            </div>
                            <div class="d-flex justify-content-between align-items-end mt-1">
                                <div class="role-heading">
                                    <h4 class="mb-1">{{ $role->name }}</h4>
                                    <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#addRoleModal"
                                        class="role-edit-modal"><span>Edit Role</span></a>
                                </div>
                                <a href="javascript:void(0);" class="text-muted"><i class="ti ti-copy ti-md"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
        @endif
        {{-- Add New Role --}}
        <div class="col-xl-4 col-lg-6 col-md-6">
            <div class="card h-100">
                <div class="row h-100">
                    <div class="col-sm-5">
                        <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-3">
                            <img src="{{ asset('assets/img/illustrations/add-new-roles.png') }}"
                                class="img-fluid mt-sm-4 mt-md-0" alt="add-new-roles" width="83">
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="card-body text-sm-end text-center ps-sm-0">
                            <button data-bs-target="#addRoleModal" data-bs-toggle="modal"
                                class="btn btn-primary mb-2 text-nowrap add-new-role">Add New Role</button>
                            <p class="mb-0 mt-1">Add role, if it does not exist</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- End --}}
        <div class="col-12">
            <!-- Role Table -->
            <div class="card">
                <div class="card-datatable table-responsive">
                    <table class="datatables-users table border-top">
                        <thead>
                            <tr>
                                <th></th>
                                <th>User</th>
                                <th>Role</th>
                                <th>Plan</th>
                                <th>Billing</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!--/ Role Table -->
        </div>
    </div>
    <!--/ Role cards -->

    <!-- Add Role Modal -->
    @include('_partials/_modals/modal-add-role')
    <!-- / Add Role Modal -->
@endsection
