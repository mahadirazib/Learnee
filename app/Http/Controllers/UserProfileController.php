<?php

namespace App\Http\Controllers;


use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;


class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $user = auth()->user();
        return view("profile.index", ["user"=> $user]);
    }



    public function show($id)
    {
        $user = auth()->user();
        return view("profile.index", ["user"=> $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $user = auth()->user();
        return view("profile.edit", ["user"=> $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'profile_picture' => ['nullable', 'image','mimes:jpeg,png,jpg,gif,svg'],
        ]);



        if ($request->hasFile('profile_picture')) {
            $file_name = time().uniqid().".".$request->file('profile_picture')->getClientOriginalExtension();
            $request->file('profile_picture')->storeAs('profile_pictures', $file_name,'public');
            $data['image'] = $file_name;

            $user = User::find($id);
            if(isset($user->image)){
                $image_path = public_path('storage/profile_pictures/'.$user->image);
                if(file_exists($image_path)){
                    unlink($image_path);
                }
            }
            
            $user->update($data);
        }


        return redirect()->route('profile.index')->with('success','Updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    
    public function destroy($id): View
    {
        return view('message', ['message'=> "Currently unavailable."]);
    }
    
    


}
