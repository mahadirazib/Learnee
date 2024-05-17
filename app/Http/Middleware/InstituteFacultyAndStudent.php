<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Institute;
use App\Models\InstituteFaculties;
use App\Models\InstituteStudents;

class InstituteFacultyAndStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user_id = $request->user()->id;
        $institute_id = $request->route('institute_id');
        $institute = Institute::find($institute_id);
        $institute_faculty = InstituteFaculties::where('faculty', $user_id)->where('institute', $institute_id)->get();
        $institute_student = InstituteStudents::where('student', $user_id)->where('institute', $institute_id)->get();
        $is_admin = false;
        if(isset($institute->admins)){
            if(in_array($user_id, $institute->admins)){
                $is_admin = true;
            }
        }

        if( $is_admin || ($user_id==$institute->created_by) || ($user_id==$institute->institute_head)){
            return $next($request);
        }elseif($institute_faculty->isNotEmpty()){
            return $next($request);
        }elseif($institute_student->isNotEmpty()){
            return $next($request);
        }


        return abort(403);
    }
}
