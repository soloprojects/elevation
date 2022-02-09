<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Utility;

class EventAttendees extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function user(){
        return $this->belongsTo('App\models\User','user_id','id')->withDefault();
  
    }

    public function eventDetail(){
        return $this->belongsTo('App\models\Events','event_id','id')->withDefault();
  
    }
  
    public static function paginateAllData()
    {
        return static::OrderBy('id','DESC')->paginate('15');
        
    }
  
    public static function getAllData()
    {
        return static::OrderBy('id','DESC')->get();
  
    }
  
    public static function paginateData($column, $post)
    {
        return static::where($column , $post)->orderBy('id','DESC')->paginate('15');
  
    }    
  
  

}
