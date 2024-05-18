<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DepartmentAdmin
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
        $department_id = $request->route('department_id');

        if(is_department_admin($institute_id, $department_id, $user_id)){
            return $next($request);
        }

        return abort(403);
    }
}
