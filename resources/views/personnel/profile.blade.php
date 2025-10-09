@extends('admin.admin_master')
@section('admin')
    <div class="page-header">
        <div class="page-block">
            <div class="row align-items-center">
                <div class="col-md-12">
                    <div class="page-header-title">
                        <h5 class="m-b-10">Personnel Profile</h5>
                        <p class="text-muted mb-0">{{ $personnel->initial }}</p>
                    </div>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="feather icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('personal-view') }}">Personnel</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    <img class="rounded mb-3" style="width: 160px; height: 160px; object-fit: cover;"
                        src="{{ $personnel->personnel_image ? asset($personnel->personnel_image) : asset('upload/images.png') }}"
                        alt="{{ $personnel->initial }}">
                    <h4 class="mb-0">{{ $personnel->initial }}</h4>
                    <span class="text-muted d-block">Rank: {{ optional($personnel->rank)->rank_name ?? 'N/A' }}</span>
                    <span class="badge badge-info">{{ optional($personnel->service)->arm_of_service ?? 'Arm N/A' }}</span>
                </div>
                <div class="card-body border-top">
                    <dl class="row mb-0">
                        <dt class="col-sm-5 text-muted">Service Number</dt>
                        <dd class="col-sm-7">{{ $personnel->svcnumber }}</dd>

                        <dt class="col-sm-5 text-muted">Category</dt>
                        <dd class="col-sm-7">{{ $personnel->service_category ?? 'N/A' }}</dd>

                        <dt class="col-sm-5 text-muted">Gender</dt>
                        <dd class="col-sm-7">{{ $personnel->gender ?? 'N/A' }}</dd>

                        <dt class="col-sm-5 text-muted">Unit</dt>
                        <dd class="col-sm-7">{{ optional($personnel->unit)->unit_name ?? $personnel->unit_name ?? 'N/A' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="col-lg-8 mb-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Contact & Personal Details</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4 text-muted">Surname</dt>
                        <dd class="col-sm-8">{{ $personnel->surname }}</dd>

                        <dt class="col-sm-4 text-muted">Other Names</dt>
                        <dd class="col-sm-8">{{ $personnel->othernames ?? 'N/A' }}</dd>

                        <dt class="col-sm-4 text-muted">Mobile</dt>
                        <dd class="col-sm-8">{{ $personnel->mobile_no ?? 'N/A' }}</dd>

                        <dt class="col-sm-4 text-muted">Email</dt>
                        <dd class="col-sm-8">{{ $personnel->email ?? 'N/A' }}</dd>

                        <dt class="col-sm-4 text-muted">Blood Group</dt>
                        <dd class="col-sm-8">{{ $personnel->blood_group ?? 'N/A' }}</dd>

                        <dt class="col-sm-4 text-muted">Height</dt>
                        <dd class="col-sm-8">{{ $personnel->height ?? 'N/A' }}</dd>

                        <dt class="col-sm-4 text-muted">Distinctive Marks</dt>
                        <dd class="col-sm-8">{{ $personnel->virtual_mark ?? 'N/A' }}</dd>

                        <dt class="col-sm-4 text-muted">Created On</dt>
                        <dd class="col-sm-8">{{ optional($personnel->created_at)->format('d M Y H:i') ?? 'N/A' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="text-right">
        <a href="{{ route('personal-edit', $personnel->uuid) }}" class="btn btn-primary"><i class="feather icon-edit"></i> Edit Personnel</a>
    </div>
@endsection
