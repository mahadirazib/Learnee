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



class ClassroomNoticeController extends Controller
{
    public function list(Request $request, $institute_id, $department_id, $class_id)
    {
        $classroom = DepartmentClassroom::join('institutes', 'department_classrooms.institute', '=', 'institutes.id')
        ->join('institute_departments', 'department_classrooms.department', '=', 'institute_departments.id')
        ->select('department_classrooms.*', 'institutes.name as institute_name', 'institute_departments.name as department_name')
        ->where('department_classrooms.id', $class_id)
        ->first();

        if($classroom->department == $department_id && $classroom->institute == $institute_id){

            $is_admin = is_classroom_admin($institute_id, $department_id, $class_id, auth()->user()->id);
            
            $notices = ClassroomNotice::where('classroom', $class_id)->orderBy('updated_at', 'desc')->paginate(10);
            
            return view('institute.classroom.notice.list', ['classroom' => $classroom, 'notices' => $notices, 'is_admin' => $is_admin]);
        }

        return redirect()->back()->with('failed', "Information mismatch.");
    }



    public function view(Request $request, $institute_id, $department_id, $class_id, $notice_id)
    {
        $classroom = DepartmentClassroom::join('institutes', 'department_classrooms.institute', '=', 'institutes.id')
        ->join('institute_departments', 'department_classrooms.department', '=', 'institute_departments.id')
        ->select('department_classrooms.*', 'institutes.name as institute_name', 'institute_departments.name as department_name')
        ->where('department_classrooms.id', $class_id)
        ->first();

        // dd($classroom);

        if($classroom->department == $department_id && $classroom->institute == $institute_id){

            $is_admin = is_classroom_admin( $institute_id, $department_id, $class_id, auth()->user()->id );

            // $notice = ClassroomNotice::where('id', $notice_id)->first();
            $notice = ClassroomNotice::select('classroom_notices.*', 'users.name')
            ->join('users', 'users.id', '=', 'classroom_notices.given_by')
            ->where('classroom_notices.id','=', $notice_id)
            ->first();

            return view('institute.classroom.notice.view', ['classroom' => $classroom, 'notice' => $notice, 'is_admin' => $is_admin]);
        }

        // return redirect()->back()->with('failed', "Information mismatch.");
    }



    public function create(Request $request, $institute_id, $department_id, $class_id)
    {
        $classroom = DepartmentClassroom::join('institutes', 'department_classrooms.institute', '=', 'institutes.id')
        ->join('institute_departments', 'department_classrooms.department', '=', 'institute_departments.id')
        ->select('department_classrooms.*', 'institutes.name as institute_name', 'institute_departments.name as department_name')
        ->where('department_classrooms.id', $class_id)
        ->first();
        
        if($classroom->department == $department_id && $classroom->institute == $institute_id){
            return view('institute.classroom.notice.create', ['classroom' => $classroom]);
        }

        return redirect()->back()->with('failed', "Information mismatch.");

    }


    public function store(Request $request, $institute_id, $department_id, $class_id)
    {
        $classroom = DepartmentClassroom::where('id', $class_id)->first();

        if($classroom->department == $department_id && $classroom->institute == $institute_id){

            $user = auth()->user();
            $userId = $user->id;

            $data = $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'notice' => ['required', 'string',],
            ]);
    
            if (is_classroom_admin($institute_id, $department_id, $class_id, $userId)) {

                $notice = ClassroomNotice::create([
                    'title' => $data['title'],
                    'notice' => $data['notice'],
                    'given_by' => $userId,
                    'classroom' => $class_id,
                ]);

                return redirect()->route('institute.department.classroom.notice.view', [$institute_id, $department_id, $class_id, $notice->id])->with('success', 'Notice Created successfully');

            } else {
                return redirect()->back()->with('failed', "Something went wrong.....");
            }

        }

        return redirect()->back()->with('failed', "Information mismatch.");

    }





    public function delete(Request $request, $institute_id, $department_id, $class_id, $notice_id){
        $is_admin = is_classroom_admin($institute_id, $department_id, $class_id, auth()->user()->id);
        if($is_admin){
            $notice = ClassroomNotice::findOrFail($notice_id)->delete();
            return redirect()->back()->with('success', 'Notice Deleted Successfully!');
        }

        return redirect()->back()->with('failed', 'Something went wrong!');
    }




}
