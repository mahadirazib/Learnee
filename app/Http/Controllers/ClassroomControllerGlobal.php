<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Institute;
use App\Models\User;
use App\Models\InstituteDepartment;
use App\Models\DepartmentClassroom;
use App\Models\DepartmentFaculties;
use App\Models\ClassroomFaculties;
use App\Models\ClassroomStudents;
use App\Models\DepartmentStudents;

class ClassroomControllerGlobal extends Controller
{

    public function index(){
        $user = auth()->user();
        $userId = $user->id;

        if($user->account_type == 'Faculty'){

            // Check if the user is an admin of any institute or department
            $instituteAdmin = Institute::where(function ($query) use ($userId) {
            $query->whereRaw('JSON_CONTAINS(admins, ?)', ["\"$userId\""])
            ->orWhereJsonContains('admins', '"'.$userId.'"')
            ->orWhereJsonContains('admins', $userId)
            ->orWhere('created_by', $userId)
            ->orWhere('institute_head', $userId);
            })->get();

            $departmentAdmin = InstituteDepartment::where(function ($query) use ($userId) {
                $query->whereRaw('JSON_CONTAINS(admins, ?)', ["\"$userId\""])
                ->orWhereJsonContains('admins', '"'.$userId.'"')
                ->orWhereJsonContains('admins', $userId)
                ->orWhere('created_by', $userId)
                ->orWhere('department_head', $userId);
            })->get();


            $instituteClassrooms = DepartmentClassroom::whereIn('department_classrooms.institute', $instituteAdmin->pluck('id'))
            ->join('institute_departments', 'department_classrooms.department', '=', 'institute_departments.id')
            ->join('institutes', 'department_classrooms.institute', '=', 'institutes.id')
            ->select(
                'department_classrooms.*', 
                'institute_departments.name as department_name', 
                'institutes.name as institute_name'
            )
            ->get();
            $departmentClassrooms = DepartmentClassroom::whereIn('department_classrooms.department', $departmentAdmin->pluck('id'))
            ->join('institute_departments', 'department_classrooms.department', '=', 'institute_departments.id')
            ->join('institutes', 'department_classrooms.institute', '=', 'institutes.id')
            ->select(
                'department_classrooms.*', 
                'institute_departments.name as department_name', 
                'institutes.name as institute_name'
            )
            ->get();
            $classroom_head_or_main = DepartmentClassroom::where('department_classrooms.main_faculty', $userId)->orWhere('department_classrooms.created_by', $userId)
            ->join('institute_departments', 'department_classrooms.department', '=', 'institute_departments.id')
            ->join('institutes', 'department_classrooms.institute', '=', 'institutes.id')
            ->select(
                'department_classrooms.*', 
                'institute_departments.name as department_name', 
                'institutes.name as institute_name'
            )
            ->get();

            $mergedResults = $instituteClassrooms->merge($departmentClassrooms)->merge($classroom_head_or_main);


            $perPage = 10; // Define the number of items per page
            $currentPage = LengthAwarePaginator::resolveCurrentPage(); // Get the current page from the request (default is 1)

            $classroom_admin = new LengthAwarePaginator(
                $mergedResults->forPage($currentPage, $perPage),
                $mergedResults->count(),
                $perPage,
                $currentPage,
                ['path' => LengthAwarePaginator::resolveCurrentPath()]
            );


            $classroom_faculty = ClassroomFaculties::where('faculty', $userId)
            ->join('department_classrooms', 'classroom_faculties.classroom', '=', 'department_classrooms.id')
            ->join('institute_departments', 'department_classrooms.department', '=', 'institute_departments.id')
            ->join('institutes', 'department_classrooms.institute', '=', 'institutes.id')
            ->select(
                'department_classrooms.*', 
                'institute_departments.name as department_name', 
                'institutes.name as institute_name'
            )
            ->whereNotIn('department_classrooms.institute', $instituteAdmin->pluck('id'))
            ->whereNotIn('department_classrooms.department', $departmentAdmin->pluck('id'))
            ->paginate(10, ['*'], 'general');

            // dd($departmentAdmin->pluck('id'));

            return view('classroom.index', ['general_access' => $classroom_faculty, 'admin_access' => $classroom_admin]);
            
        }else{
            $enrolled_class = ClassroomStudents::where('student', $user->id)
            ->join('department_classrooms', 'classroom_students.classroom', '=', 'department_classrooms.id')
            ->join('institute_departments', 'department_classrooms.department', '=', 'institute_departments.id')
            ->join('institutes', 'department_classrooms.institute', '=', 'institutes.id')
            ->select(
                'department_classrooms.*', 
                'institute_departments.name as department_name', 
                'institutes.name as institute_name'
            )
            ->get();

            // dd($enrolled_class);
            return view('classroom.index', ['general_access' => $enrolled_class, 'admin_access' => null ]);
        }

        

    }


