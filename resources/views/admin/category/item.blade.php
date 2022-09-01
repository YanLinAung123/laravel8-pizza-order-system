@extends('admin.layout.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="my-3">
                            <h3 class="ml-5">
                                {{$pizza[0]->category_name}}
                            </h3>
                        </div>
                        <div class="card">

                            <div class="card-header">

                                <span class="ml-5 fs-5">Total -{{ $pizza->total() }}</span>

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap text-center">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Category Name</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pizza as $item)
                                            <tr>
                                                <td>{{ $item->pizza_id }}</td>
                                                <td>
                                                    <img src="{{asset('uploads/'.
                                                    $item->image)}}" alt="" width="150">
                                                </td>
                                                <td>{{ $item->pizza_name }}</td>
                                                <td>
                                                    {{$item->price}}
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>

                                </table>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-dark p-0">
                                {{-- <div class="ms-5 text-warning">
                                    <p class="text-dark bg-dark">{{ $categoryData->links() }}</p>
                                </div> --}}
                            </div>
                        </div>

                        <!-- /.card -->
                    </div>
                </div>

            </div><!-- /.container-fluid -->
            <a href="{{ route('admin#category') }}">
                <button class="btn btn-dark mb-2 text-light"><i class="fas fa-arrow-left"></i>back</button>
            </a>
        </section>
        <!-- /.content -->
    </div>
@endsection
