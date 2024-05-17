<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Institute;
use App\Models\InstituteNotice;

class InstituteNoticeController extends Controller
{
    public function index(Request $request, $id){

        $institute = Institute::find($id);
        $notices = InstituteNotice::where("institute", $institute->id)->orderBy("created_at", "desc")->paginate(10);

        $is_admin = false;
        $is_admin = is_institute_admin($id, auth()->user()->id);

        return view("institute.notice.notice-all", ["institute"=> $institute,"notices"=> $notices, "is_admin"=> $is_admin, "is_member"=> false]);
    }




    public function view(Request $request, $instituteId, $noticeId){
        
        $notice = InstituteNotice::select('institute_notices.*', 'users.name')
                    ->join('users', 'users.id', '=', 'institute_notices.given_by')
                    ->where('institute_notices.id','=', $noticeId)
                    ->first();

        // dd($notice, $notice->id, $instituteId);
        if($notice->institute == $instituteId){
            $institute = Institute::find($instituteId);
        }else{
            return view('message', ['message'=> "Notice and institutes are mismatched."]);
        }

        $user = auth()->user();
        $is_admin = is_institute_admin($instituteId, $user->id );

        return view('institute.notice.notice-single-show', ['institute'=>$institute, 'notice'=> $notice, 'is_admin' => $is_admin ]);
    }




    public function create(Request $request, $id){

        $institute = Institute::find($id);

        return view("institute.notice.notice-create", ["institute"=> $institute]);
    }


    public function store(Request $request, $instituteId){
        $user = auth()->user();
        $userId = $user->id;

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'notice' => ['required', 'string',],
        ]);


        if(is_institute_admin( $instituteId, $userId )){
            
            $notice = InstituteNotice::create([
                'title' => $data['title'],
                'notice'=> $data['notice'],
                'given_by' => $userId,
                'institute' => $instituteId,
            ]);

            return redirect()->route('institute.notice.single', [$instituteId, $notice])->with('success','Notice Created successfully');
            // dd($request->title, $request->notice);
        }else{
            return redirect()->route('institute.notice.all', $instituteId)->with('failed','Something went wrong. make sure that you are an admin of this institute?');
        }
    }

    
    public function edit(Request $request, $instituteId, $noticeId){
        $institute = Institute::find($instituteId);
        $notice = InstituteNotice::find($noticeId);
        
        return view('institute.notice.notice-edit', ['institute'=>$institute, 'notice'=>$notice]);
    }




    public function update(Request $request, $instituteId, $noticeId){
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'notice' => ['required', 'string',],
        ]);
        $user = auth()->user();
        if(is_institute_admin( $instituteId, $user->id )){
            $notice = InstituteNotice::find($noticeId);
            $notice->title = $data['title'];
            $notice->notice = $data['notice'];
            $notice->update();

            return redirect()->route('institute.notice.single', [$instituteId, $notice])->with('success','Notice Updated successfully');
        }else{
            return redirect()->route('institute.notice.single', [$instituteId, $noticeId])->with('failed','Something went wrong. Are you an admin of this institute?');
        }
    }

    public function destroy(Request $request, $instituteId, $noticeId){
        $user = auth()->user();
        if(is_institute_admin( $instituteId, $user->id )){
            $notice = InstituteNotice::find($noticeId);
            $notice->delete();
            return redirect()->route('institute.notice.all', [$instituteId])->with('success','Notice Deleted Successfully');
        }else{
            return redirect()->route('institute.notice.single', [$instituteId, $noticeId])->with('failed','Something went wrong. Are you an admin of this institute?');
        }
    }




}
