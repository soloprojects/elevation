<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\Utility;

class Events extends Model
{
    use HasFactory;

  //
  protected  $table = 'events';
    
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $guarded = [];

  public static $mainRules = [
      'event_title' => 'required',
      'schedule_type' => 'required',
      'start_date' => 'required',
      'end_date' => 'required',
      'start_time' => 'required',
      'end_time' => 'required',
  ];
  
  public static $mainRulesEdit = [
    'event_title' => 'required',
    'start_date' => 'required',
    'end_date' => 'required',
    'start_time' => 'required',
    'end_time' => 'required',
];
  public function user(){
      return $this->belongsTo('App\models\User','user_id','id')->withDefault();

  }

  public static function paginateAllData()
  {
      return static::where('status', '=',Utility::STATUS_ACTIVE)->orderBy('id','DESC')->paginate('15');
      
  }

  public static function getAllData()
  {
      return static::where('status', '=','1')->orderBy('id','DESC')->get();

  }

  public static function paginateData($column, $post)
  {
      return static::where('status', '=','1')->where($column , $post)->orderBy('id','DESC')->paginate('15');

  }    

  public static function countData($column, $post)
  {        
      return static::where('status', '=',Utility::STATUS_ACTIVE)->count();
  }

  public static function specialColumns($column, $post)
  {
      //Utility::specialColumns(self::table(),$column, $post);
      return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->orderBy('id','DESC')->get();

  }

  public static function specialColumnsDate($column, $post,$column2,$post2)
  {
      //Utility::specialColumns(self::table(),$column, $post);
      return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
          ->where($column2, '>=',$post2)->orderBy('id','DESC')->get();

  }

  public static function specialColumnsMass($column, $post)
  {
      //Utility::specialColumns(self::table(),$column, $post);
      return static::where('status', '=',Utility::STATUS_ACTIVE)->whereIn($column,$post)->orderBy('id','DESC')->get();

  }

  public static function specialColumnsPage($column, $post)
  {
      //Utility::specialColumns(self::table(),$column, $post);
      return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->orderBy('id','DESC')->paginate('15');

  }

  public static function specialColumns2($column, $post, $column2, $post2)
  {
      //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
      return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column,$post)
          ->where($column2,$post2)->orderBy('id','DESC')->get();

  }

  public static function specialColumnsPage2($column, $post, $column2, $post2)
  {
      //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
      return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
          ->where($column2, '=',$post2)->orderBy('id','DESC')->paginate('15');

  }

  public static function specialColumns3($column, $post, $column2, $post2, $column3, $post3)
  {
      //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
      return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
          ->where($column2, '=',$post2)->where($column3, '=',$post3)->orderBy('id','DESC')->get();

  }

  public static function specialColumnsPage3($column, $post, $column2, $post2, $column3, $post3)
  {
      //return Utility::specialColumns2(self::table(),$column, $post, $column2, $post2);
      return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
          ->where($column2, '=',$post2)->where($column3, '=',$post3)->orderBy('id','DESC')->paginate('15');

  }

 

  public static function firstRow($column, $post)
  {
      //return Utility::firstRow(self::table(),$column, $post);
      return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)->first();

  }

  public static function firstRow2($column, $post2,$column2, $post)
  {
      return static::where('status', '=',Utility::STATUS_ACTIVE)->where($column, '=',$post)
          ->where($column2, '=',$post2)->first();

  }

  public static function massUpdate($column, $arrayPost, $arrayDataUpdate=[])
  {
      return static::whereIn($column , $arrayPost)->update($arrayDataUpdate);

  }

  public static function defaultUpdate($column, $postId, $arrayDataUpdate=[])
  {

      return static::where($column , $postId)->update($arrayDataUpdate);

  }

}
