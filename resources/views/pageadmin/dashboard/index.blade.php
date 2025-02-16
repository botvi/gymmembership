@extends('template-admin.layout')

@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-3 border-info">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary fw-bold">MEMBERSHIP GYM</p>
                                    <h4 class="my-1 text-info fw-bold">{{ $member_membership_gym }}</h4>
                                    <p class="mb-0 font-13"> <a href="/admin-manage-membership-gym" class="btn btn-sm btn-outline-info">Manage Member</a></p>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i class='bx bx-dumbbell'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-3 border-danger">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary fw-bold">BOXING DAN MUAYTHAI</p>
                                    <h4 class="my-1 text-danger fw-bold">{{ $member_boxing }}</h4>
                                    <p class="mb-0 font-13"> <a href="/admin-manage-boxing-muaythai" class="btn btn-sm btn-outline-danger">Manage Member</a></p>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto"><i class='bx bx-dumbbell'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-3 border-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary fw-bold">PACKAGE</p>
                                    <h4 class="my-1 text-success fw-bold">{{ $member_package }}</h4>
                                    <p class="mb-0 font-13"> <a href="/admin-manage-package" class="btn btn-sm btn-outline-success">Manage Member</a></p>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class='bx bx-dumbbell'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-0 border-3 border-warning">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary fw-bold">FOREACH TIME VISIT</p>
                                    <h4 class="my-1 text-warning fw-bold">{{ $member_foreach_time_visit }}</h4>
                                    <p class="mb-0 font-13"> <a href="/admin-manage-per-visit" class="btn btn-sm btn-outline-warning">Manage Member</a></p>
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto"><i class='bx bx-dumbbell'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end row-->
        </div>
    </div>
@endsection
