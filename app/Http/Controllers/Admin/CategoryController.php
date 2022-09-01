<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Pizza;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Response;
class CategoryController extends Controller
{
    // Direct Category List
    public function category()
    {
        if(Session::has('CATEGORY_SEARCH')){
            Session::forget('CATEGORY_SEARCH');
        }
        DB::statement("SET SQL_MODE=''");
        $data = Category::select('categories.*',DB::raw('COUNT(pizzas.category_id) as count'))
                ->leftJoin('pizzas','pizzas.category_id','categories.category_id')
                ->groupBy('categories.category_id')
                ->paginate(5);
        return view('admin.category.list')->with(['categoryData' => $data]);
        //return Response::json($data);
    }

    // Direct Add Category
    public function addCategory()
    {
        return view('admin.category.addCategory');
    }
    // Look Category Item
    public function categoryItem($id)
    {
        $data=Pizza::select('pizzas.*','categories.category_name')
                ->join('categories','categories.category_id','pizzas.category_id')
                ->where('pizzas.category_id',$id)
                ->paginate(5);

        return view('admin.category.item')->with(['pizza'=>$data]);
    }

    //  Direct Create Category
    public function createCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $data = [
            'category_name' => $request->name
        ];
        Category::create($data);
        return redirect()->route('admin#category')->with(['successCreate' => "New Category Added"]);
    }
        // Edit Category
    public function editCategory($id)
    {
        $data = Category::where('category_id', $id)->first();
        return view('admin.category.updateCategory')->with(['category' => $data]);
    }
    //  Update Category
    public function updateCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $id = $request->id;
        $data = [
            'category_name' => $request->name
        ];
        Category::where('category_id', $request->id)->update($data);
        return redirect()->route('admin#category')->with(['successUpdate' => " Category Updated..."]);
    }
    // Delete Category
    public function deleteCategory($id)
    {
        Category::where('category_id', $id)->delete();
        return back()->with(['successDelete' => "Deleted Success...."]);
    }

    // search Category

    public function searchCategory(Request $request)
    {
        $searchData = Category::select('categories.*',DB::raw('COUNT(pizzas.category_id) as count'))
                            ->leftJoin('pizzas','pizzas.category_id','categories.category_id')
                            ->groupBy('categories.category_id')
                            ->where('category_name', 'like', '%' . $request->searchCategory . '%')
                            ->paginate(5);
        Session::put('CATEGORY_SEARCH',$request->searchCategory);
        $searchData->appends($request->all());
        return view('admin.category.list')->with(['categoryData' => $searchData]);
    }

    // Category Download
    public function categoryDownload()
    {
        if(Session::has('CATEGORY_SEARCH')){
            $data = Category::select('categories.*',DB::raw('COUNT(pizzas.category_id) as count'))
            ->leftJoin('pizzas','pizzas.category_id','categories.category_id')
            ->groupBy('categories.category_id')
            ->where('category_name', 'like', '%' . Session::get('CATEGORY_SEARCH') . '%')
            ->get();
        }else{
            $data = Category::select('categories.*',DB::raw('COUNT(pizzas.category_id) as count'))
            ->leftJoin('pizzas','pizzas.category_id','categories.category_id')
            ->groupBy('categories.category_id')
            ->get();
        }

        $csvExporter = new \Laracsv\Export();

        $csvExporter->build($data, [
            'category_id' => 'ID',
            'category_name' => 'Category Name',
            'count'=>'Product Count',
            'created_at'=>'Created Date',
            'updated_at'=>'Updated Date',
        ]);

        $csvReader = $csvExporter->getReader();
        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'categoryList.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }
}
