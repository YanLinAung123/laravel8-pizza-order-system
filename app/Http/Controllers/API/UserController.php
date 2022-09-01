<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use App\Models\Pizza;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // direct user home page
    public function index()
    {

        $category=Category::get();
        $pizza=Pizza::where('publish_status',1)->paginate(6);
        $status=count($pizza)==0 ?0 : 1 ;
        return Response::json(['pizza'=>$pizza,'category'=>$category , 'status'=>$status ]);
    }
    public function categoryLink($id)
    {
        $category=Category::get();
        $pizza=Pizza::where('publish_status',1)
                    ->where('category_id',$id)->paginate(6);
        $status=count($pizza)==0 ?0 : 1 ;
        return Response::json(['pizza'=>$pizza,'category'=>$category , 'status'=>$status]);
    }
    // Pizza search
    public function pizzaSearch(Request $request)
    {
        $category=Category::get();
        $pizza=Pizza::where('publish_status',1)
            ->orWhere('pizza_name','like','%'.$request->search.'%')
            ->orWhere('price','like','%'.$request->search.'%')
            ->paginate(6);
            $status=count($pizza)==0 ? 0 : 1;
        $pizza->appends($request->all());
        return Response::json(['pizza'=>$pizza,'category'=>$category,'status'=>$status]);
    }

    // Pizza Price Search
    public function priceSearch(Request $request)
    {
        $category=Category::get();
        $min=$request->minPrice;
        $max=$request->maxPrice;
        $start=$request->startDate;
        $end=$request->endDate;
        $query=Pizza::select('*')
                    ->where('publish_status',1);

        if(is_null($start)&&!is_null($end)){
            $query=$query->whereDate('created_at','<=',$end);
        }else if(!is_null($start)&&is_null($end)){
            $query=$query->whereDate('created_at','>=',$start);
        }else if(!is_null($start)&&!is_null($end)){
            $query=$query->whereDate('created_at','<=',$end);
            $query=$query->whereDate('created_at','>=',$start);
        }

        if(is_null($min)&&!is_null($max)){
            $query=$query->where('price','<=',$max);
        }else if(!is_null($min)&&is_null($max)){
            $query=$query->where('price','>=',$min);
        }else if(!is_null($min)&&!is_null($max)){
            $query=$query->where('price','<=',$max);
            $query=$query->where('price','>=',$min);
        }
        $query=$query->paginate(6);
        $status=count($query)==0 ? 0 : 1;
        $query->appends($request->all());
        return Response::json(['pizza'=>$query,'category'=>$category,'status'=>$status]);

    }
    // pizzaDetails
    public function pizzaDetails($id)
    {
        $data=Pizza::where('pizza_id',$id)->first();
        Session::put('PIZZA_INFO',$data);
        return Response::json(['pizza'=>$data]);
    }

    public function order(Request $request)
    {
        $pizza=Session::get('PIZZA_INFO');
     return Response::json(['pizza'=>$pizza]);
    }

    public function placeOrder(Request $request){
        $validator = Validator::make($request->all(), [
            'paymentType' => 'required',
            'pizzaCount'=>'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $user_id=auth()->user()->id;
        // $data=Pizza::where('pizza_id',$id)->first();
        // dd($data);
        $pizza_id=Session::get('PIZZA_INFO')['pizza_id'];
        $count=$request->pizzaCount;
        $data=$this->requestOrderData($user_id,$pizza_id,$request);
        for($i=0;$i<$count;$i++){
            Order::create($data);
        }
        $waitingTime=Session::get('PIZZA_INFO')['waiting_time']*$count;
        return Response::json(['success'=>$waitingTime]);
    }
    private function requestOrderData($user_id,$pizza_id,$request){
        return [
            'customer_id'=>$user_id,
            'pizza_id'=>$pizza_id,
            'payment_status'=>$request->paymentType,
            'carrier_id'=>0,
            'order_time'=>Carbon::now(),
        ];
    }
}
