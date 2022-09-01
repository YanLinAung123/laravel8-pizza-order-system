@extends('admin.layout.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            @if (Session::has('createSuccess'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ Session::get('createSuccess') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @if (Session::has('updateSuccess'))
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    {{ Session::get('updateSuccess') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @if (Session::has('deleteSuccess'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ Session::get('deleteSuccess') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            <div class="card-header">
                                <h3 class="card-title ms-4 "><a href="{{ route('admin#createPizza') }}"
                                        class="text-dark"><i class="fas fa-plus"></i></a></h3>
                                <span class="ml-5 fs-5">Total -{{ $pizza->total() }}</span>
                                <div class="card-tools d-flex">
                                    <a href="{{route('admin#downloadPizza')}}" class="me-3">
                                        <button class="btn btn-success">CSV Download</button>
                                    </a>
                                    <form action="{{ route('admin#searchPizza') }}" method="get" class="mt-1">
                                        @csrf
                                        <div class="input-group input-group-sm" style="width: 150px;">
                                            <input type="text" name="search" class="form-control float-right"
                                                placeholder="Search" value="{{ old('search') }}">
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
                                            <th>Pizza Name</th>
                                            <th>Image</th>
                                            <th>Price</th>
                                            <th>Publish Status</th>
                                            <th>Buy 1 Get 1 Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($emptyStatus == null)
                                            <tr>
                                                <td colspan="6" class="text-danger fs-4">There is no data to show</td>
                                            </tr>
                                        @else
                                            @foreach ($pizza as $item)
                                                <tr>
                                                    <td>{{ $item->pizza_id }}</td>
                                                    <td>{{ $item->pizza_name }}</td>
                                                    <td>
                                                        <img src="{{ asset('uploads/' . $item->image) }}"
                                                            style="width: 100px; height:100px;"
                                                            class="img-thumbnail border-rounded ">
                                                    </td>
                                                    <td>{{ $item->price }} kyats</td>
                                                    <td>
                                                        @if ($item->publish_status == 0)
                                                            Unpublish
                                                        @elseif ($item->publish_status == 1)
                                                            Publish
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($item->buy_one_get_one_status == 0)
                                                            No
                                                        @elseif ($item->buy_one_get_one_status == 1)
                                                            Yes
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin#editPizza', $item->pizza_id) }}">
                                                            <button class="btn btn-sm bg-dark text-white"><i
                                                                    class="fas fa-edit"></i></button></a>
                                                        <a href="{{ route('admin#deletePizza', $item->pizza_id) }}">
                                                            <button class="btn btn-sm bg-danger text-white"><i
                                                                    class="fas fa-trash-alt"></i></button>
                                                        </a>
                                                        <a href="{{ route('admin#infoPizza', $item->pizza_id) }}">
                                                            <button class="btn btn-sm bg-primary text-white"><i
                                                                    class="fas fa-eye"></i></button>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif

                                    </tbody>

                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="ms-5 mt-2">
                                {{ $pizza->links() }}
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
