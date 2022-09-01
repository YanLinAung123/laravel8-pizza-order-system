@extends('admin.layout.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                {{-- Delete Success Message --}}
                @if (Session::has('deleteSuccess'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ Session::get('deleteSuccess') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="{{ route('admin#userList') }}"><button
                                            class="btn btn-sm btn-outline-dark">User List</button></a>
                                    <a href="{{ route('admin#adminList') }}"><button
                                            class="btn btn-sm btn-outline-dark">Admin List</button></a>
                                </h3>

                                <div class="card-tools d-flex">
                                    <a href="{{route('admin#userListDownload')}}" class="me-3" class="mt-1">
                                        <button class="btn btn-success">CSV Download</button>
                                    </a>
                                    <form action="{{ route('admin#userSearch') }}" method="get">
                                        @csrf
                                        <div class="input-group input-group-sm mt-1" style="width: 150px;">
                                            <input type="text" name="search" class="form-control float-right"
                                                placeholder="Search">

                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-default">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap text-center">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th> Name</th>
                                            <th>Email</th>
                                            <th> Phone</th>
                                            <th>Address</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user as $item)
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->email }}</td>
                                                <td>{{ $item->phone }}</td>
                                                <td>{{ $item->address }}</td>
                                                <td>
                                                    <a href="{{ route('admin#deleteUserList', $item->id) }}"><button
                                                            class="btn btn-sm bg-danger text-white"><i
                                                                class="fas fa-trash-alt"></i></button></a>

                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-dark p-0">
                                <div class="ms-5 text-warning">
                                    <p class="text-dark bg-dark">{{ $user->links() }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- /.card -->
                    </div>
                </div>

            </div><!-- /.container-fluid -->

        </section>
        <!-- /.content -->
    </div>
@endsection
