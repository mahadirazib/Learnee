<?php

namespace App\Http\Controllers;

use App\Models\InstituteDepartment;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;


class DepartmentChangeAdminController extends Controller
{
    public function dept_admin_list(Request $request, $institute_id, $department_id){

        $admins = DB::table('institute_departments')
        ->join('users', function ($join) {
            $join->on('institute_departments.admins', 'like', DB::raw('CONCAT("%", CONCAT(\'"\', users.id, \'"\'), "%")'));
        })
        ->where('institute_departments.id', '=', $department_id)
        ->select(
            'users.*',
            )
        ->get();
        

        $department = DB::table('institute_departments')
        ->leftJoin('institutes', 'institute_departments.institute', '=', 'institutes.id')
        ->leftJoin('users as creator_users', 'institute_departments.created_by', '=', 'creator_users.id')
        ->leftJoin('users as department_head_users', 'institute_departments.department_head', '=', 'department_head_users.id')
        ->where('institute_departments.id', '=', $department_id)
        ->select(
            'institute_departments.id as id',
            'institute_departments.name as name',
            'institute_departments.description as description',
            'institute_departments.created_at as created_at',
            'institutes.id as institute_id',
            'institutes.name as institute_name',
            'creator_users.id as creator_id',
            'creator_users.name as creator_name',
            'creator_users.email as creator_email',
            'creator_users.mobile_number as creator_mobile_number',
            'creator_users.image as creator_image',
            'department_head_users.id as department_head_id',
            'department_head_users.name as department_head_name',
            'department_head_users.email as department_head_email',
            'department_head_users.mobile_number as department_head_mobile_number',
            'department_head_users.image as department_head_image'
        )
        ->first();


        $user = auth()->user();
        
        $is_creator = false;
        $is_head = false;
        $is_institute_admin = is_institute_admin($institute_id, $user->id);

        if($user->id == $department->creator_id){
            $is_creator = true;
        }

        if($user->id == $department->department_head_id){
            $is_head = true;
        }

        return view('institute.admin_faculty_student.department-admin-list', ['department'=> $department, 'admins' => $admins, 'is_institute_admin'=> $is_institute_admin, 'is_creator' => $is_creator, 'is_head'=> $is_head]);
    }



    public function dept_admin_update(Request $request, $institute_id, $department_id){
        
        $data = $request->validate([
            'admins' => ['required', 'array']
        ]);

        $dept = InstituteDepartment::find( $department_id );
        $dept->admins = array_unique($data['admins']);
        $dept->update();
        
        return redirect()->route('institute.department.admin.list', [$institute_id, $dept])->with('success','Admins added successfully');
    }




    public function dept_creator_update(Request $request, $institute_id, $department_id){

        $data = $request->validate([
            'new_creator' => ['required', 'numeric']
        ]);

        $department = InstituteDepartment::find( $department_id );
        $new_creator = $request->new_creator;

        $user = auth()->user();

        if(is_institute_admin($institute_id, $user->id)){
            $department->created_by = $new_creator;
            $department->update();

            return redirect()->route('institute.department.admin.list', [$institute_id, $department])->with('success','Department Founder changed successfully');
        }else{
            return redirect()->route('institute.department.admin.list', [$institute_id, $department])->with('failed','Something went wrong');
        }
    }




    public function dept_head_update(Request $request, $institute_id, $department_id){
        $data = $request->validate([
            'new_head' => ['required', 'numeric']
        ]);

        $department = InstituteDepartment::find( $department_id );
        $new_head = $request->new_head;

        $user = auth()->user();

        if(is_institute_admin($institute_id, $user->id) || $user->id == $department->created_by){

            $department->department_head = $new_head;
            $department->update();

            return redirect()->route('institute.department.admin.list', [$institute_id, $department])->with('success','Department Head changed successfully');
        }else{
            return redirect()->route('institute.department.admin.list', [$institute_id, $department])->with('failed','Something went wrong');
        }
    }




    public function dept_admin_delete(Request $request, $institute_id, $department_id){

        $department = InstituteDepartment::find( $department_id );
        $admins = $department->admins;
        
        $data = $request->validate([
            'admin_to_delete' => ['required', 'numeric']
        ]);

        $user = auth()->user();

        if(is_institute_admin($institute_id, $user->id) || $user->id == $department->created_by){

            $key = array_search($request->admin_to_delete, $admins);

            if ($key !== false) {
                unset($admins[$key]);
            }
    
            $admins = array_values($admins);
    
            $department->admins = $admins;
            $department->update();

            return redirect()->route('institute.department.admin.list', [$institute_id, $department])->with('success','Admin deleted successfully');
        }else{
            return redirect()->route('institute.department.admin.list', [$institute_id, $department])->with('failed','Something went wrong');
        }

    }







}
