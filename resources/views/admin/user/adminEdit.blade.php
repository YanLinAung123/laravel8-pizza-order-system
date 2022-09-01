@extends('admin.layout.app')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row mt-4">

                    <div class="col-8 offset-3 mt-5">
                        <div class="col-md-9">
                            <a href="{{ route('admin#userList') }}">
                                <div class="mb-2 text-black"><i class="fas fa-arrow-left"></i>back</div>
                            </a>
                            <div class="card">
                                <div class="card-header p-2">
                                    <legend class="text-center">Edit Admin Account</legend>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="activity">
                                            <form class="form-horizontal" method="POST"
                                                action="{{route('admin#updateAdminAccount',$user->id)}}">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="Name" class="col-sm-2 col-form-label">Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="Name"
                                                            placeholder="Name" name="name"
                                                            value="{{ old('name', $user->name) }}">
                                                        @if ($errors->has('name'))
                                                            <p class="text-danger">{{ $errors->first('name') }}</p>
                                                        @endif
                                                    </div>

                                                </div>
                                                <div class="form-group row">
                                                    <label for="Email" class="col-sm-2 col-form-label">Email</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="Email"
                                                            placeholder="Email" name="email"
                                                            value="{{ old('email', $user->email) }}">
                                                        @if ($errors->has('email'))
                                                            <p class="text-danger">{{ $errors->first('email') }}</p>
                                                        @endif
                                                    </div>

                                                </div>
                                                <div class="form-group row">
                                                    <label for="Phone" class="col-sm-2 col-form-label">Phone</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="Phone"
                                                            placeholder="Phone" name="phone"
                                                            value="{{ old('phone', $user->phone) }}">
                                                        @if ($errors->has('phone'))
                                                            <p class="text-danger">{{ $errors->first('phone') }}</p>
                                                        @endif
                                                    </div>

                                                </div><div class="form-group row">
                                                    <label for="Address" class="col-sm-2 col-form-label">Address</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="Address"
                                                            placeholder="Address" name="address"
                                                            value="{{ old('address', $user->address) }}">
                                                        @if ($errors->has('address'))
                                                            <p class="text-danger">{{ $errors->first('address') }}</p>
                                                        @endif
                                                    </div>

                                                </div>
                                            </div><div class="form-group row">
                                                <label for="UserRole" class="col-sm-2 col-form-label">Role</label>
                                                <div class="col-sm-10">
                                                    <select name="role" id="UserRole" class="form-select">
                                                        @if ($user->role=='admin')
                                                            <option value="admin" selected>Admin</option>
                                                            <option value="user">User</option>
                                                        @else
                                                        <option value="admin" >Admin</option>
                                                        <option value="user">User</option>
                                                        @endif
                                                    </select>
                                                    @if ($errors->has('role'))
                                                        <p class="text-danger">{{ $errors->first('role') }}</p>
                                                    @endif
                                                </div>

                                            </div>

                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <button type="submit" class="btn bg-dark text-white">Update
                                                            Admin Account</button>
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
