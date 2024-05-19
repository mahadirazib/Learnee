<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Institute;
use Illuminate\Support\Facades\DB;



class InstituteChangeAdminController extends Controller
{
    public function institute_admin_list(Request $request, $institute_id){

        $admins = DB::table('institutes')
        ->join('users', function ($join) {
            $join->on('institutes.admins', 'like', DB::raw('CONCAT("%", CONCAT(\'"\', users.id, \'"\'), "%")'));
        })
        ->where('institutes.id', '=', $institute_id)
        ->select(
            // 'users.id as user_id', 
            'users.*',
            )
        ->get();


        $institute = DB::table('institutes')
        ->leftJoin('users as created_by_users', 'institutes.created_by', '=', 'created_by_users.id')
        ->leftJoin('users as institute_head_users', 'institutes.institute_head', '=', 'institute_head_users.id')
        ->where('institutes.id', '=', $institute_id)
        ->select(
            'institutes.id as id',
            'institutes.name as name',
            'institutes.description as description',
            'institutes.created_at as created_at',
            'created_by_users.id as owner_id',
            'created_by_users.name as owner_name',
            'created_by_users.email as owner_email',
            'created_by_users.mobile_number as owner_mobile_number',
            'created_by_users.image as owner_image',
            'institute_head_users.id as institute_head_id',
            'institute_head_users.name as institute_head_name',
            'institute_head_users.email as institute_head_email',
            'institute_head_users.mobile_number as institute_head_mobile_number',
            'institute_head_users.image as institute_head_image'
        )
        ->first();


        return view('institute.admin_faculty_student.admin-list', ['institute'=> $institute, 'admins' => $admins ]);

    }



    public function institute_admin_update(Request $request, $institute_id){

        $data = $request->validate([
            'admins' => ['required', 'array']
        ]);

        
        $institute = Institute::find( $institute_id );
        $institute->admins = array_unique($data['admins']);
        $institute->update();
        
        return redirect()->route('institute.admin.list', $institute)->with('success','Admin added successfully');

    }


    public function institute_admin_delete(Request $request, $institute_id, $user_id){
        
        $institute = Institute::find( $institute_id );
        $admins = $institute->admins;
        

        $key = array_search($user_id, $admins);

        if ($key !== false) {
            unset($admins[$key]);
        }

        $admins = array_values($admins);

        $institute = Institute::find( $institute_id );
        $institute->admins = $admins;
        $institute->update();

        return redirect()->route('institute.admin.list', $institute)->with('success','Admin deleted successfully');
    }




}
