<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\Institute;

class InstituteAdmin
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

        if(isset($institute->admins)){
            if(in_array($user_id, $institute->admins) || ($user_id==$institute->created_by) || ($user_id==$institute->institute_head)){
                return $next($request);
            }
        }else{
            if(($user_id==$institute->created_by) || ($user_id==$institute->institute_head)){
                return $next($request);
            }
        }

        return abort(403);
    }
}
