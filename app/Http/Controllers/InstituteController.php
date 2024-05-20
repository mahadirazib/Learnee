<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Institute;
use App\Models\InstituteFaculties;
use App\Models\InstituteStudents;
use App\Models\User;
use App\Models\InstituteNotice;
use App\Models\InstituteDepartment;

class InstituteController extends Controller
{
    public function index(Request $request){

        $user = auth()->user();
        $userId = $user->id;

        if($user->account_type == "Faculty") {
            $administrative = DB::table('institutes')
            ->whereRaw('JSON_CONTAINS(admins, ?)', ["\"$userId\""])
            ->orWhereJsonContains('admins', '"'.$userId.'"')
            ->orWhereJsonContains('admins', $userId)
            ->orWhere('created_by', $userId)
            ->orWhere('institute_head', $userId)
            ->get();


            if($administrative->isEmpty()){
                $administrative = null;
            }

                
            // $institutes = User::find($user->id)->institutes;

            // General faculty role 
            $institutes = Institute::select('institutes.id', 'institutes.name', 'institutes.description')
                ->join('institute_faculties', 'institute_faculties.institute', '=', 'institutes.id')
                ->join('users', 'institute_faculties.faculty', '=', 'users.id')
                ->where('users.id', $userId)
                ->where(function ($query) use ($userId) {
                    $query->whereRaw('NOT JSON_CONTAINS(admins, ?)', ['"'.$userId.'"'])
                          ->orWhereJsonDoesntContain('admins', '"'.$userId.'"')
                          ->orWhereJsonDoesntContain('admins', $userId)
                          ->orWhere('institute_head', '!=', $userId)
                          ->orWhere('institute_head', '!=', $userId)
                          ->orWhere('created_by', '!=', $userId);
                })
                ->distinct()
                ->get();
                        

            if($institutes->isEmpty()){
                $institutes = null;
            }

    
            return view('institute.index-for-faculty', ['administrative_access'=> $administrative, 'general_access' => $institutes]);

        }else{

            $institutes = Institute::select('institutes.id', 'institutes.name', 'institutes.description')
                ->join('institute_students', 'institute_students.institute', '=', 'institutes.id')
                ->join('users', 'institute_students.student', '=', 'users.id')
                ->where('users.id', $userId)
                ->distinct()
                ->get();
                
            return view('institute.index-for-student', ['general_access' => $institutes]);
        }

        // return view('message', ['message'=> "Something went wrong!"]);

    }



    public function create(Request $request){
        return view('institute.create');
    }




