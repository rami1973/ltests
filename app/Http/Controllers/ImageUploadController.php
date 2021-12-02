<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Carbon\Carbon ;

class ImageUploadController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function imageUpload()
    {
        $images=Storage::disk('oci')->allFiles();

        return view('imageUpload')->with('images', $images);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function imageUploadPost(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = 'test'.time().'.'.$request->image->extension();

     //   $path = Storage::disk('oci')->put('images', $request->image,$imageName);
        $path = Storage::disk('oci')->putFileAs('images',$request->image,$imageName ,'private');

        //$path = Storage::disk('oci')->url($path);
        $url = Storage::disk('oci')->temporaryUrl(
            $path, Carbon::now()->addMinutes(5)
         );
        /* Store $imageName name in DATABASE from HERE */
        //$images=Storage::disk('oci')->allFiles('images');
        $images=Storage::disk('oci')->files('images');

        return back()
            ->with('success','You have successfully upload image.')
            ->with('image', $url)
            ->with('images', $images);
    }
}
