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
                                    <legend class="text-center">Edit Pizza</legend>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="text-center mb-2">
                                            <img src="{{ asset('uploads/' . $pizza->image) }}" alt=""
                                                class="w-50 h-50 img-thumbnail rounded-lg">
                                        </div>
                                        <div class="active tab-pane" id="activity">
                                            <form class="form-horizontal" method="POST"
                                                action="{{ route('admin#updatePizza', $pizza->pizza_id) }}"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="form-group row">
                                                    <label for="Name" class="col-sm-2 col-form-label">Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="Name"
                                                            placeholder="Name" name="name"
                                                            value="{{ old('name', $pizza->pizza_name) }}">
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
                                                            placeholder="Price" name="price"
                                                            value="{{ old('price', $pizza->price) }}">
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
                                                            <option value="">Choose Option....</option>
                                                            @if ($pizza->publish_status == 0)
                                                                <option value="0" selected>Unpublish</option>
                                                                <option value="1">Publish</option>
                                                            @elseif ($pizza->publish_status == 1)
                                                                <option value="0">Unpublish</option>
                                                                <option value="1" selected>Publish</option>
                                                            @endif
                                                        </select>
                                                        @if ($errors->has('publishStatus'))
                                                            <p class="text-danger">{{ $errors->first('publishStatus') }}
                                                            </p>
                                                        @endif
                                                    </div>

                                                </div>

                                                <div class="form-group row">
                                                    <label for="Category" class="col-sm-2 col-form-label">Category</label>
                                                    <div class="col-sm-10">
                                                        <select name="category" id="Category" class="form-select">
                                                            <option value="{{ $pizza->category_id }}">
                                                                {{ $pizza->category_name }}</option>
                                                            @foreach ($category as $item)
                                                                @if ($item->category_id != $pizza->category_id)
                                                                    <option value="{{ $item->category_id }}">
                                                                        {{ $item->category_name }}</option>
                                                                @endif
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
                                                            value="{{ old('discount', $pizza->discount_price) }}">
                                                        @if ($errors->has('discount'))
                                                            <p class="text-danger">{{ $errors->first('discount') }}</p>
                                                        @endif
                                                    </div>

                                                </div>

                                                <div class="form-group row">
                                                    <label for="buyOneGetOneFree" class="col-sm-2 col-form-label">Buy
                                                        1 Get 1</label>
                                                    <div class="col-sm-10">
                                                        @if ($pizza->buy_one_get_one_status == 1)
                                                            <input type="radio" name="buyOneGetOne"
                                                                class="form-input-check" id="yes" value="1"
                                                                checked>
                                                            <label for="yes">Yes</label>
                                                        @else
                                                            <input type="radio" name="buyOneGetOne"
                                                                class="form-input-check" id="yes" value="0">
                                                            <label for="yes">Yes</label>
                                                        @endif
                                                        @if ($pizza->buy_one_get_one_status == 0)
                                                            <input type="radio" name="buyOneGetOne"
                                                                class="form-input-check" id="no" value="0"
                                                                checked>
                                                            <label for="no">No</label>
                                                        @else
                                                            <input type="radio" name="buyOneGetOne"
                                                                class="form-input-check" id="no" value="0">
                                                            <label for="no">No</label>
                                                        @endif


                                                    </div>

                                                </div>
                                                <div class="form-group row">
                                                    <label for="waitingTime" class="col-sm-2 col-form-label">Waiting
                                                        Time</label>
                                                    <div class="col-sm-10">
                                                        <input type="number" name="waitingTime" class="form-control"
                                                            id="waitingTime"
                                                            value="{{ old('waitingTime', $pizza->waiting_time) }}">
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
                                                        <textarea name="description" id="Descrioption" class="form-control" rows="3">{{ old('description', $pizza->description) }}</textarea>
                                                        @if ($errors->has('description'))
                                                            <p class="text-danger">{{ $errors->first('description') }}
                                                            </p>
                                                        @endif
                                                    </div>

                                                </div>


                                                <div class="form-group row">
                                                    <div class="offset-sm-2 col-sm-10">
                                                        <button type="submit" class="btn bg-dark text-white">Update
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
