<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Institute;
use App\Models\User;
use App\Models\InstituteDepartment;
use App\Models\DepartmentClassroom;
use App\Models\ClassroomFaculties;
use App\Models\ClassroomStudents;
use App\Models\ClassroomNotice;

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

        if(count($other_faculties)){
            foreach ($request->other_faculties as $key => $value) {
    
                $arr = array(
                    'faculty' => $value,
                    'institute' => $data['institute'],
                    'department' => $data['department'],
                    'classroom' => $classroom->id,
                    'passkey_upon_joining' => 'Upon_Creating_Classroom'
                );
    
                array_push($faculties_to_store, $arr);
            }
    
            ClassroomFaculties::insert($faculties_to_store);
        }

        // dd($faculties_to_store, $other_faculties, $request->other_faculties);
        
        return redirect()->route('institute.department.classroom.view', ['institute_id' => $institute_id, 'department_id' => $department_id, 'classroom_id' => $classroom->id ]);
    }





    public function view($institute_id, $department_id, $classroom_id){

        $classroom = DepartmentClassroom::where('id', $classroom_id)->first();

        if($classroom->department != $department_id || $classroom->institute != $institute_id){
            // return view('message', ['message'=> "information are mismatched."]);
            return redirect()->back()->with('failed', "Information are mismatched.");
        }
        
        $is_class_member = is_classroom_faculty_or_student($institute_id, $department_id, $classroom_id, auth()->user()->id);

        $is_admin = false;
        $notices = null;
        if($is_class_member){
            $is_admin = is_classroom_admin($institute_id, $department_id, $classroom_id, auth()->user()->id);
            $notices = ClassroomNotice::where('classroom', $classroom_id)->orderBy('updated_at', 'desc')->paginate(4, ['*'], 'notice');
        }
        $department = InstituteDepartment::select('institute_departments.*', 'institutes.id as institute_id', 'institutes.name as institute_name', 'institutes.created_at as institute_created_at')
        ->join('institutes', 'institutes.id', '=', 'institute_departments.institute')
        ->where('institute_departments.id', $department_id)
        ->first();

        return view('institute.classroom.view', ['department' => $department, 'classroom' => $classroom, 'notices' => $notices, 'is_admin' => $is_admin, 'is_class_member' => $is_class_member]);
    }




    public function list(Request $request, $institute_id, $department_id){

        $department = InstituteDepartment::select('institute_departments.*', 'institutes.id as institute_id', 'institutes.name as institute_name', 'institutes.created_at as institute_created_at')
        ->join('institutes', 'institutes.id', '=', 'institute_departments.institute')
        ->where('institute_departments.id', $department_id)
        ->first();

        $classes = DepartmentClassroom::where('department', $department_id)->paginate(20);
        $is_admin = is_department_admin($institute_id, $department_id, auth()->user()->id );

        return view('institute.classroom.list', ['department' => $department, 'classes' => $classes, 'is_admin' => $is_admin]);
    }



    public function join(Request $request, $institute_id, $department_id, $classroom_id){

        $department = InstituteDepartment::select('institute_departments.*', 'institutes.id as institute_id', 'institutes.name as institute_name', 'institutes.created_at as institute_created_at')
        ->join('institutes', 'institutes.id', '=', 'institute_departments.institute')
        ->where('institute_departments.id', $department_id)
        ->first();

        $user = auth()->user();
        $user_id = $user->id;

        $class_passkeys = DepartmentClassroom::select('passkeys')->where('id', $classroom_id)->first();

    
        if(is_department_faculty_or_student($institute_id, $department_id, $user_id )){

            if(!empty($class_passkeys->passkeys) && $class_passkeys->passkeys != null ){

                return view('institute.classroom.join', ['institute'=> $institute_id, 'department' => $department_id, 'classroom' => $classroom_id ]);

            }else{
                
                if($user->account_type == 'Faculty'){
                    $department_faculty = ClassroomFaculties::create([
                        'faculty' => $user_id,
                        'institute' => $institute_id,
                        'department' => $department_id,
                        'classroom' => $classroom_id,
                        'passkey_upon_joining' => 'Passkey_Were_Blank'
                    ]);
                }else{
                    $department_student = ClassroomStudents::create([
                        'student' => $user_id,
                        'institute' => $institute_id,
                        'department' => $department_id,
                        'classroom' => $classroom_id,
                        'passkey_upon_joining' => 'Passkey_Were_Blank'
                    ]);
                }

                return redirect()->route('institute.department.classroom.view', [$institute_id, $department_id, $classroom_id])->with('success','Joined classroom successfully');
            }
        }else{
            return redirect()->route('institute.department.classroom.view', [$institute_id, $department_id, $classroom_id])->with('failed','You are not a member of this department. Please join this department first to join the classroom.');
        }
        
    }




    public function join_confirm(Request $request, $institute_id, $department_id, $classroom_id){
        $user = auth()->user();
        $user_id = $user->id;
        
        $user_given = $request->validate([
            'passkey' => ['required', 'string', 'max:255']
        ]);

        $classroom_passkeys = DepartmentClassroom::select('passkeys')->where('id', $classroom_id)->first();

        // dd(in_array( $user_given_passkey['passkey'], $institute_passkeys->passkeys), $institute_passkeys->passkeys, "User given: ".$user_given_passkey['passkey']);

        if(in_array($user_given['passkey'], $classroom_passkeys->passkeys)){

            if($user->account_type == 'Faculty'){
                $department_faculty = ClassroomFaculties::create([
                    'faculty' => $user_id,
                    'institute' => $institute_id,
                    'department' => $department_id,
                    'classroom' => $classroom_id,
                    'passkey_upon_joining' => $user_given['passkey']
                ]);
            }else{
                $department_student = ClassroomStudents::create([
                    'student' => $user_id,
                    'institute' => $institute_id,
                    'department' => $department_id,
                    'classroom' => $classroom_id,
                    'passkey_upon_joining' => $user_given['passkey']
                ]);
            }

            return redirect()->route('institute.department.classroom.view', [$institute_id, $department_id, $classroom_id])->with('success','Joined classroom successfully');
        }else{
            return redirect()->route('institute.department.classroom.view', [$institute_id, $department_id, $classroom_id])->with('failed','Wrong passkey.');
        }
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