    public function store(Request $request){

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg'],
            'description' => ['required', 'string',],
            'institute_head' => ['nullable','numeric', 'exists:users,id'],
            'admins.*'=> ['nullable','numeric', 'exists:users,id'],
            'passkeys.*'=> ['nullable', 'string'],
            'emails.*'=> [ 'required', 'string','email'],
            'mobile_numbers.*'=> ['nullable', 'string', 'regex:/^\+?\d+$/'],
            'address_1' => ['nullable', 'string', 'max:255'],
            'address_2' => ['nullable', 'string', 'max:255'],
        ]);


        $image_names = array();

        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                // Generate a unique filename for each image
                $filename = time() . uniqid() . "." . $image->getClientOriginalName();

                array_push($image_names, $filename);

                // Save the image to the storage disk
                $image->storeAs('public/institute_images', $filename);
            }
        }


        $institute = Institute::create([
            'name' => $request->name,
            'images' => $image_names,
            'description' => $request->description,
            'created_by' => auth()->user()->id,
            'institute_head' => (int)($request->institute_head),
            'admins' => $request->admins,
            'passkeys' => $request->passkeys,
            'emails' => $request->emails,
            'mobile_numbers' => $request->mobile_numbers,
            'address_one' => $request->address_1,
            'address_two' => $request->address_2
        ]);
        $institute->save();

        return response()->json(["data" => $institute]);
    }



    public function edit(Request $request, $id){
        $institute = Institute::find( $id );
        // dd( $institute->name );

        return view('institute.edit', ['institute' => $institute]);
    }



    public function update(Request $request, $id){
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string',],
            'passkeys.*'=> ['nullable', 'string'],
            'emails.*'=> [ 'required', 'string','email'],
            'mobile_numbers.*'=> ['nullable', 'string', 'regex:/^\+?\d+$/'],
            'address_1' => ['nullable', 'string', 'max:255'],
            'address_2' => ['nullable', 'string', 'max:255'],
        ]);

        $institute = Institute::find( $id );

        $institute->name = $data['name'];
        $institute->description = $data['description'];
        $institute->passkeys = $data['passkeys'];
        $institute->emails = $data['emails'];
        $institute->mobile_numbers = $data['mobile_numbers'];
        $institute->address_one = $data['address_1'];
        $institute->address_two = $data['address_2'];

        $institute->update();

        // dd($request->name, $request->description, $request->emails, $request->passkeys, $request->mobile_numbers, $request->address_1, $request->address_2);
        return redirect()->route('institute.view-single', $institute)->with('message','Institute info Updated successfully');
        
    }



    public function teacher_list_json(Request $request){
        // $users = User::where([
        //     ['email', 'like','%'.$request->search.'%'],  
        //     ['account_type', '=', '0']])
        //     ->get();

        $searchName = $request->search;

        $users = User::select('name', 'email', 'id')
            ->where('account_type', 0)
            ->where(function ($query) use ($searchName) {
                $query->where('name', 'like', '%' . $searchName . '%')
                    ->orWhere('email', 'like', '%' . $searchName . '%');
            })
            ->get();

        return response()->json($users);
    }



    
    // Show single institute 
    public function show_single(Request $request, $id){

        $institute = Institute::find($id);
        $user = auth()->user();
        $userId = $user->id;

        // Set admin status for this institute
        $is_admin = is_institute_admin($id, $userId);
        $admins = [];
        $notices = null;


        $is_member = is_institute_faculty_or_student( $id, $userId);
        if($is_member){
            $notices = InstituteNotice:: where('institute','=', $id)->orderBy('updated_at','desc')->paginate(4);
        }


        $departments = InstituteDepartment::where('institute','=', $id)->paginate(4);
        

        return view('institute.show-single', ['institute' => $institute, 'is_admin' => $is_admin, 'is_member' => $is_member, 'notices' => $notices, 'departments'=> $departments]);
    }




    public function join(Request $request, $id){
        $user = auth()->user();
        $user_id = $user->id;
        $institute_passkeys = Institute::select('passkeys')->where('id', $id)->first();

        if($user->account_type == 'Faculty'){
            $is_institute_member = InstituteFaculties::select('*')
                            ->where('institute', $id)
                            ->where('faculty', $user_id)
                            ->get();
            if($is_institute_member->isEmpty()){
                if(!empty($institute_passkeys->passkeys) && $institute_passkeys->passkeys != null ){
                    return view('institute.join', ['institute'=> $id]);
                }else{
                    $institute_faculty = InstituteFaculties::create([
                        'faculty' => $user_id,
                        'institute' => $id
                    ]);

                    return redirect()->route('institute.view-single', $id)->with('success','Joined institute successfully');
                }
            }else{
                return redirect()->route('institute.view-single', $id)->with('failed','You are already a member');
            }
        }else{
            $is_institute_member = InstituteStudents::select('*')
                            ->where('institute', $id)
                            ->where('student', $user_id)
                            ->get();
            if($is_institute_member->isEmpty()){
                if(!empty($institute_passkeys->passkeys) && $institute_passkeys->passkeys != null ){
                    return view('institute.join', ['institute'=> $id]);
                }else{
                    $institute_faculty = InstituteStudents::create([
                        'student' => $user_id,
                        'institute' => $id
                    ]);

                    return redirect()->route('institute.view-single', $id)->with('success','Joined institute successfully');
                }
            }else{
                return redirect()->route('institute.view-single', $id)->with('failed','You are already a member');
            }
        }
        
    }



    public function join_confirm(Request $request, $id){
        $user = auth()->user();
        $user_id = $user->id;
        $institute_id = $id;
        $institute_passkeys = Institute::select('passkeys')->where('id', $institute_id)->first();

        $user_given_passkey = $request->validate([
            'passkey' => ['required', 'string', 'max:255']
        ]);

        // dd(in_array( $user_given_passkey['passkey'], $institute_passkeys->passkeys), $institute_passkeys->passkeys, "User given: ".$user_given_passkey['passkey']);

        if(in_array($user_given_passkey['passkey'], $institute_passkeys->passkeys)){

            $user = auth()->user();
            
            if($user->account_type == 'Faculty'){
                $institute_faculty = InstituteFaculties::create([
                    'faculty' => $user_id,
                    'institute' => $institute_id,
                    'passkey_upon_joining' => $user_given_passkey['passkey']
                ]);
            }else{
                $institute_student = InstituteStudents::create([
                    'student' => $user_id,
                    'institute' => $institute_id,
                    'passkey_upon_joining' => $user_given_passkey['passkey']
                ]);
            }

            return redirect()->route('institute.view-single', $institute_id)->with('success','Joined institute successfully');
        }else{
            return redirect()->route('institute.view-single', $institute_id)->with('failed','Wrong passkey.');
        }

    }















}
