<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\PublicPost;


class PublicPostController extends Controller
{
    public function create(Request $request){

        $user = auth()->user();

        $data = $request->validate([
            'title' => 'required|string|max:100',
            'post' => 'nullable|string',
            'files.*' => 'nullable|mimes:pdf,doc,docx,csv,txt,png,jpg,jpeg,gif,zip|max:2048'
        ]);
        // if($request->hasFile('files')){
        //     // foreach ($request->file('files') as $file) {
        //     //     // $path = $file->store('uploads');
        //     // }
        //     echo "there is a file";
        // }

        $file_names = [];

        if ($request->hasFile('files')) {
            $images = $request->file('files');
            foreach ($images as $image) {
                // Generate a unique filename for each image
                $filename = time() . uniqid() . "_" . $image->getClientOriginalName();
                $filename_array = [$image->getClientOriginalName(), $filename];

                array_push($file_names, $filename_array);

                // Save the image to the storage disk
                $image->storeAs('public/public_post_files', $filename);
            }
        }


        PublicPost::create([
            'user' => auth()->user()->id ,
            'title' => $data['title'] ,
            'post' => $data['post'] ,
            'files' => $file_names 
        ]);

        return redirect()->back()->with('success', "Post created successfully");
    }






    public function getFileType($filePath) {

        return mime_content_type(public_path('storage/public_post_files/' . $filePath));
    }







}
