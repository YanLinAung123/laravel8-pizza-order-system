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



                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <span class="ml-5 fs-5">Total -{{ $contact->total() }}</span>
                                <div class="card-tools d-flex">
                                    <a href="{{route('admin#downloadContact')}}" class="me-3">
                                        <button class="btn btn-success">CSV Download</button>
                                    </a>
                                    <form action="{{ route('admin#contactSearch') }}" method="get">
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
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Message</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @if ($status==0)
                                           <tr>
                                            <td colspan="4" class="text-danger fs-6">There is no Data</td>
                                           </tr>
                                       @else
                                       @foreach ($contact as $item)
                                       <tr>
                                           <td>{{ $item->contact_id }}</td>
                                           <td>{{ $item->name }}</td>
                                           <td>{{ $item->email }}</td>
                                           <td>{{ $item->message }}</td>

                                       </tr>
                                   @endforeach

                                       @endif
                                    </tbody>

                                </table>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-dark p-0">
                                <div class="ms-5 text-warning">
                                    <p class="text-dark bg-dark">{{ $contact->links() }}</p>
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
