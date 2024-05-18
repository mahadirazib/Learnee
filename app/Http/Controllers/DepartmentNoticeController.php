<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Institute;
use App\Models\User;
use App\Models\InstituteDepartment;
use App\Models\DepartmentNotice;


class DepartmentNoticeController extends Controller
{
    public function index(Request $request, $institute_id, $department_id)
    {
        $user = auth()->user();
        $user_id = $user->id;

        $department = InstituteDepartment::select('institute_departments.*', 'institutes.id as institute_id', 'institutes.name as institute_name', 'institutes.created_at as institute_created_at')
        ->join('institutes', 'institutes.id', '=', 'institute_departments.institute')
        ->where('institute_departments.id', $department_id)
        ->first();

        $notices = DepartmentNotice::where('department', $department_id)->paginate();

        $is_admin = is_department_admin( $institute_id, $department_id, $user_id);

        return view('institute.department_notice.notice-all', ['department' => $department, 'notices' => $notices, 'is_admin' => $is_admin]);
    }


    public function create(Request $request, $institute_id, $department_id)
    {

        $department = InstituteDepartment::select('institute_departments.*', 'institutes.id as institute_id', 'institutes.name as institute_name', 'institutes.created_at as institute_created_at')
            ->join('institutes', 'institutes.id', '=', 'institute_departments.institute')
            ->where('institute_departments.id', $department_id)
            ->first();

        return view('institute.department_notice.notice-create', ['department' => $department]);
    }



    public function store(Request $request, $institute_id, $department_id)
    {
        $user = auth()->user();
        $userId = $user->id;

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'notice' => ['required', 'string',],
        ]);


        if (is_department_admin($institute_id, $department_id, $userId)) {

            $notice = DepartmentNotice::create([
                'title' => $data['title'],
                'notice' => $data['notice'],
                'given_by' => $userId,
                'department' => $department_id,
            ]);

            return redirect()->route('institute.department.notice.single', [$institute_id, $department_id, $notice])->with('success', 'Notice Created successfully');
            // dd($request->title, $request->notice);
        } else {
            return redirect()->route('institute.department.notice.all', [$institute_id, $department_id])->with('failed', 'Something went wrong. make sure that you are an admin of this institute?');
        }
    }



    public function view(Request $request, $institute_id, $department_id, $notice_id){

        $notice = DepartmentNotice::select('department_notices.*', 'users.name')
                    ->join('users', 'users.id', '=', 'department_notices.given_by')
                    ->where('department_notices.id','=', $notice_id)
                    ->first();

        // dd($notice, $notice->id, $instituteId);
        if($notice->department == $department_id){
            $department = InstituteDepartment::select('institute_departments.*', 'institutes.id as institute_id', 'institutes.name as institute_name', 'institutes.created_at as institute_created_at')
            ->join('institutes', 'institutes.id', '=', 'institute_departments.institute')
            ->where('institute_departments.id', $department_id)
            ->first();

        }else{
            return view('message', ['message'=> "Notice and institutes are mismatched."]);
        }

        $user = auth()->user();
        $is_admin = is_department_admin($institute_id, $department_id, $user->id);

        return view('institute.department_notice.notice-single-show', ['department'=>$department, 'notice'=> $notice, 'is_admin' => $is_admin ]);


    }


    public function update(Request $request, $institute_id, $department_id, $notice_id)
    {
    }



}