    public function search(Request $request){

        $query = $request["query"];
        $search_classroom = null;

        if($query != null && $query != ""){

            $user = auth()->user();
            $userId = $user->id;

            if($user->account_type == 'Faculty'){

                $instituteAdmin = Institute::where(function ($query) use ($userId) {
                $query->whereRaw('JSON_CONTAINS(admins, ?)', ["\"$userId\""])
                ->orWhereJsonContains('admins', '"'.$userId.'"')
                ->orWhereJsonContains('admins', $userId)
                ->orWhere('created_by', $userId)
                ->orWhere('institute_head', $userId);
                })->get();

                $departmentAdmin = InstituteDepartment::where(function ($query) use ($userId) {
                    $query->whereRaw('JSON_CONTAINS(admins, ?)', ["\"$userId\""])
                    ->orWhereJsonContains('admins', '"'.$userId.'"')
                    ->orWhereJsonContains('admins', $userId)
                    ->orWhere('created_by', $userId)
                    ->orWhere('department_head', $userId);
                })->get();
                
                $departmentFaculty = DepartmentFaculties::where('faculty', $userId)
                ->join('institute_departments', 'department_faculties.department', '=', 'institute_departments.id')
                ->get();


                $instituteAdminClassrooms = DepartmentClassroom::whereIn('department_classrooms.institute', $instituteAdmin->pluck('id'))
                ->join('institute_departments', 'department_classrooms.department', '=', 'institute_departments.id')
                ->join('institutes', 'department_classrooms.institute', '=', 'institutes.id')
                ->select(
                    'department_classrooms.*', 
                    'institute_departments.name as department_name', 
                    'institutes.name as institute_name'
                )
                ->where("department_classrooms.name","LIKE","%".$query."%")
                ->get();
                $departmentAdminClassrooms = DepartmentClassroom::whereIn('department_classrooms.department', $departmentAdmin->pluck('id'))
                ->join('institute_departments', 'department_classrooms.department', '=', 'institute_departments.id')
                ->join('institutes', 'department_classrooms.institute', '=', 'institutes.id')
                ->select(
                    'department_classrooms.*', 
                    'institute_departments.name as department_name', 
                    'institutes.name as institute_name'
                )
                ->where("department_classrooms.name","LIKE","%".$query."%")
                ->get();
                $departmentFacultyClassrooms = DepartmentClassroom::whereIn('department_classrooms.department', $departmentFaculty->pluck('id'))
                ->join('institute_departments', 'department_classrooms.department', '=', 'institute_departments.id')
                ->join('institutes', 'department_classrooms.institute', '=', 'institutes.id')
                ->select(
                    'department_classrooms.*', 
                    'institute_departments.name as department_name', 
                    'institutes.name as institute_name'
                )
                ->where("department_classrooms.name","LIKE","%".$query."%")
                ->get();
                $classroom_head_or_main = DepartmentClassroom::where('department_classrooms.main_faculty', $userId)->orWhere('department_classrooms.created_by', $userId)
                ->join('institute_departments', 'department_classrooms.department', '=', 'institute_departments.id')
                ->join('institutes', 'department_classrooms.institute', '=', 'institutes.id')
                ->select(
                    'department_classrooms.*', 
                    'institute_departments.name as department_name', 
                    'institutes.name as institute_name'
                )
                ->where("department_classrooms.name","LIKE","%".$query."%")
                ->get();

                $search_classroom = $instituteAdminClassrooms->merge($departmentAdminClassrooms)->merge($departmentFacultyClassrooms)->merge($classroom_head_or_main);

                // dd($search_classroom);
                
            }else{

                $departmentStudent = DepartmentStudents::where('student', $userId)
                ->join('institute_departments', 'department_students.department', '=', 'institute_departments.id')
                ->get();

                $search_classroom = DepartmentClassroom::whereIn('department', $departmentStudent->pluck('id'))
                ->join('institute_departments', 'department_classrooms.department', '=', 'institute_departments.id')
                ->join('institutes', 'department_classrooms.institute', '=', 'institutes.id')
                ->select(
                    'department_classrooms.*', 
                    'institute_departments.name as department_name', 
                    'institutes.name as institute_name'
                )
                ->where("department_classrooms.name","LIKE","%".$query."%")
                ->get();
            }

            // $search_classroom = Institute::where("name","LIKE","%".$query."%")
            // ->orderBy( 'created_at', 'desc')->paginate(20, ['id', 'name', 'description'], 'search_classroom_page');
        }
        // dd($query);

        return view('global.classroom.global-search', ['search_classroom' => $search_classroom, 'query' => $query]);
    }


}
