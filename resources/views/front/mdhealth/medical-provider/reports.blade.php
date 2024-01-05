@extends('front.layout.layout2')
@section('content')
<style>
    .reports-div {
        border-bottom: 1px solid #A5A5A5;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }

    .form-group input.form-control {
        color: #000 !important;
    }

    .form-group .prev-img-div img {
        height: 150px;
        width: auto;
        object-fit: contain;
        margin-top: 15px;
    }

    .form-div input.form-control,
    .form-div select {

        padding: 8px 10px;

        border-radius: 3px;
        border: 1px solid #EDEDED;
        background: #FFF;

        font-family: CamptonBook;
        font-size: 14px;
        font-style: normal;
        font-weight: 400;
        line-height: normal;
        letter-spacing: -0.56px;
    }
</style>
<div class="content-wrapper">
    <div class="container py-100px for-cards">
        <div class="row">
            <div class="col-md-3">
                @include('front.includes.sidebar')
            </div>
            <div class="col-md-9">
                <div class="card mb-4">
                    <div class="form-div">
                        <h5 class="card-header d-flex align-items-center justify-content-between mb-4">
                            <span>Reports</span>
                            <img src="{{ asset('front/assets/img/GoldMember.svg') }}" alt="">
                        </h5>
                        <div class="card-body mb-3">

                            <div class="reports-div section-heading-div">
                                <h6 class="section-heading">Add New Reports</h6>
                            </div>

                            <form method="POST" action="{{ route('add.report') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group  mb-3 ">
                                    <label class="form-label">Report Title</label>
                                    <input type="text" name="report_title" class="form-control" placeholder="Write Here Please">
                                </div>

                                {{-- {{dd($patient_list)}} --}}

                                <div class="form-group d-flex flex-column mb-5">
                                    <label class="form-label">Patient</label>
                                    <select name="customer_package_purchage_id" id="">
                                        <option value="">Choose Patient</option>
                                        @if (!empty($patient_list))
                                        @foreach ($patient_list as $patient)
                                        <option value="{{ !empty($patient['id']) ? $patient['id'] : '' }}">
                                            {{ !empty($patient['name']) ? $patient['name'] : '' }}
                                        </option>
                                        @endforeach
                                        @endif

                                        {{-- <option value="">Patient 2</option>
                                        <option value="">Patient 3</option> --}}
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Upload Report File</label>
                                    <div class="form-group">
                                        <input type="file" name="report_path" class="form-control text-dark">
                                    </div>
                                    <div class="prev-img-div">
                                        <img src="front/assets/img/default-img.png" alt="image">
                                    </div>
                                </div>

                                <div class="section-btns mb-5">
                                    <a href="javascript:void(0);" class="black-plate bg-black text-white fw-700 w-100">Upload Reports</a>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="form-div">
                        <h5 class="card-header d-flex align-items-center justify-content-between mb-4">
                            <span>Uploaded Reports</span>
                            <img src="{{ asset('front/assets/img/GoldMember.svg') }}" alt="">
                        </h5>
                        <div class="card-body">
                            <!-- FILTER -->
                            <div class="filter-div">
                                <div class="search-div">
                                    <input type="text" class="form-control" placeholder="Search" id="">
                                </div>
                                <div class="list-div">
                                    <select name="" id="" class="form-select">
                                        <option value="">List for Date</option>
                                        <option value="">List for Price</option>
                                        <option value="">List for Distance</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Reports-->
                            <div class="card shadow-none" style="border-radius: 3px;background: #F6F6F6;">
                                <div class="card-body d-flex gap-3">
                                    <div>
                                        <img src="{{ asset('front/assets/img/msg2.png') }}" alt="">
                                    </div>
                                    <div>
                                        <h5 class="card-h1">Treatment No: #MD3726378 <span class="pending ms-3">2 Documents</span></h5>
                                        <p class="mb-0 pkg-name">Raju Singh</p>
                                    </div>
                                    <div class="ms-auto d-flex flex-column justify-content-end align-items-end">
                                        <h5 class="card-h3 mb-0">Upload Time: <span class="card-p1">16/12/2023</span></h5>
                                        <a href="javascript:;" class="text-black mt-auto card-h3">View Details</a>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(".mpReportsLi").addClass("activeClass");
    $(".mpReports").addClass("md-active");
</script>
@endsection