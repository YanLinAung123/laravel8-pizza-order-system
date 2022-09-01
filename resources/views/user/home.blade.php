@extends('user/layouts/style')
@section('content')
    <!-- Page Content-->
    <div class="container px-4 px-lg-5" >
        @if (Session::has('success'))
                    <div class="alert mt-5 alert-success alert-dismissible fade show" role="alert">
                        {{ Session::get('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
        <!-- Heading Row-->
        <div class="row gx-4 gx-lg-5 align-items-center mt-5" id="about">
            <div class="col-lg-7"><img class="img-fluid rounded mb-4 mb-lg-0" id="code-lab-pizza" src="https://www.pizzamarumyanmar.com/wp-content/uploads/2019/04/chigago.jpg" alt="..." /></div>
            <div class="col-lg-5">
                <h1 class="font-weight-light" >CODE LAB Pizza</h1>
                <p>This is a template that is great for small businesses. It doesn't have too much fancy flare to it, but it makes a great use of the standard Bootstrap core components. Feel free to use this template for any project you want!</p>
                <a class="btn btn-primary" href="#!">Enjoy!</a>
            </div>
        </div>

        <!-- Content Row-->
        <div class="d-flex my-0">
            <div class="col-3 me-5">
                <div class="">
                    <div class=" text-center">
                        <form class="d-flex m-5" method="get" action="{{route('user#pizzaSearch')}}">
                            <input class="form-control me-2" name="search" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn btn-outline-dark" type="submit">Search</button>
                        </form>

                        <div class="">
                            <a href="{{route('user#index')}}" class="text-decoration-none text-black"><div class="m-2 p-2">All</div></a>
                            @foreach ($category as $item)
                                <a href="{{route('user#categoryLink',$item->category_id)}}" class="text-decoration-none text-black"><div class="m-2 p-2">{{$item->category_name}}</div></a>
                            @endforeach

                        </div>
                        <hr>
                        <form action="{{route('user#priceSearch')}}" method="get">
                            <div class="text-center m-4 p-2">
                                <h3 class="mb-3">Start Date - End Date</h3>
                                    <input type="date" name="startDate" id="" class="form-control"> -
                                    <input type="date" name="endDate" id="" class="form-control">
                            </div>
                            <hr>
                            <div class="text-center m-4 p-2">
                                <h3 class="mb-3">Min - Max Amount</h3>
                                    <input type="number" name="minPrice" id="" class="form-control" placeholder="minimum price"> -
                                    <input type="number" name="maxPrice" id="" class="form-control" placeholder="maximun price">
                            </div>
                            <button type="submit">Search <i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="mt-5 col-9">
                <div class="row gx-4 " id="pizza">
                   @if ($status==0)
                       <div class="col-6 offset-3 mt-5">
                        <h4 class="text-danger">There is no data to show</h4>
                       </div>
                   @else
                   @foreach ($pizza as $item)
                   <div class="col-4 mb-5">
                       <div class="card h-100">
                           <!-- Sale badge-->
                           @if ($item->buy_one_get_one_status==1)
                           <div class="badge bg-danger fs-6 text-white position-absolute" style="top: 0.5rem; right: 0.5rem">Buy One Get One</div>
                           @endif
                           <!-- Product image-->
                           <img class="card-img-top" src="{{asset('uploads/'.$item->image)}}" height="200px" alt="There is no image" id="pizza-image" />
                           <!-- Product details-->
                           <div class="card-body p-4">
                               <div class="text-center">
                                   <!-- Product name-->
                                   <h5 class="fw-bolder">{{$item->pizza_name}}</h5>
                                   <!-- Product price-->
                                   <h3>{{$item->price}}</h3>
                                   {{-- <span class="text-muted text-decoration-line-through">$20.00</span> $18.00 --}}
                               </div>
                           </div>
                           <!-- Product actions-->
                           <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                               <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="{{route('user#pizzaDetails',$item->pizza_id)}}">More Details</a></div>
                           </div>
                           {{$pizza->links()}}
                       </div>

                   </div>
                   @endforeach
                   @endif


                </div>
            </div>
        </div>
    </div>

    <div class="text-center d-flex justify-content-center align-items-center" id="contact">
        <div class="col-4 border shadow-sm ps-5 pt-5 pe-5 pb-2 mb-5">
            <h3>Contact Us</h3>

            <form action="{{route('user#createContact')}}" method="POST" class="my-4">
                @csrf
                <input type="text" name="name" value="{{old('name')}}" class="form-control my-3" placeholder="Name">
                @if ($errors->has('name'))
                    <p class="text-danger m-0">{{$errors->first('name')}}</p>
                @endif
                <input type="text" name="email" value="{{old('email')}}" class="form-control my-3" placeholder="Email">
                @if ($errors->has('email'))
                    <p class="text-danger m-0">{{$errors->first('email')}}</p>
                @endif
                <textarea class="form-control my-3" name="message" rows="3" placeholder="Message">{{old('message')}}</textarea>
                @if ($errors->has('message'))
                    <p class="text-danger m-0">{{$errors->first('message')}}</p>
                @endif
                <button type="submit" class="btn btn-outline-dark">Send  <i class="fas fa-arrow-right"></i></button>
            </form>
        </div>
    </div>

@endsection
