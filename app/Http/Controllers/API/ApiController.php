<?php

namespace App\Http\Controllers\API;
use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
class ApiController extends Controller
{
    // Category List
    public function categoryList(){
        $category=Category::get();
        $response=[
            'status'=>200,
            'message'=>'success',
            'data'=>$category,
        ];
        return Response::json($response);
    }
    // Create Category
    public function createCategory(Request $request){
        // dd($request->all());
        $data=[
            'category_name'=>$request->categoryName,
            'created_at'=>Carbon::now(),
            'updated_at'=>Carbon::now(),
        ];
        Category::create($data);
        $response=[
            'status'=>200,
            'message'=>"Success Create",
        ];
        return Response::json($response);
    }
    // update Category
    public function updateCategory(Request $request){
        $updateData=[
            'category_id'=>$request->id,
            'category_name'=>$request->categoryName,
        ];
        $check=Category::where('category_id',$request->id)->first();
        if(!empty($check)){
            Category::where('category_id',$request->id)->update($updateData);
            $response=[
                'message'=>'Update Success',
                'status'=>200,
            ];
            return Response::json($response);
        }
        $response=[
            'message'=>'Nothing To Update',
            'status'=>200,
        ];
        return Response::json($response);

    }
    // detail Category
    public function detailsCategory($id){
        $category=Category::where('category_id',$id)->first();
        if(empty($category)){
            $response=[
                'message'=>"There is no data to show!",
                'status'=>200,
            ];
        }else{
            $response=[

                'status'=>200,
                'message'=>"Success!",
                'data'=>$category,
            ];

        }
        return Response::json($response);
    }
}
