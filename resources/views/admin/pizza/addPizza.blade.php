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
                                    <legend class="text-center">Add Pizza</legend>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="activity">
                                            <form class="form-horizontal" method="POST"
                                                action="{{ route('admin#insertPizza') }}" enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="Name" class="col-sm-2 col-form-label">Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="Name"
                                                            placeholder="Name" name="name" value="{{ old('name') }}">
                                                        @if ($errors->has('name'))
                                                            <p class="text-danger">{{ $errors->first('name') }}</p>
                                                        @endif
                                                    </div>

                                                </div>

                                                <div class="form-group row">
                                                    <label for="Image" class="col-sm-2 col-form-label">Image</label>
                                                    <div class="col-sm-10">
                                                        <input type="file" class="form-control" id="Image"
                                                            placeholder="Image" name="image" value="{{ old('image') }}">
                                                        @if ($errors->has('image'))
                                                            <p class="text-danger">{{ $errors->first('image') }}</p>
                                                        @endif
                                                    </div>

                                                </div>

                                                <div class="form-group row">
                                                    <label for="Price" class="col-sm-2 col-form-label">Price</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="Price"
                                                            placeholder="Price" name="price" value="{{ old('price') }}">
                                                        @if ($errors->has('price'))
                                                            <p class="text-danger">{{ $errors->first('price') }}</p>
                                                        @endif
                                                    </div>

                                                </div>

                                                <div class="form-group row">
                                                    <label for="Publish Status" class="col-sm-2 col-form-label">Publish
                                                        Status</label>
                                                    <div class="col-sm-10">
                                                        <select name="publishStatus" id="Publish Status"
                                                            class="form-select">
                                                            {{-- @if (va)

                                                            @else

                                                            @endif --}}
                                                            <option value="">Choose Option....</option>
                                                            <option value="0">Unpublish</option>
                                                            <option value="1">Publish</option>
                                                        </select>
                                                        @if ($errors->has('publish'))
                                                            <p class="text-danger">{{ $errors->first('publish') }}</p>
                                                        @endif
                                                    </div>

                                                </div>

                                                <div class="form-group row">
                                                    <label for="Category" class="col-sm-2 col-form-label">Category</label>
                                                    <div class="col-sm-10">
                                                        <select name="category" id="Category" class="form-select">
                                                            <option value="">Choose Category...</option>
                                                            @foreach ($category as $item)
                                                                <option value="{{ $item->category_id }}">
                                                                    {{ $item->category_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @if ($errors->has('category'))
                                                            <p class="text-danger">{{ $errors->first('category') }}</p>
                                                        @endif
                                                    </div>

                                                </div>

                                                <div class="form-group row">
                                                    <label for="Discount" class="col-sm-2 col-form-label">Discount</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="Discount"
                                                            placeholder="Discount" name="discount"
                                                            value="{{ old('discount') }}">
                                                        @if ($errors->has('discount'))
                                                            <p class="text-danger">{{ $errors->first('discount') }}</p>
                                                        @endif
                                                    </div>

                                                </div>

                                                <div class="form-group row">
                                                    <label for="buyOneGetOneFree" class="col-sm-2 col-form-label">Buy
                                                        1 Get 1</label>
                                                    <div class="col-sm-10">


                                                        <input type="radio" name="buyOneGetOne" class="form-input-check"
                                                            id="yes" value="1">
                                                        <label for="yes">Yes</label>
                                                        <input type="radio" name="buyOneGetOne" class="form-input-check"
                                                            id="no" value="0">
                                                        <label for="no">No</label>

                                                        @if ($errors->has('buyOneGetOne'))
                                                            <p class="text-danger">
                                                                {{ $errors->first('buyOneGetOne') }}
                                                            </p>
                                                        @endif
                                                    </div>

                                                </div>
                                                <div class="form-group row">
                                                    <label for="waitingTime" class="col-sm-2 col-form-label">Waiting
                                                        Time</label>
                                                    <div class="col-sm-10">
                                                        <input type="number" name="waitingTime" class="form-control"
                                                            id="waitingTime" value="{{ old('waitingTime') }}">
                                                        @if ($errors->has('waitingTime'))
                                                            <p class="text-danger">{{ $errors->first('waitingTime') }}
                                                            </p>
                                                        @endif
                                                    </div>

                                                </div>

                                                <div class="form-group row">
                                                    <label for="Description"
                                                        class="col-sm-2 col-form-label">Description</label>
                                                    <div class="col-sm-10">
                                                        <textarea name="description" id="Descrioption" class="form-control" rows="3">{{ old('description') }}</textarea>
                                                        @if ($errors->has('description'))
                                                            <p class="text-danger">{{ $errors->first('description') }}
                                                            </p>
                                                        @endif
                                                    </div>

                                                </div>


                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <button type="submit" class="btn bg-dark text-white">Add
                                                            Pizza</button>
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
