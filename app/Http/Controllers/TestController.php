<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;


use Illuminate\Http\Request;
use App\Models\Institute;
use App\Models\InstituteFaculties;
use App\Models\User;
use App\Models\InstituteNotice;

class TestController extends Controller
{
    public function test( Request $request){

        // $user = auth()->user();
        // $instituteId = 24;
        // $userId = 9;

        echo 'You are a member';


        // $subjects = [];
        // $random_Subjects = ["Anthropology", "Archaeology", "History", "Philosophy", "Religion", "The Arts", "Economics", "Geography", "Political Science", "Psychology", "Sociology", "Biology", "Chemistry", "Earth Science", "Physics", "Computer Science", "Mathematics", "Statistics", "Divinity", "Education", "Medicine", "Military Science", "Public Health", "Engineering", "Law", "Business Administration", "Environmental Science", "Linguistics", "Literature", "Music", "Theater", "Film Studies", "Communication", "Social Work", "Nursing", "Architecture", "Urban Planning", "Astronomy", "Nutrition", "Fine Arts", "Design", "Anthropology", "Criminology", "Gender Studies", "Ethics", "International Relations", "Philology", "Sports Science", "Cognitive Science", "Environmental Studies", "Geology", "Oceanography", "Materials Science", "Biochemistry", "Biomedical Engineering", "Political Economy", "Religious Studies", "Health Sciences", "Information Technology", "Robotics", "Data Science", "Neuroscience", "Paleontology", "Meteorology", "Actuarial Science", "Forensic Science", "Industrial Design", "Fashion Design", "Tourism Management", "Hospitality Management", "Library Science", "Archival Studies", "Cultural Studies", "Development Studies", "Peace and Conflict Studies", "Ethnomusicology", "Food Science", "Gerontology", "Human Rights", "Marine Biology", "Molecular Biology", "Parapsychology", "Quantum Physics", "Renewable Energy", "Space Science", "Zoology"];
        // for ($i = 0; $i < rand(1, 20); $i++){
        //     $subject_name = $random_Subjects[random_int(0, 75)];
        //     $subject_reward = random_int(1,3)." ".["Credits", "Marks", "Points"][random_int(0, 2)];
        //     $subjects[$subject_name] = $subject_reward;
        // }

        // dd($subjects);


        // $institute_users = Institute::find($institute_id)->faculty()
        //         ->where(function ($query) use ($searchName) {
        //             $query->where('users.name', 'like', '%' . $searchName . '%')
        //                 ->orWhere('users.email', 'like', '%' . $searchName . '%');
        //         })->get();

        // dd($institute_users);

        // foreach($institute_users as $user){
        //     echo $user->id.': User name:'.$user->name;
        // }
        
        // $searchName = $request['searchName'];
        // $institute_id = 228;

        // $users = User::select('users.*')
        // ->join('institute_faculties', 'users.id', '=', 'institute_faculties.faculty')
        // ->where('institute_faculties.institute', $institute_id)
        // ->where(function ($query) use ($searchName) {
        //     $query->where('users.name', 'like', '%' . $searchName . '%')
        //           ->orWhere('users.email', 'like', '%' . $searchName . '%');
        // })
        // ->get();

        dd(is_department_faculty_or_student(3, 7, 5));

        // dd( is_institute_admin($instituteId, $userId) );
        // return view('test', ['institute'=> $institute]);
    }
}
