<?php

namespace App\Http\Controllers;

use App\Helpers\Notify;
use App\Models\Events;
use App\Models\EventAttendees;
use App\Helpers\Utility;
use App\Mail\GeneralMail;
use App\Models\User as ModelsUser;
use App\User;
use Auth;
use View;
use Validator;
use Input;
use Hash;
use DB;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Mail;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        //$req = new Request();
        $mainData = Events::paginateAllData();

        if ($request->ajax()) {
            return \Response::json(view::make('events.reload',array('mainData' => $mainData,))->render());

        }else{
            return view::make('events.main_view')->with('mainData',$mainData);
        }

    }

    public function allAttendees(Request $request, $id)
    {
        //
        //$req = new Request();
        $mainData = EventAttendees::paginateData('event_id',$id);
        
            return view::make('events.all_attendees')->with('mainData',$mainData);       

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $validator = Validator::make($request->all(),Events::$mainRules);
        if($validator->passes()){
            
            $startEvent = Utility::standardDate($request->input('start_date')).' '.$request->input('start_time');
            $endEvent = Utility::standardDate($request->input('end_date')).' '.$request->input('end_time');

            $countData = Events::countData('event_title',$request->input('event_title'));
            if($countData > 0){

                return response()->json([
                    'message' => 'good',
                    'message2' => 'Entry already exist, please try another entry'
                ]);

            }else{
                $dbDATA = [
                    'event_title' => ucfirst($request->input('event_title')),
                    'event_type' => $request->input('schedule_type'),
                    'start_event' => $startEvent,
                    'end_event' => $endEvent,
                    'event_desc' => $request->input('details'),
                    'user_id' => Auth::user()->id,
                    'status' => Utility::STATUS_ACTIVE
                ];
                Events::create($dbDATA);
               
                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);

            }
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
        $request = Events::firstRow('id',$request->input('dataId'));
        return view::make('events.edit_form')->with('edit',$request);

    }

    public function attendEventsForm(Request $request)
    {
        //
        $request = Events::firstRow('id',$request->input('dataId'));
        return view::make('events.attend_form')->with('edit',$request);

    }

    public function attendEvents(Request $request)
    {
        //        
            $dbDATA = [
                'event_id' => $request->input('edit_id'),
                'user_id' => $request->input('user_id'),
            ];
                     
                EventAttendees::create($dbDATA);

                $details = [

                    'title' => 'Mail from Elevation',
            
                    'message' => 'You just subscribed to an event in elevation church'
            
                ];
            $userDetail = ModelsUser::firstRow('id',$request->input('user_id'));
               
            
                Mail::to($userDetail->email)->send(new GeneralMail($details));
             
                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);
         
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
        $validator = Validator::make($request->all(),Events::$mainRulesEdit);
        if($validator->passes()) {

            $startEvent = Utility::standardDate($request->input('start_date')).' '.$request->input('start_time');
            $endEvent = Utility::standardDate($request->input('end_date')).' '.$request->input('end_time');

            $dbDATA = [
                'event_title' => ucfirst($request->input('event_title')),
                'start_event' => $startEvent,
                'end_event' => $endEvent,
                'event_desc' => $request->input('details'),
            ];
            $rowData = Events::specialColumns('event_title', $request->input('event_title'));
            if(count($rowData) > 0){
                if ($rowData[0]->id == $request->input('edit_id')) {

                    Events::defaultUpdate('id', $request->input('edit_id'), $dbDATA);
                
                    return response()->json([
                        'message' => 'good',
                        'message2' => 'saved'
                    ]);

                } else {
                    return response()->json([
                        'message' => 'good',
                        'message2' => 'Entry already exist, please try another entry'
                    ]);

                }

            } else{
                Events::defaultUpdate('id', $request->input('edit_id'), $dbDATA);
             
                return response()->json([
                    'message' => 'good',
                    'message2' => 'saved'
                ]);
            }
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
        $dbData = [
            'status' => Utility::STATUS_DELETED
        ];
        $delete = Events::massUpdate('id',$idArray,$dbData);

        return response()->json([
            'message2' => 'deleted',
            'message' => 'Data deleted successfully'
        ]);


    }

}
