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
                <x-admin.card>
                    <x-slot name="card_body">
                        <x-admin.table class="y-datatable" columns="id,title,description,action"
                            :route="route('post-list')" loadingText="Loading..." />
                        {{-- <x-admin.ajaxForm :route="route('home')" id="test-form" method="POST"
                            inputs="User name:type=select|class=d-none,title,password:type=password&required"
                            :selects="['user_name'=>[['id'=>1,'name'=>'One'],['id'=>2,'name'=>'Two']]]">
                            <x-slot name="additional">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp" placeholder="Enter email">
                                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with
                                            anyone
                                            else.</small>
                                    </div>
                                </div>
                            </x-slot>
                        </x-admin.ajaxForm> --}}
                    </x-slot>
                </x-admin.card>
            </div>
        </div>
    </section>
    <x-admin.modal id="delete-modal" title="Delete Post" type="danger" btn="false">
        <x-slot name="modal_body">
            <p>Are you sure you want to delete this post?</p>
        </x-slot>
    </x-admin.modal>
@endsection

@section('vendor-script')
@endsection
@section('page-script')

    <script>
        $(document).on('click', '.delete-btn', function() {
            console.log(this.value);
            $('#delete-modal').modal('show');
        });
    </script>
@endsection
