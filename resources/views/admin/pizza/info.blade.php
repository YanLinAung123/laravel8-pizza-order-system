@extends('admin.layout.app')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-8 offset-3 mt-5">
                        <div class="col-md-9">
                            <a href="{{ route('admin#pizza') }}">
                                <div class="mb-2 text-black"><i class="fas fa-arrow-left"></i>back</div>
                            </a>
                            <div class="card">
                                <div class="card-header p-2">
                                    <legend class="text-center">Pizza Information</legend>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="activity">
                                            <div class="d-flex justify-content-evenly ">
                                                <div class="my-5 ">
                                                    <img src="{{ asset('uploads/' . $pizza->image) }}"
                                                        alt="NO Image To Show" class="img-thumbnail rounded-lg"
                                                        style="width:250px; height:auto; ">
                                                </div>
                                                <div class="fs-5">
                                                    <div class="mt-3">
                                                        <b>Name : </b>{{ $pizza->pizza_name }}
                                                    </div>
                                                    <div class="mt-3">
                                                        <b>Price : </b>{{ $pizza->price }}
                                                    </div>
                                                    <div class="mt-3">
                                                        <b>Publish Status : </b>
                                                        @if ($pizza->publish_status == 1)
                                                            Yes
                                                        @else
                                                            No
                                                        @endif
                                                    </div>
                                                    <div class="mt-3">
                                                        <b>Category : </b>{{ $pizza->category_id }}
                                                    </div>
                                                    <div class="mt-3">
                                                        <b>Discount Price : </b>{{ $pizza->discount_price }}
                                                    </div>
                                                    <div class="mt-3">
                                                        <b>Waiting Time : </b>{{ $pizza->waiting_time }}
                                                    </div>
                                                    <div class="mt-3">
                                                        <b>Description : </b>{{ $pizza->description }}
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
            </div>
    </div>
@endsection
