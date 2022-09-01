<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //  direct Admin Profile
    public function profile()
    {
        $id = auth()->user()->id;
        $dataUser = User::where('id', $id)->first();
        return view('admin.profile.index')->with(['userData' => $dataUser]);
    }
    // Update Profile...
    public function updateProfile($id, Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>"required",
        ],[
            'name.required'=>"Please Fill Your Information..",
        ]);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        $updateData=$this->requestUserData($request);
        User::where('id',$id)->update($updateData);
        return back()->with(['updateSuccess'=>"User Information Updated.."]);
    }
    //  Direct  Change Password page
    public function changePasswordPage()
    {
        return view('admin.profile.changePassword');
    }
    public function changePassword($id,Request $request)
    {
        $oldPassword=$request->oldPassword;
        $newPassword=$request->newPassword;
        $confirmPassword=$request->confirmPassword;
        $dbOldPassword=auth()->user()->password;
         $validator = Validator::make($request->all(), [
            'oldPassword' => 'required',
            'newPassword' => 'required',
            'confirmPassword' => 'required',
        ],[
            'oldPassword.required'=>"Please Fill Old Password...",
            'newPassword.required'=>"Please Fill New Password...",
            'confirmPassword.required'=>"Please Fill Confirm Password..."
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        if(Hash::check($oldPassword, $dbOldPassword)){
            if($newPassword==$confirmPassword){
                if(strlen($newPassword)>=6||strlen($confirmPassword)>=6){
                    $hash=Hash::make($newPassword);
                    User::where('id',$id)->update(['password'=>$hash]);
                    return redirect()->route('admin#profile')->with(['updateSuccess'=>"Password Changed!"]);
                }else{
                    return back()->with(['lengthError'=>"Your  Password Must Be Greater Than 6! Plese Try Again!"]);
                }
            }else{
                return back()->with(['newPasswordError'=>"Your New Password Must Be Same Confirm Password! Plese Try Again!"]);
            }
        }else{
           return back()->with(['oldPasswordError'=>"Your Old Password Is Incorect! Plese Try Again!"]);
        }
    }
    // Direct User List
    public function userList(){
        if(Session::has('USER_SEARCH')){
            Session::forget('USER_SEARCH');
        }
        $data=User::where('role','user')->paginate(5);
        return view('admin.user.userList')->with(['user'=>$data]);
    }

    // Direct admin List
    public function adminList(){
        if(Session::has('USER_SEARCH')){
            Session::forget('USER_SEARCH');
        }
        $data=User::where('role','admin')->paginate(5);
        return view('admin.user.adminList')->with(['admin'=>$data]);
    }

    // User search
    public function userSearch(Request $request)
    {
        Session::put('USER_SEARCH',$request->search);
         $response=$this->searchData($request,'user');
           return view('admin.user.userList')->with(['user'=>$response]);
    }
    // Admin Search
     public function adminSearch(Request $request)
    {
        Session::put('USER_SEARCH',$request->search);
       $response=$this->searchData($request,'admin');
           return view('admin.user.adminList')->with(['admin'=>$response]);
    }

     // delete User Account
    public function deleteUserList($id){
        User::where('id',$id)->delete();
        return back()->with(['deleteSuccess'=>"Account Deleted!"]);
    }
    // Edit admin list
    public function adminListEdit($id)
    {
        $data=User::where('id',$id)
            ->where('role','admin')
            ->first();
        return view('admin.user.adminEdit')->with(['user'=>$data]);
    }
    // Update admin list
    public function updateAdminAccount($id,Request $request){
        $validator=Validator::make($request->all(),[
            'name'=>"required",
            'email'=>"required",
            'phone'=>'required',
            'address'=>'required',
            'role'=>'required',
        ]);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }
        $updateData=$this->requestUserData($request);
        if($request->role=='admin'){
            User::where('id',$id)->update($updateData);
            return redirect()->route('admin#adminList')->with(['success'=>"Success Update!"]);
        }else{
            $updateData['role']=$request->role;
            User::where('id',$id)->update($updateData);
            return redirect()->route('user#index');
        }

    }
    // Admin List  Download
    public function adminListDownload(){
        $this->downloadUserAccount("admin");
    }
    // user list Download
    public function userListDownload(){
        $this->downloadUserAccount("user");
    }

    // for user Accounts download
    private function downloadUserAccount($role){
        if(Session::has('USER_SEARCH')){
            $searchKey=Session::get('USER_SEARCH');
            $data=User::where('role',$role)
                        ->where(function ($query) use($searchKey){
                            $query->orWhere('name', 'like', '%'.$searchKey.'%')
                                    ->orWhere('email', 'like', '%'.$searchKey.'%')
                                    ->orWhere('phone', 'like', '%'.$searchKey.'%')
                                    ->orWhere('address', 'like', '%'.$searchKey.'%');
                        })
                        ->get();
        }else{
            $data = User::where('role',$role)->get();
        }

        $csvExporter = new \Laracsv\Export();

        $csvExporter->build($data, [
            'id' => 'ID',
            'name' => 'User Name',
            'email'=>'User Email',
            'phone'=>' Phone',
            'address'=>'Address',
            'created_at'=>'Created Date',
            'updated_at'=>'Updated Date',
        ]);

        $csvReader = $csvExporter->getReader();
        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = $role.'List.csv';
        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }

    // user acc search Data with paginate
    private function searchData($request,$role){
        $searchKey=$request->search;
        $searchData=User::where('role',$role)
                        ->where(function ($query) use($searchKey){
                            $query->orWhere('name', 'like', '%'.$searchKey.'%')
                                    ->orWhere('email', 'like', '%'.$searchKey.'%')
                                    ->orWhere('phone', 'like', '%'.$searchKey.'%')
                                    ->orWhere('address', 'like', '%'.$searchKey.'%');
                        })
                        ->paginate(5);
           $searchData->appends($request->all());
           return $searchData;
    }


    // Get User data
    private function requestUserData($request){
        return [
            "name"=>$request->name,
            "email"=>$request->email,
            "address"=>$request->address,
            "phone"=>$request->phone,
        ];
    }
}
