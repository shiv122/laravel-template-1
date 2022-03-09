@extends('layouts/contentLayoutMaster')

@section('title', 'Posts Management')

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
                                <th>Title</th>
                                <th>Description</th>

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
            processing: true,
            serverSide: true,
            scrollX: true,
            pagingType: $(window).width() < 768 ? "numbers" : "simple_numbers",
            "language": {
                processing: 'Wait'
            },
            ajax: "{{ route('post-list') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'description',
                    name: 'description'
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
