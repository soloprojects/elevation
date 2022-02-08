<?php
/**
 * Created by PhpStorm.
 * User: snweze
 * Date: 3/8/2018
 * Time: 9:22 AM
 */

namespace App\Helpers;

use App\model\VehicleFleetAccess;
use Illuminate\Http\Request;
use DB;
use Auth;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Mail;
use view;
use Illuminate\Support\Facades\Session;
use Psy\Exception\ErrorException;
use App\Mail\GeneralMail;

class Notify
{
    public static function GeneralMail($viewPage,$objContent,$email,$fullName ='',$subject = ''){

        Mail::to($email)->send(new GeneralMail($objContent));
    }   

}