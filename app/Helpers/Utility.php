<?php

namespace App\Helpers;


class Utility{

   const superAdmin = 1, admin = 2, member = 3;
   const GENERAL_SCHEDULE = 2, MY_SCHEDULE = 1;    //FOR EVENT MODULE
   const STATUS_INACTIVE = 2, STATUS_ACTIVE = 1, STATUS_DELETED = 0;
   const EVENT_TYPE = [1 => 'My Schedule', 2 => 'General Schedule'];   //FOR EVENT MODULE

   public static function IMG_URL($image = ''){
      return public_path() . '/images/'.$image;
  }

  public static function FILE_URL($file = ''){
      return public_path() . '/files/'.$file;
  }

  public static function AUDIO_URL(){
      return public_path() . '/audio/';
  }

  public static function standardDate($date){
    if($date != ''){
        $newDate = date("Y-m-d", strtotime($date));
        return $newDate;
    }
    return $date;

}

public static function standardDateTime($date){
    $newDate = date("Y-m-d H:i:s", strtotime($date));
    return $newDate;
}

public static function eventType($reportType){
    if($reportType == 1){
        return 'My Schedule';
    }
    return 'General Schedule';
}


}