@extends('admin.layout.app')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                {{-- Create Success Message --}}

                @if (Session::has('successCreate'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('successCreate') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Update Success Message --}}
                @if (Session::has('successUpdate'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        {{ Session::get('successUpdate') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                {{-- Delete Success Message --}}
                @if (Session::has('successDelete'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ Session::get('successDelete') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="{{ route('admin#addCategory') }}"><button
                                            class="btn btn-sm btn-outline-dark">Add
                                            Category</button></a>
                                </h3>
                                <span class="ml-5 fs-5">Total -{{ $categoryData->total() }}</span>
                                <div class="card-tools d-flex">
                                    <a href="{{route('admin#categoryDownload')}}" class="me-3">
                                        <button class="btn btn-success">CSV Download</button>
                                    </a>
                                    <form action="{{ route('admin#searchCategory') }}" method="get">
                                        @csrf
                                        <div class="input-group input-group-sm mt-1" style="width: 150px;">
                                            <input type="text" name="searchCategory" class="form-control float-right"
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
                                            <th>Category Name</th>
                                            <th>Count</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categoryData as $item)
                                            <tr>
                                                <td>{{ $item->category_id }}</td>
                                                <td>{{ $item->category_name }}</td>
                                                <td>
                                                    @if ($item->count==0)
                                                        <a href="#">{{$item->count}}</a>
                                                    @else
                                                        <a href="{{route('admin#categoryItem',$item->category_id)}}">{{$item->count}}</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin#editCategory', $item->category_id) }}"><button
                                                            class="btn btn-sm bg-dark text-white"><i
                                                                class="fas fa-edit"></i></button></a>
                                                    <a href="{{ route('admin#deleteCategory', $item->category_id) }}"><button
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
                                    <p class="text-dark bg-dark">{{ $categoryData->links() }}</p>
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
