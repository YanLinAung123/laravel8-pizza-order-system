<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function orderList(){
        if(Session::has("USER_SEARCH")){
            Session::forget("USER_SEARCH");
        }
        $data=Order::select('orders.*','users.name as customer_name','pizzas.pizza_name as pizza_name',DB::raw('COUNT(orders.pizza_id) as count'))
                ->groupBy('orders.customer_id','orders.pizza_id')
                ->join('pizzas','pizzas.pizza_id','orders.pizza_id')
                ->join('users','users.id','orders.customer_id')
                ->paginate(6);
        $status=count($data)==0 ? 0 : 1;
        return view('admin.order.list')->with(['order'=>$data,'status'=>$status]);
    }
    // order search
    public function orderSearch(Request $request)
    {
        Session::put('USER_SEARCH',$request->search);
        $data=Order::select('orders.*','users.name as customer_name','pizzas.pizza_name as pizza_name',DB::raw('COUNT(orders.pizza_id) as count'))
                ->join('pizzas','pizzas.pizza_id','orders.pizza_id')
                ->join('users','users.id','orders.customer_id')
                ->orWhere('orders.order_id','like','%'.$request->search.'%')
                ->orWhere('users.name','like','%'.$request->search.'%')
                ->orWhere('pizzas.pizza_name','like','%'.$request->search.'%')
                ->groupBy('orders.customer_id','orders.pizza_id')
                ->paginate(5);
                // dd($data->toArray());
                $status=count($data)==0 ? 0 : 1;
        $data->appends($request->all());
        return view('admin.order.list')->with(['order'=>$data,'status'=>$status]);
    }

    // order download

    public function orderDownload(){
        if(Session::has('USER_SEARCH')){
            $searchKey=Session::get('USER_SEARCH');
            $data=Order::select('orders.*','users.name as customer_name','pizzas.pizza_name as pizza_name',DB::raw('COUNT(orders.pizza_id) as count'))
                        ->join('pizzas','pizzas.pizza_id','orders.pizza_id')
                        ->join('users','users.id','orders.customer_id')
                        ->orWhere('orders.order_id','like','%'.$searchKey.'%')
                        ->orWhere('users.name','like','%'.$searchKey.'%')
                        ->orWhere('pizzas.pizza_name','like','%'.$searchKey.'%')
                        ->groupBy('orders.customer_id','orders.pizza_id')
                        ->get();
        }else{
            $data = Order::select('orders.*','users.name as customer_name','pizzas.pizza_name as pizza_name',DB::raw('COUNT(orders.pizza_id) as count'))
                            ->groupBy('orders.customer_id','orders.pizza_id')
                            ->join('pizzas','pizzas.pizza_id','orders.pizza_id')
                            ->join('users','users.id','orders.customer_id')
                            ->get();
        }
        foreach($data as $item){
            if($item->payment_status==0){
                $item->payment_status="Credit";
            }else{
                $item->payment_status="Chash";
            }
        }

        $csvExporter = new \Laracsv\Export();

        $csvExporter->build($data, [
            'order_id' => 'ID',
            'customer_name' => 'Customer Name',
            'pizza_name'=>'Pizza Name',
            'count'=>'Pizza Count',
            'order_time'=>'Order Time',
            'payment_status'=>'Publish Status',

        ]);

        $csvReader = $csvExporter->getReader();
        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'Order.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }
}
