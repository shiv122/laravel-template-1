@extends('layouts/contentLayoutMaster')

@section('title', 'Student Management')

@section('vendor-style')
    <!-- vendor css files -->
@endsection
@section('page-style')
    <!-- Page css files -->
    <style>
        #table-card {
            padding: 10px;
        }

    </style>
@endsection

@section('content')

    <!-- Dashboard Analytics Start -->
    <section id="dashboard-analytics">

        <div class="row match-height">

            <div class="col-lg-12 col-md-12 col-sm-12">
                <div id="table-card" class="card">
                    <table class="table table-borderless table-hover-animation yajra-datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Phone</th>
                                <th>DOB</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!--/ List DataTable -->
    </section>
    <!-- Dashboard Analytics end -->
@endsection

@section('vendor-script')
    <!-- vendor files -->




@endsection
@section('page-script')
    <!-- Page js files -->
    <script>
        var table = $('.yajra-datatable').DataTable({
            processing: false,
            serverSide: true,

            "language": {
                processing: 'Wait'
            },
            ajax: "{{ route('student-list') }}",
            scrollX: true,
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'username',
                    name: 'username'
                },
                {
                    data: 'phone',
                    name: 'phone'
                },
                {
                    data: 'dob',
                    name: 'dob'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $(document).on('change', '.status-switch', function() {
            console.log(this.value);
        });
    </script>
@endsection
