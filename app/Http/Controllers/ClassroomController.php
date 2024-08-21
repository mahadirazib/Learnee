<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Institute;
use App\Models\User;
use App\Models\InstituteDepartment;
use App\Models\DepartmentNotice;



class ClassroomController extends Controller
{
    
    
    public function create(Request $request, $institute_id, $department_id){
        
        $institute = [];

        $department = InstituteDepartment::select('institute_departments.*', 'institutes.id as institute_id', 'institutes.name as institute_name', 'institutes.created_at as institute_created_at')
        ->join('institutes', 'institutes.id', '=', 'institute_departments.institute')
        ->where('institute_departments.id', $department_id)
        ->first();

        return view('institute.classroom.create', ['institute' => $institute, 'department' => $department]);
    }


}
