<?php


use Illuminate\Support\Facades\DB;


if(!function_exists("is_institute_admin")){
  function is_institute_admin($instituteId, $userId){
    $is_administrator = DB::table('institutes')
    ->where('id', $instituteId)
    ->where(function ($query) use ($userId) {
      $query->whereRaw('JSON_CONTAINS(admins, ?)', ["\"$userId\""])
      ->orWhereJsonContains('admins', '"'.$userId.'"')
      ->orWhereJsonContains('admins', $userId)
      ->orWhere('created_by', $userId)
      ->orWhere('institute_head', $userId);
    })->get();

    if(count($is_administrator) > 0){
      return true;
    }else{
      return false;
    }
  }
}




if(!function_exists("is_institute_faculty_or_student")){
  function is_institute_faculty_or_student($instituteId, $userId){
    // $is_administrator = DB::table('institutes')
    // ->where('id', $instituteId)
    // ->where(function ($query) use ($userId) {
    //   $query->whereRaw('JSON_CONTAINS(admins, ?)', ["\"$userId\""])
    //   ->orWhereJsonContains('admins', '"'.$userId.'"')
    //   ->orWhereJsonContains('admins', $userId)
    //   ->orWhere('created_by', $userId)
    //   ->orWhere('institute_head', $userId);
    // })->get();

    $is_administrator = is_institute_admin( $instituteId, $userId );

    $is_faculty = DB::table('institute_faculties')
            ->where('institute', $instituteId)
            ->where('faculty', $userId)
            ->get();

    $is_student = DB::table('institute_students')
            ->where('institute', $instituteId)
            ->where('student', $userId)
            ->get();

    if($is_administrator || (count($is_student) > 0) || (count($is_faculty) > 0)){
        return true;
    }else{
        return false;
    }


  }

}





if(!function_exists("is_department_admin")){
  function is_department_admin($instituteId, $deptId, $userId){

    if(is_institute_admin($instituteId, $userId)){
      return true;
    }else{

      if(!is_institute_faculty_or_student($instituteId, $userId)){
        return false;
      }
      
      $is_administrator = DB::table('institute_departments')
      ->where('id', $deptId)
      ->where('institute', $instituteId)
      ->where(function ($query) use ($userId) {
        $query->whereRaw('JSON_CONTAINS(admins, ?)', ["\"$userId\""])
        ->orWhereJsonContains('admins', '"'.$userId.'"')
        ->orWhereJsonContains('admins', $userId)
        ->orWhere('created_by', $userId)
        ->orWhere('department_head', $userId);
      })->get();

      if(count($is_administrator) > 0){
        return true;
      }else{
        return false;
      }
    }

    


  }

}




if(!function_exists("is_department_faculty_or_student")){
  function is_department_faculty_or_student($instituteId, $deptId, $userId){

    if(is_institute_admin($instituteId, $userId)){
      return true;
    }

    if(is_institute_faculty_or_student($instituteId, $userId)){

      $is_administrator = DB::table('institute_departments')
      ->where('id', $deptId)
      ->where('institute', $instituteId)
      ->where(function ($query) use ($userId) {
        $query->whereRaw('JSON_CONTAINS(admins, ?)', ["\"$userId\""])
        ->orWhereJsonContains('admins', '"'.$userId.'"')
        ->orWhereJsonContains('admins', $userId)
        ->orWhere('created_by', $userId)
        ->orWhere('department_head', $userId);
      })->get();
  
      $is_faculty = DB::table('department_faculties')
              ->where('department', $deptId)
              ->where('faculty', $userId)
              ->get();
  
      $is_student = DB::table('department_students')
              ->where('department', $deptId)
              ->where('student', $userId)
              ->get();


      if((count($is_administrator) > 0) || (count($is_student) > 0) || (count($is_faculty) > 0)){
          return true;
      }else{
          return false;
      }
    }else{
      return false;
    }


  }

}





