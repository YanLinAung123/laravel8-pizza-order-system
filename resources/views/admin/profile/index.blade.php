@extends('admin.layout.app')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-8 offset-3 mt-5">
                        <div class="col-md-9">
                            <div class="card">
                                @if (Session::has('updateSuccess'))
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        {{ Session::get('updateSuccess') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                                <div class="card-header p-2">
                                    <legend class="text-center">User Profile</legend>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="activity">
                                            <form class="form-horizontal" method="POST"
                                                action="{{ route('admin#updateProfile', $userData->id) }}">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="name"
                                                            value="{{ old('name', $userData->name) }}" id="inputName"
                                                            placeholder="Name">
                                                        @if ($errors->has('name'))
                                                            <p class="text-danger">{{ $errors->first('name') }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                                    <div class="col-sm-10">
                                                        <input type="email" class="form-control" name="email"
                                                            value="{{ old('email', $userData->email) }}" id="inputEmail"
                                                            placeholder="Name">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputAddress"
                                                        class="col-sm-2 col-form-label">Address</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="inputAddress"
                                                            name="address"
                                                            value="{{ old('address', $userData->address) }}"
                                                            placeholder="Address">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="inputPhone" class="col-sm-2 col-form-label">Phone</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="inputPhone"
                                                            name="phone" value="{{ old('phone', $userData->phone) }}"
                                                            placeholder="Phone">
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <a href="{{ route('admin#changePasswordPage') }}">Change
                                                            Password</a>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <button type="submit"
                                                            class="btn bg-dark text-white">Submit</button>
                                                    </div>
                                                </div>
                                            </form>

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
