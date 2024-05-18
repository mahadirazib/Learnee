<?php

namespace App\Http\Controllers;

use App\Models\DepartmentFaculties;
use App\Models\DepartmentNotice;
use Illuminate\Http\Request;

use App\Models\Institute;
use App\Models\User;
use App\Models\InstituteDepartment;
use App\Models\InstituteFaculties;

class InstituteDepartmentController extends Controller
{
    public function index(Request $request, $institute_id){

        $department = InstituteDepartment::with('institute')
                    ->where('institute', $institute_id)->paginate();

        $institute = Institute::find($institute_id);
        $user = auth()->user();

        $is_admin = is_institute_admin($institute_id, $user->id);

        // dd($department);

        return view('institute.department.index', ['departments' => $department, 'institute'=> $institute, 'is_admin' => $is_admin]);
    }





    public function view(Request $request, $institute_id, $department_id){

        $department = InstituteDepartment::select('institute_departments.*', 'institutes.id as institute_id', 'institutes.name as institute_name', 'institutes.created_at as institute_created_at')
                ->join('institutes', 'institutes.id', '=', 'institute_departments.institute')
                ->where('institute_departments.id', $department_id)
                ->first();

        if($department->institute_id == $institute_id){            
            $user = auth()->user();
            $is_admin = is_institute_admin($institute_id, $user->id );
            $is_institute_member = is_institute_faculty_or_student($institute_id, $user->id );
            $is_department_member = is_department_faculty_or_student($institute_id, $department_id, $user->id );

            $notices = null;

            if($is_admin || $is_department_member){
                $notices = DepartmentNotice::where('department', $department->id)->paginate(4);
            }


            return view('institute.department.view', ['institute' => $institute_id, 'department'=> $department, 'notices' => $notices, 'is_admin' => $is_admin, 'is_institute_member'=> $is_institute_member, 'is_department_member' => $is_department_member ]);
        }else{
            return view('message', ['message'=> "Department and institute are mismatched."]);
        }

    }




    public function teacher_list_json(Request $request, $institute_id){

        $searchName = $request->search;
        
        $institute_id = (int)$institute_id;

        $users = User::select('users.*')
        ->join('institute_faculties', 'users.id', '=', 'institute_faculties.faculty')
        ->where('institute_faculties.institute', $institute_id)
        ->where(function ($query) use ($searchName) {
            $query->where('users.name', 'like', '%' . $searchName . '%')
                  ->orWhere('users.email', 'like', '%' . $searchName . '%');
        })
        ->get();

    
        return response()->json($users);
    }






    public function create(Request $request, $institute_id){
        $institute = Institute::find($institute_id);

        return view("institute.department.create", ["institute"=> $institute]);
    }




    public function store(Request $request, $institute_id){

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string',],
            'department_head' => ['nullable','numeric', 'exists:users,id'],
            'admins.*'=> ['nullable','numeric', 'exists:users,id'],
            'passkeys.*'=> ['nullable', 'string'],
            'subjects'=> [ 'nullable', 'json'],
        ]);

        $data['subjects'] = json_decode($request['subjects']);
        $user = auth()->user();
        $data['created_by'] = $user->id;


        $existing_department = InstituteDepartment::select('name')
                    ->where('institute', $institute_id)
                    ->where('name', $data['name'])
                    ->get();


        if(count($existing_department) <= 0){
            $data['institute'] = $institute_id;
            $institute_department = InstituteDepartment::create($data);
            
            return response()->json(["data" => $institute_department, "message" => "Department Created successfully"]);
        }else{
            return response()->json(["message" => "Department Already exists. Please chose another name."]);
        }

    }




    public function edit(Request $request, $institute_id, $department_id){

        $department = InstituteDepartment::find($department_id);
        $institute = Institute::find($institute_id);

        return view("institute.department.edit", ["institute"=> $institute, "department"=> $department]);
    }


    public function update(Request $request, $institute_id, $department_id){

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string',],
            'passkeys.*'=> ['nullable', 'string'],
            'subjects'=> [ 'nullable', 'json'],
        ]);

        $data['subjects'] = json_decode($request['subjects']);

        $department = InstituteDepartment::find($department_id);

        $department->name = $data['name'];
        $department->description = $data['description'];
        $department->passkeys = $data['passkeys'];
        $department->subjects = $data['subjects'];

        $department->update();


        return response()->json(["data"=> $data]);
    }


    public function destroy(Request $request){

    }




    


    public function join(Request $request, $institute_id, $department_id){
        $user = auth()->user();
        $user_id = $user->id;

        $department_passkeys = InstituteDepartment::select('passkeys')->where('id', $department_id)->first();

    
        if(is_institute_faculty_or_student($institute_id, $user_id )){
            if(!empty($department_passkeys->passkeys) && $department_passkeys->passkeys != null ){
                return view('institute.department.join', ['institute'=> $institute_id, 'department' => $department_id ]);
            }else{

                $department_faculty = DepartmentFaculties::create([
                    'faculty' => $user_id,
                    'department' => $department_id
                ]);

                return redirect()->route('institute.department.view-single', [$institute_id, $department_id])->with('success','Joined department successfully');
            }
        }else{
            return redirect()->route('institute.department.view-single', [$institute_id, $department_id])->with('failed','You are not a member of this institute. Please join this institute first to join this department.');
        }
        
    }





    public function join_confirm(Request $request, $institute_id, $department_id){
        $user = auth()->user();
        $user_id = $user->id;
        $department_passkeys = InstituteDepartment::select('passkeys')->where('id', $department_id)->first();

        $user_given_passkey = $request->validate([
            'passkey' => ['required', 'string', 'max:255']
        ]);

        // dd(in_array( $user_given_passkey['passkey'], $institute_passkeys->passkeys), $institute_passkeys->passkeys, "User given: ".$user_given_passkey['passkey']);

        if(in_array($user_given_passkey['passkey'], $department_passkeys->passkeys)){
            $department_faculty = DepartmentFaculties::create([
                'faculty' => $user_id,
                'department' => $department_id,
                'passkey_upon_joining' => $user_given_passkey['passkey']
            ]);

            return redirect()->route('institute.department.view-single', [$institute_id, $department_id])->with('success','Joined department successfully');
        }else{
            return redirect()->route('institute.department.view-single', [$institute_id, $department_id])->with('failed','Wrong passkey.');
        }

    }







}
