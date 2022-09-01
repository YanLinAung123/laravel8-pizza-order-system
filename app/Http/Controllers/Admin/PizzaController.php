<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Pizza;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class PizzaController extends Controller
{
    //  direct pizza page // List
    public function pizza()
    {
        if(Session::has('USER_SEARCH')){
            Session::forget('USER_SEARCH');
        }
        $pizza = Pizza::paginate(5);
        // to control Empty Data

        if (count($pizza) == 0) {
            $emptyStatus = 0;
        } else {
            $emptyStatus = 1;
        }
        return view('admin.pizza.list')->with(['pizza' => $pizza, 'emptyStatus' => $emptyStatus]);
    }
    // Create Pizza with Getting Category
    public function createPizza()
    {

        $category = Category::select('category_name', 'category_id')->get();
        // dd($category->toArray());
        return view('admin.pizza.addPizza')->with(['category' => $category]);
    }
    //  Inserting Pizza
    public function insertPizza(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required',
            'price' => 'required',
            'publishStatus' => 'required',
            'discount' => 'required',
            'category' => 'required',
            'buyOneGetOne' => 'required',
            'waitingTime' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $file = $request->file('image');
        $fileName = uniqid() . '_yaung_' . $file->getClientOriginalName();
        $file->move(public_path() . '/uploads/', $fileName);

        $data = $this->requestPizzaData($request, $fileName);
        Pizza::create($data);
        return redirect()->route('admin#pizza')->with(['createSuccess' => "Pizza Created..."]);
    }
    // Info pizza
    public function infoPizza($id)
    {
        $pizza = Pizza::where('pizza_id', "=", $id)->first();
        return view('admin.pizza.info')->with(['pizza' => $pizza]);
    }

    //  Edit Pizza

    public function editPizza($id)
    {
        $category = Category::get();

        $data = Pizza::select('pizzas.*', 'categories.*')
            ->join('categories', 'pizzas.category_id', 'categories.category_id')
            ->where('pizza_id', $id)
            ->first();

        return view('admin.pizza.edit')->with(['pizza' => $data, 'category' => $category]);
    }
    // Update Pizza
    public function updatePizza($id,Request $request)
    {
         $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'publishStatus' => 'required',
            'discount' => 'required',
            'category' => 'required',
            'buyOneGetOne' => 'required',
            'waitingTime' => 'required',
            'description' => 'required',
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
       $updateData= $this->requestUpdateData($request);
        if(isset($updateData['image'])){

            //  Get Old Image Name
            $file=Pizza::select('image')->where('pizza_id',$id)->first();
            $fileName=$file['image'];
            if(File::exists(public_path().'/uploads/'.$fileName)){
                File::delete(public_path().'/uploads/'.$fileName);

            }
            // Get New image Name and Move It to Public folder
            $file=$request->file('image');
            $fileName=uniqid().'updated_'.$file->getClientOriginalName();
            $file->move(public_path().'/uploads/',$fileName);
           $updateData['image']=$fileName;
        }
             Pizza::where('pizza_id',$id)->update($updateData);
            return redirect()->route('admin#pizza')->with(['updateSuccess'=>"Pizza Updated.."]);
    }
    // Delete Pizza
    public function deletePizza($id)
    {
        $data = Pizza::select('image')->where('pizza_id', $id)->first();
        $fileName = $data['image'];

        //  Project Image Delete

        if (File::exists(public_path() . '/uploads/' . $fileName)) {
            File::delete(public_path() . '/uploads/' . $fileName);
        }

        // Project List Delete

        Pizza::where('pizza_id', $id)->delete();
        return back()->with(['deleteSuccess' => 'Pizza Deleted..']);

    }

    // Search Pizza
    public function searchPizza(Request $request)
    {
        $searchKey=$request->search;
        Session::put('USER_SEARCH',$searchKey);
        $searchData=Pizza::where('pizza_name','like','%'.$searchKey.'%')->paginate(5);

        if (count($searchData) == 0) {
            $emptyStatus = 0;
        } else {
            $emptyStatus = 1;
        }
        $searchData->appends($request->all());
        return view('admin.pizza.list')->with(['pizza'=>$searchData,'emptyStatus' => $emptyStatus]);
    }
    // pizza Download

    public function pizzaDownload(){
        if(Session::has('USER_SEARCH')){
            $searchKey=Session::get('USER_SEARCH');
            $data=Pizza::select('pizzas.*','categories.category_name')
                        ->where('pizza_name','like','%'.$searchKey.'%')
                        ->join('categories','pizzas.category_id','categories.category_id')
                        ->get();
        }else{
            $data = Pizza::select('pizzas.*','categories.category_name')
                        ->join('categories','pizzas.category_id','categories.category_id')
                        ->get();
        }
        foreach($data as $item){
            if($item->buy_one_get_one_status==1){
                $item->buy_one_get_one_status="YES";
            }else{
                $item->buy_one_get_one_status="NO";
            }
            if($item->publish_status==1){
                $item->publish_status="YES";
            }else{
                $item->publish_status="NO";
            }
        }

        $csvExporter = new \Laracsv\Export();

        $csvExporter->build($data, [
            'pizza_id' => 'ID',
            'pizza_name' => 'Name',
            'category_name'=>'Category Name',
            'price'=>'Price',
            'discount_price'=>'Discount',
            'publish_status'=>'Publish Status',
            'buy_one_get_one_status'=>'Buy One Get One',
            'waiting_time'=>"Waiting Time",
            'description'=>'Description',
            'updated_at'=>'Updated Date',
        ]);

        $csvReader = $csvExporter->getReader();
        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'Pizza.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }
    // Request Data To update
    private function requestUpdateData($request)
    {
        $arr= [
            'pizza_name' => $request->name,
            'publish_status' => $request->publishStatus,
            'price' => $request->price,
            'category_id' => $request->category,
            'discount_price' => $request->discount,
            'buy_one_get_one_status' => $request->buyOneGetOne,
            'waiting_time' => $request->waitingTime,
            'description' => $request->description,
            'Created_at' => Carbon::now(),
            'Updated_at' => Carbon::now(),
        ];
        if(isset($request->image)){
            $arr["image"]=$request->image;
        }
        return $arr;
    }

    //  Defining Variable To create Pizza
    private function requestPizzaData($request, $fileName)
    {
        return [
            'pizza_name' => $request->name,
            'image' => $fileName,
            'publish_status' => $request->publishStatus,
            'price' => $request->price,
            'category_id' => $request->category,
            'discount_price' => $request->discount,
            'buy_one_get_one_status' => $request->buyOneGetOne,
            'waiting_time' => $request->waitingTime,
            'description' => $request->description,
            'Created_at' => Carbon::now(),
            'Updated_at' => Carbon::now(),
        ];
    }
}
