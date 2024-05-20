<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\Institute;

class InstituteOwnerAndHead
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


        if(isset($institute->created_by)){
            if($user_id==$institute->created_by){
                return $next($request);
            }
        }
        
        if(isset($institute->institute_head)){
            if($user_id==$institute->institute_head){
                return $next($request);
            }
        }

        return abort(403);
    }

    
}
