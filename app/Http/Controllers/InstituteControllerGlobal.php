<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Institute;

class InstituteControllerGlobal extends Controller
{
    public function index(Request $request){

        $query = $request["query"];
        $search_institute = null;
        if($query != null && $query != ""){
            $search_institute = Institute::where("name","LIKE","%".$query."%")
            ->orderBy( 'created_at', 'desc')->paginate(20, ['id', 'name', 'description'], 'search_institute_page');
        }
        // dd($query);

        $latest_institute = Institute::orderBy( 'created_at', 'desc')->paginate(6, ['id', 'name', 'description'], 'latest_institute_page');
        $popular_institute = Institute::select('id', 'name', 'description')->paginate(6, ['id','name','description'], 'popular_institute_page');

        return view('global.institute.global-search', ['search_institutes' => $search_institute, 'latest_institutes'=> $latest_institute, 'popular_institutes'=> $popular_institute, 'query' => $query]);
    }
}
