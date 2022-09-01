<?php

namespace App\Http\Controllers\Admin;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function createContact(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'message' => 'required',

        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $data=$this->requestUserData($request);
        Contact::create($data);
        return back()->with(['success'=>"Contact Success"]);
    }
    // Contact List
    public function contactList(){
        if(Session::has('USER_SEARCH')){
            Session::forget('USER_SEARCH');
        }
        $data=Contact::orderBy('contact_id','desc')->paginate(5);
        if (count($data) == 0) {
            $emptyStatus = 0;
        } else {
            $emptyStatus = 1;
        }
        return view('admin.contact.list')->with(['contact'=>$data,'status'=>$emptyStatus]);
    }
    // Contact search
    public function contactSearch(Request $request)
    {
        Session::put('USER_SEARCH',$request->search);
        $data=Contact::orWhere('name','like','%'.$request->search.'%')
            ->orWhere('email','like','%'.$request->search.'%')
            ->orWhere('message','like','%'.$request->search.'%')
            ->orWhere('contact_id','like','%'.$request->search.'%')
            ->paginate(5);
        $data->appends($request->all());
        if (count($data) == 0) {
            $emptyStatus = 0;
        } else {
            $emptyStatus = 1;
        }
        return view('admin.contact.list')->with(['contact'=>$data,'status'=>$emptyStatus]);
    }
    // download Contact list
    public function contactDownload(){
        if(Session::has('USER_SEARCH')){
            $searchKey=Session::get('USER_SEARCH');
            $data=Contact::orWhere('name','like','%'.$searchKey.'%')
            ->orWhere('email','like','%'.$searchKey.'%')
            ->orWhere('message','like','%'.$searchKey.'%')
            ->orWhere('contact_id','like','%'.$searchKey.'%')
            ->get();
        }else{
            $data=Contact::orderBy('contact_id','desc')->get();
        }

        $csvExporter = new \Laracsv\Export();
        $csvExporter->build($data, [
            'contact_id' => 'ID',
            'name' => ' Name',
            'email'=>'Email',
            'message'=>'Message',


        ]);

        $csvReader = $csvExporter->getReader();
        $csvReader->setOutputBOM(\League\Csv\Reader::BOM_UTF8);

        $filename = 'ContactList.csv';

        return response((string) $csvReader)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="'.$filename.'"');
    }
    // Get User Data
    private function requestUserData($request){
        return [
            'user_id'=>auth()->user()->id,
            'name'=>$request->name,
            'email'=>$request->email,
            'message'=>$request->message,
        ];
    }
}
