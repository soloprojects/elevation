<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Roles;
use App\Helpers\Utility;
use Auth;
use Log;
use View;
use Validator;
use Input;
use Hash;
use DB;
use App\Mail\Notify;
use App\Http\Requests;
use App\Models\Employees;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Mail;
use App\Helpers\FileManager;

class MembersController extends Controller
{

    public function __construct(){   

    }

    //
    public function index(Request $request)
    {
        //
        //$req = new Request();
        $mainData =  User::specialColumns('role_id',Utility::member);


        if ($request->ajax()) {
            return \Response::json(view::make('members.reload',array('mainData' => $mainData,))->render());

        }else{
            return view::make('members.main_view')->with('mainData',$mainData);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $validator = Validator::make($request->all(),User::$mainRules);
        if($validator->passes()){

                $dbDATA = [
                    'name' => ucfirst($request->input('name')),
                    'email' => ucfirst($request->input('email')),
                    'password' => Hash::make($request->input('password')),
                    'role_id' => $request->input('role_id'),                    
                    'remember_token' => $request->input('_token'),
                ];

                $createUser = User::create($dbDATA);
            
                //Mail::to($request->input('email'))->send(new GeneralMail($details));

                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);
        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editForm(Request $request)
    {
        //
        
        $Members = User::firstRow('id',$request->input('dataId'));
        //print_r($Members->userData->email);exit();
        return view::make('members.edit_form')->with('edit',$Members);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        $validator = Validator::make($request->all(),User::$mainRulesEdit);
        if($validator->passes()) {
            
            $new_password = Hash::make($request->input('password'));
            if($request->get('password') == ""){
                $new_password =  $request->input('prev_password');
            }
            
            $dbDATA = [
                'name' => ucfirst($request->input('name')),
                'email' => ucfirst($request->input('email')),
                'password' => $new_password,
            ];

            User::defaultUpdate('id', $request->input('user_id'), $dbDATA);     

                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);

        }
        $errors = $validator->errors();
        return response()->json([
            'message2' => 'fail',
            'message' => $errors
        ]);


    }

   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $idArray = json_decode($request->input('all_data'));
       
        foreach($idArray as $id){
            
            User::defaultDelete('id',$id);   
        }

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);

    }

    

}
