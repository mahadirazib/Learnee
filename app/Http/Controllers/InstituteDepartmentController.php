<?php

namespace App\Http\Controllers;

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

        $is_admin = is_department_faculty_or_student($institute_id, $user->id);

        // dd($department);

        return view('institute.department.index', ['departments' => $department, 'institute'=> $institute, 'is_admin' => $is_admin]);
    }





    public function view(Request $request, $institute_id, $department_id){

        // $department = InstituteDepartment::with('institute')
        //             ->where('id', $department_id)->first();

        $department = InstituteDepartment::select('institute_departments.*', 'institutes.id as institute_id', 'institutes.name as institute_name', 'institutes.created_at as institute_created_at')
                ->join('institutes', 'institutes.id', '=', 'institute_departments.institute')
                ->where('institute_departments.id', $department_id)
                ->first();

        // dd($department->name, $department->institute_name);

        if($department->institute_id == $institute_id){            
            $user = auth()->user();
            $is_admin = is_institute_admin($institute_id, $user->id );
            $is_member = is_institute_faculty_or_student($institute_id, $user->id );

            $notices = DepartmentNotice::where('department', $department->id)->paginate(4);

            // $department['subjects'] = json_decode($department->subjects);

            return view('institute.department.view', ['department'=> $department, 'notices' => $notices, 'is_admin' => $is_admin, 'is_member'=> $is_member, 'institute' => $institute_id]);
        }else{
            return view('message', ['message'=> "Department and institute are mismatched."]);
        }

    }




    public function teacher_list_json(Request $request, $institute_id){

        $searchName = $request->search;
        
        $searchName = $request['search'];
        $institute_id = (int)$institute_id;
        // return response()->json(['search by'=>$searchName, 'institute'=> $institute_id ]);

        $users = User::select('users.*')
        ->join('institute_faculties', 'users.id', '=', 'institute_faculties.faculty')
        ->where('institute_faculties.institute', $institute_id)
        ->where(function ($query) use ($searchName) {
            $query->where('users.name', 'like', '%' . $searchName . '%')
                  ->orWhere('users.email', 'like', '%' . $searchName . '%');
        })
        ->get();



        // $users = User::select('users.*')
        //     ->join('institute_faculties', 'users.id', '=', 'institute_faculties.faculty')
        //     ->where('institute_faculties.institute', $institute_id)
        //     ->where('users.name', 'like', '%' . $searchName . '%')
        //     ->get();
    
        return response()->json($users);
    }






    public function create(Request $request, $institute_id){
        $institute = Institute::find($institute_id);


        // $subjects = [];
        // $random_Subjects = ["Anthropology", "Archaeology", "History", "Philosophy", "Religion", "The Arts", "Economics", "Geography", "Political Science", "Psychology"];
        // for ($i = 0; $i < rand(1, 20); $i++){
        //     $subject_name = $random_Subjects[random_int(0, 9)];
        //     $subject_reward = random_int(1,3)." ".["Credits", "Marks", "Points"][random_int(0, 2)];
        //     $subjects[$subject_name] = $subject_reward;
        // }

        // dd($subjects);

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


        $existing_department = InstituteDepartment::select('name')
                    ->where('institute', $institute_id)
                    ->where('name', $data['name'])
                    ->get();

        // return response()->json(["data" => count($existing_department)]);

        if(count($existing_department) <= 0){
            $data['institute'] = $institute_id;
            $institute_department = InstituteDepartment::create($data);
            
            return response()->json(["data" => $institute_department, "message" => "Department Created successfully"]);
        }else{
            return response()->json(["message" => "Department Already exists. Please change the name."]);
        }

        // return redirect()->route('institute.view-single', $institute_id)->with('success','Department created successfully');
    }


    public function update(Request $request){

    }


    public function destroy(Request $request){

    }
}
