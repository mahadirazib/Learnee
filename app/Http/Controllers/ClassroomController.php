<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Institute;
use App\Models\User;
use App\Models\InstituteDepartment;
use App\Models\DepartmentClassroom;
use App\Models\ClassroomFaculties;



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


    public function store(Request $request, $institute_id, $department_id){

        // dd($request->all());

        $data = $request->validate([
            'institute' => ['required', 'exists:App\Models\Institute,id'],
            'department' => ['required', 'exists:App\Models\InstituteDepartment,id'],
            'name' => ['required'],
            'description' => ['required'],
            'main_faculty' => ['required', 'exists:App\Models\User,id'],
            'passkeys' => ['required', 'array' ],
            'topics' => ['required', 'array' ],
            'exam_types' => ['required', 'array' ],
        ]);

        $data['created_by'] = auth()->user()->id;
        $data['status'] = true;

        $classroom = DepartmentClassroom::create($data);
        
        $other_faculties = $request->validate([
            'other_faculties' => ['nullable', 'array'],
            'other_faculties.*' => ['exists:App\Models\User,id']
        ]);

        $faculties_to_store = [];

        foreach ($request->other_faculties as $key => $value) {

            $arr = array(
                'faculty' => $value,
                'institute' => $data['institute'],
                'department' => $data['department'],
                'classroom' => $classroom->id,
                'passkey_upon_joining' => 'Upon Creating Classroom'
            );

            array_push($faculties_to_store, $arr);
        }

        ClassroomFaculties::insert($faculties_to_store);

        // dd($faculties_to_store, $other_faculties, $request->other_faculties);
        
        $department = InstituteDepartment::select('institute_departments.*', 'institutes.id as institute_id', 'institutes.name as institute_name', 'institutes.created_at as institute_created_at')
        ->join('institutes', 'institutes.id', '=', 'institute_departments.institute')
        ->where('institute_departments.id', $department_id)
        ->first();

        return view('institute.classroom.view', ['department' => $department, 'classroom' => $classroom]);
    }




    public function teacher_list_json(Request $request, $institute_id, $department_id){

        $searchName = $request->search;
        
        $department_id = (int)$department_id;

        $users = User::select('users.*')
        ->join('department_faculties', 'users.id', '=', 'department_faculties.faculty')
        ->where('department_faculties.department', $department_id)
        ->where(function ($query) use ($searchName) {
            $query->where('users.name', 'like', '%' . $searchName . '%')
                  ->orWhere('users.email', 'like', '%' . $searchName . '%');
        })
        ->get();

        $instituteAdminsId = Institute::select('admins')
        ->where('id', $institute_id)
        ->first();

        $instituteAdminsArray = array_map('intval', $instituteAdminsId->admins);

        $admins = User::whereIn('id', $instituteAdminsArray)
        ->where(function ($query) use ($searchName) {
            $query->where('name', 'like', '%' . $searchName . '%')
                ->orWhere('email', 'like', '%' . $searchName . '%');
        })
        ->get();


        $departmentAdminsId = InstituteDepartment::select('admins')
        ->where('id', $department_id)
        ->first();

        $departmentAdminsArray = array_map('intval', $departmentAdminsId->admins);

        $departmentAdmins = User::whereIn('id', $departmentAdminsArray)
                ->where(function ($query) use ($searchName) {
                    $query->where('name', 'like', '%' . $searchName . '%')
                        ->orWhere('email', 'like', '%' . $searchName . '%');
                })
                ->get();


        $users = $users->merge($admins)->unique('id');
        $allUsers = $users->merge($departmentAdmins)->unique('id');


        return response()->json($allUsers);
    }


}
