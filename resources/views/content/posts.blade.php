@extends('layouts/contentLayoutMaster')

@section('title', 'Posts Management')

@section('vendor-style')

@endsection
@section('page-style')

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

                    @component('components.admin.table', ['class' => 'y-datatable', 'columns' => $columns, 'route' =>
                        route('post-list')])
                    @endcomponent

                </div>
            </div>
        </div>


    </section>

@endsection

@section('vendor-script')





@endsection
@section('page-script')

    <script>
        $(document).on('change', '.status-switch', function() {
            console.log(this.value);
        });
    </script>
@endsection
