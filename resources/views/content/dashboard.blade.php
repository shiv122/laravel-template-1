@extends('layouts/contentLayoutMaster')

@section('title', 'Dashboard Analytics')

@section('vendor-style')
    <!-- vendor css files -->

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">

    <link rel="stylesheet" href="{{ asset(mix('vendors/css/tables/datatable/responsive.bootstrap.min.css')) }}">
@endsection
@section('page-style')
    <!-- Page css files -->

    <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/extensions/ext-component-toastr.css')) }}">

@endsection

@section('content')

    <!-- Dashboard Analytics Start -->
    <section id="dashboard-analytics">
        <div class="row match-height">
            <!-- Greetings Card starts -->
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="card card-congratulations">
                    <div class="card-body text-center">
                        <img src="{{ asset('images/elements/decore-left.png') }}" class="congratulations-img-left"
                            alt="card-img-left" />
                        <img src="{{ asset('images/elements/decore-right.png') }}" class="congratulations-img-right"
                            alt="card-img-right" />
                        <div class="avatar avatar-xl bg-primary shadow">
                            <div class="avatar-content">
                                <i data-feather="award" class="font-large-1"></i>
                            </div>
                        </div>
                        <div class="text-center">
                            <h1 class="mb-1 text-white">Congratulations {{ auth()->user()->username }}</h1>
                            <p class="card-text m-auto w-75">
                                You have done <strong>57.6%</strong> more sales today. Check your new badge in your profile.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Greetings Card ends -->


            <!--/ List DataTable -->
    </section>
    <!-- Dashboard Analytics end -->
@endsection

@section('vendor-script')
    <!-- vendor files -->




@endsection
@section('page-script')
    <!-- Page js files -->

@endsection
