@extends('user.layouts.style')
@section('content')
{{-- Delete Success Message --}}
@if (Session::has('success'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <h5>Order Success ! Please Wait <i class="text-success">{{ Session::get('success') }}</i> Minutes..</h5>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="row mt-5 d-flex justify-content-center">
    <div class="col-4">
        <img src="{{asset('uploads/'.$pizza->image)}}" class="img-thumbnail" width="100%">            <br>
        <a href="{{route('user#index')}}">
            <button class="btn bg-dark text-white" style="margin-top: 20px;">
                <i class="fas fa-backspace"></i> Back
            </button>
        </a>
    </div>
    <div class="col-6">
       <h5>Name</h5>
       <small class="ms-2"> {{$pizza->pizza_name}}</small>
       <hr>
       <h5>Waiting Time</h5>
       <small class="ms-2"> {{$pizza->waiting_time}}</small> Minutes
       <hr>
       <h5>Price</h5>
       <small class="ms-2"> {{$pizza->price-$pizza->discount_price}} Kyats</small><hr>
       <form action="{{route('user#placeOrder')}}" method="post">
        @csrf
        <h5> Pizza Count </h5>
       <input type="number" name="pizzaCount" id="" class="form-control" placeholder="Number of Pizza you want!"><hr>
         @if ($errors->has('pizzaCount'))
            <p class="text-danger">{{ $errors->first('pizzaCount') }}</p>
        @endif
       <h5>Payment Type</h5>
       <div class="form-check form-check-inline">
        <input type="radio" name="paymentType" value="0" class="form-check-input" id="credit">
        <label for="credit" class="form-check-label">Credit</label>
       </div>
       <div class="form-check form-check-inline">
        <input type="radio" name="paymentType" value="1" class="form-check-input" id="cash">
        <label for="cash" class="form-check-label">Chash</label>

       </div><br>
       @if ($errors->has('paymentType'))
        <p class="text-danger">{{ $errors->first('paymentType') }}</p>
    @endif
    <hr>
       <button type="submit" class="btn btn-primary float-end mt-2 col-4 ">Order<i class="fas fa-shopping-cart"></i></button>
       </form>
       </div>
    </div>
</div>

@endsection
