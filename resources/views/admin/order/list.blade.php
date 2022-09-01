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
                            <div class="card-header">
                                <span class="ml-5 fs-5">Total -{{ $order->total() }}</span>
                                <div class="card-tools d-flex">
                                    <a href="{{route('admin#downloadOrder')}}" class="me-3">
                                        <button class="btn btn-success">CSV Download</button>
                                    </a>
                                    <form action="{{route('admin#orderSearch')}}" method="get" class="mt-1">
                                        @csrf
                                        <div class="input-group input-group-sm" style="width: 150px;">
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
                                            <th>Customer Name</th>
                                            <th>Pizza Name</th>
                                            <th>Count</th>
                                            <th>Order Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($status==0)
                                            <tr>
                                                <td colspan="5" class="text-danger">There is no data to show!</td>
                                            </tr>
                                        @else
                                        @foreach ($order as $item)
                                        <tr>
                                            <td>{{ $item->order_id }}</td>
                                            <td>{{ $item->customer_name }}</td>
                                            <td>{{ $item->pizza_name }}</td>
                                            <td>{{ $item->count }}</td>
                                            <td>{{ $item->order_time }}</td>

                                        </tr>
                                    @endforeach
                                        @endif


                                    </tbody>

                                </table>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-dark p-0">
                                <div class="ms-5 text-warning">
                                    <p class="text-dark bg-dark">{{ $order->links() }}</p>
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
